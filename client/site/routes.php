<?php

use Illuminate\Http\Request;


Route::get('site/test', function(){
    return response()->json(['retama'=>'front']);
});