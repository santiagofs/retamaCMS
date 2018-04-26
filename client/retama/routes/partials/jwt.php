<?php

use Illuminate\Http\Request;

Route::post('/register', function(Request $request) {
    return response()->json(['error' => 'Autoregister is disabled'], 403);

    $credentials = $request->only('name', 'email', 'password');

    $rules = [
        'name' => 'required|max:255|unique:users',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|max:255',
    ];

    $validator = Validator::make($credentials, $rules);

    if($validator->fails()) {
        return response()->json(['success'=> false, 'error'=> $validator->messages()]);
    }

    $name = $request->name;
    $email = $request->email;
    $password = $request->password;

    App\User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password)]);

    // return $this->login($request);
    return response()->json(['success' => true, 'message'=> "You have successfully register."]);
});

Route::post('/login', function(Request $request, Auth $auth) {
    $credentials = $request->only('email', 'password');

    $rules = [
        'email' => 'required',
        'password' => 'required',
    ];

    $validator = Validator::make($credentials, $rules);

    if($validator->fails()) {
        return response()->json(['success'=> false, 'error'=> $validator->messages()]);
    }

    try {
        if(!$auth::attempt($credentials)) {
            return response()->json(['error' => 'We cant find an account with this credentials.'], 401);
        }
        $user = $auth::user();
        $customClaims = $user->toArray();

        $token = JWTAuth::claims($customClaims)->fromUser($user);
    } catch (JWTException $e) {
        // something went wrong whilst attempting to encode the token
        return response()->json(['error' => 'Failed to login, please try again.'], 500);
    }

    // all good so return the token
    return response()->json(['token' => $token]);
});

Route::group(['middleware' => ['jwt.auth']], function() {

    Route::get('/check-token', function(Request $request) {
        // if we got here, the token is valid
        return response()->json(['message'=> "Token valid."]);
    });

    Route::post('/logout', function(Request $request) {
        try {
            JWTAuth::invalidate($request->input('token'));
            return response()->json(['message'=> "You have successfully logged out."]);

        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'Failed to logout, please try again.'], 500);
        }
    });

    Route::get('/refresh', function() {
        try {
            $token = JWTAuth::refresh();
            return response()->json(['token' => $token]);

        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'Failed to logout, please try again.'], 500);
        }
    });
});
