<?php

use Illuminate\Http\Request;

Route::group(['prefix'=>'api'], function() {

  Route::get('/testmodule', function(Request $request) {
    return response()->json('test');
  });
});