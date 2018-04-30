<?php

use Illuminate\Http\Request;

Route::group(['middleware' => ['jwt.auth'], 'prefix'=>'admins'], function() {

    Route::get('/', function(Request $request) {
        if(!Auth::user()) response()->json(['error'=>'Not allowed'], 403);

        $limit = $request->input('limit', 50);
        $sort = $request->input('sort', '+name');
        $order = getOrderBy($sort);

        $name = $request->input('name');
        $email = $request->input('email');

        $q = DB::table('users')
            ->where('group', '=', 100)
            ->select('id', 'name', 'email');

        if($name) $q->where('users.name', 'like', '%'.$name.'%');
        if($email) $q->where('users.email', 'like', '%'.$email.'%');

        $result = $q->orderBy($order[0], $order[1])
            ->paginate($limit);

        return response()->json($result);

    });

    Route::get('/{id}', function($id, Request $request) {
        if(!Auth::user()->is_admin) response()->json(['error'=>'Not allowed'], 403);

        if($id === '0') return response()->json(new App\Tenant);

        $tenant = App\Tenant::find($id);
        if(!$tenant) return response()->json(['error'=>'Record not found'], 404);

        $tenant->user;

        return response()->json($tenant);
    });

    Route::post('/{id}', function($id, Request $request) {
        if(!Auth::user()->is_admin) response()->json(['error'=>'Not allowed'], 403);

        $model = $id === '0' ? new App\Tenant : App\Tenant::find($id);
        if(!$model) return response()->json(['error'=>'Record not found'], 404);
        $user = $model->user ?: new App\User;


        $userFields = $request->only('name', 'email', 'password');
        $tenantFields = $request->only('company', 'plan_id');

        $rules = [
            'name' => 'required|max:255|unique:users,name,'.$user->id,
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
        ];
        if($id === '0') {
            $rules['password'] = 'required|max:255';
        }
        $validator = Validator::make($userFields, $rules);
        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $rules = [
            'company' => 'required|max:255|unique:tenants,name,'.$id,
            'plan_id' => 'required'
        ];
        $validator = Validator::make($tenantFields, $rules);
        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        if(isset($userFields['password'])) $userFields['password'] = Hash::make($userFields['password']);


        $user->fill($userFields);
        $model->name = $tenantFields['company'];
        $model->plan_id = $tenantFields['plan_id'];
        $model->save();
        $model->user()->save($user);

        return response()->json($user);
    });

    Route::delete('/{ids}', function($ids, Request $request) {
        if(!Auth::user()->is_admin) response()->json(['error'=>'Not allowed'], 403);
        $ids = explode(',', $ids);

        App\Tenant::destroy($ids);

        return response()->json(['ids'=>$ids]);
    });

    Route::get('/{id}/settings', function($id, Request $request) {
        $user = Auth::user();
        if(!$user->is_admin || !$user->is_tenant) response()->json(['error'=>'Not allowed'], 403);
        if($user->is_tenant) $id = $user->userable->id; // for a tenant, allways return it's own

        $tenant = App\Tenant::find($id);
        // $ret = [
        //     'planOptions' => $tenant->plan->options,
        //     'userOptions' => $tenant->planOptions,
        //     'customization' => $tenant->customization && $tenant->customization->options ? json_decode($tenant->customization->options) : null,
        //     'logo' => $tenant->customization && $tenant->customization->logo ? asset($tenant->customization->logo) : null
        // ];

        return response()->json($tenant->customization);
    });

    Route::post('/{id}/settings', function($id, Request $request) {
        $user = Auth::user();
        if(!$user->is_admin || !$user->is_tenant) response()->json(['error'=>'Not allowed'], 403);
        if($user->is_tenant) $id = $user->userable->id; // for a tenant, allways return it's own

        $tenant = App\Tenant::find($id);
        $customization = $tenant->customization ?: new App\Customization;
        $customization->options = json_encode($request->input('options'));
        $tenant->customization()->save($customization);

        $tmpLogo = $request->input('tmpLogo');
        if($tmpLogo) {
            try {
                $dest = logoName($tmpLogo, 'tenant', $id);
                if($customization->logo && Storage::exists($customization->logo)) Storage::delete($customization->logo);
                Storage::move($tmpLogo, $dest);
                $customization->logo = $dest;
                $customization->save();
            } catch (Exception $e) {
                response()->json(['Logo could not be saved'], 500);
            }

        }

        $ret = [
            'customization' => $tenant->customization ?: null,
            'logo' => $tenant->customization->logo ? asset($tenant->customization->logo) : null,
        ];

        return response()->json($ret);

    });

});