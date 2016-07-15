<?php

Route::get('hoanghiep/add-routes',function(){

    if(Storage::disk('h3')->exists("Http/routes.php")){
        Storage::disk("h3")->append('Http/routes.php', 'Route::get(\'auth/google\',["middleware"=>"web", "uses"=> \'Auth\GoogleController@redirectToProvider\']);');
        Storage::disk("h3")->append('Http/routes.php', 'Route::get(\'auth/google/callback\', ["middleware"=>"web","uses"=> \'Auth\GoogleController@handleProviderCallback\']);');

        return redirect ("/");
    }
});
