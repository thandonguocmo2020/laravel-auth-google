# laravel-auth-google

# 1. Thêm mới routes vào file routes.php
+ Khởi tạo provider file 
+ khởi tạo file routes.php trong gói chưa kèm nội dung
+ Khởi tạo file provider class đăng ký gói  :

thêm routes.php vào laravel qua method boot  :

if (! $this->app->routesAreCached()) {
            require __DIR__.'/routes.php';
        }


# 2. Khởi tạo file cấu hình với mảng cần thêm vào cấu hình có sắn ví dụ :

<?php

return [

        'h3'=>
                [
                'driver' => 'local',
                'root' => app_path('/'),
                'visibility' => 'public',
                 ]
        ];



# 3. Thêm cấu hình vào file cấu hình laravel trong method register với key của file config :

public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/filesystems.php', 'filesystems.disks'
        );
    }


# 4.  Thêm tuyến đường mới vào file routes.php của app/Http/routes.php bằng cách viết trong route của gói 

Route::get('hoanghiep/add-routes',function(){

    if(Storage::disk('h3')->exists("Http/routes.php")){
        Storage::disk("h3")->append('Http/routes.php', 
'Route::get(\'auth/google\',["middleware"=>"web", "uses"=> \'Auth\GoogleController@redirectToProvider\']);
');
        Storage::disk("h3")->append('Http/routes.php', 
'Route::get(\'auth/google/callback\', ["middleware"=>"web","uses"=> \'Auth\GoogleController@handleProviderCallback\']);
');

    }
});

// sau khi chạy url hoanghiep/add-routes này đoạn lệnh sẽ kiểm tra file routes.php đã tồn tại trong app/Http/routes.php

vào thực hiện thêm mới 2 route 'auth/google - auth/google/callback\ vào file đó.

# 5.  Tạo file controller xử lý 2 file đó.

Trong provider class tại method boot() thêm đoạn sau : 

 $this->publishes([
          __DIR__.("/Auth/GoogleController.php")=> app_path("/Http/Controllers/Auth/GoogleController.php"),
          
      ])


 Chạy lệnh để xuất bản file controller : php artisan vendor:publish 

Như vậy khi chạy lệnh controller sẽ được tạo ra.

 thêm file cấu hình của google bằng cách tạo ra một file trong gói vừa tải tên là service.php
trong đó chứa :

<?php

return [

    'google'=>[
       'client_id' => '15561597118-vv58u5dtkm10uni08kv471ltjb1od40m.apps.googleusercontent.com',
       'client_secret' => '_1Ojx13UdmPMkTadUrClA9Cw',
       'redirect' => 'http://localhost/laravel/auth/google/callback',
    ]

];


sau đó thêm đoạn code này vào provider :

$this->mergeConfigFrom(
            __DIR__.'/config/services.php', 'services'
        );

Như vậy là đã gộp file cấu hình vào file config thành công kiểm tra kết quả bằng cách

vào method boot hoặc route chạy đoạn 

     dd(config('services'));

hoặc 

     dd(config('services.google'));


+ Để tùy chỉnh thông tin của serve google bạn vào file  'services' trong package/config/services.php


+ Để chạy thử tính năng : bạn chạy 2 url auth/google và auth/google/callback nếu url ko tồn tại thì chạy url để khởi tạo url đó : hoanghiep/add-routes

