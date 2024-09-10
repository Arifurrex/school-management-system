<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## Laravel multi Authentication system
 
 # setup database 
```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=school-management-system
    DB_USERNAME=root
    DB_PASSWORD=
    DB_COLLATION=utf8mb4_general_ci
```

  ### customize user table
```   
    public function up(): void
        {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->enum('role',['admin','student','teacher','parent'])->default('student');
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });


        }
```
### make guard for admin via middileware

 go to config/auth.php file

``` 
'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],

 'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],
 ]

 ```
<p>

### কেন config/auth.php ফাইল দরকার?

Laravel অ্যাপ্লিকেশনে একাধিক authentication ব্যবস্থা পরিচালনা করার জন্য এই ফাইলটি প্রয়োজন। উদাহরণস্বরূপ, যদি আপনি অ্যাপ্লিকেশনে user, admin বা অন্য কোনো ধরণের ইউজার আলাদা আলাদাভাবে authenticate করতে চান, তাহলে এই ফাইলে গার্ড এবং প্রোভাইডার সংজ্ঞায়িত করতে হবে।

### 'guards' কী?
guards নির্ধারণ করে কিভাবে ইউজার authenticate হবে। এখানে গার্ডটি session ভিত্তিক (যেটি Laravel-এ সাধারণত ব্যবহৃত হয়), এবং এটি নির্ধারণ করে যে কোন প্রোভাইডার থেকে ইউজার ডেটা সংগ্রহ করা হবে।

 এখানে web এবং admin নামে দুইটি গার্ড তৈরি করা হয়েছে। web গার্ডটি সাধারণ ইউজারদের জন্য এবং admin গার্ডটি অ্যাডমিনদের জন্য। গার্ডগুলোর মধ্যে পার্থক্য হল, তারা বিভিন্ন প্রোভাইডার ব্যবহার করছে।

### 'providers' কী?
providers নির্ধারণ করে ইউজার ডেটা কোথা থেকে এবং কিভাবে সংগ্রহ করা হবে। সাধারণত, এটি ডাটাবেস থেকে Eloquent মডেলের মাধ্যমে ইউজার ডেটা রিট্রিভ করে।




 </p>

 ### login.blade.php

``` 
<form action="{{route('admin.authenticate')}}" method="post">
@csrf

```

## validation system
   
### controller

``` 
public function authenticate(Request $request){
    $req->validate([
        'email' =>'required',
        'password' => 'required'
    ]);
}
```
   

### login.blade.php where you want to show error massage 
       
       for email 

```
        <div class="text-danger">
            @error('email')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
    
``` 

       for password

``` 
            <div class="text-danger">
                @error('password')
                <p class="text-danger">{{$message}}</p>
                @enderror
            </div>

```


       validate done !!


## authention again logic

```
        public function authenticate(Request $req)
    {

        
        
        if (Auth::guard('admin')->attempt(['email' => $req->email,'password' => $req->password])) 
        {

        if(Auth::guard('admin')->user()->role != 'admin')
        {
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login')->with('error','Unauthorise user ');
        }else{
                return redirect()->route('admin.dashboard');
        }
        } else {

            return redirect()->route('admin.login')->with('error', 'something went wrong');

        };
    }

```


### while i have no user now . i create user static way

  ``` 
  public function register()
    {
        $user = new User();
        $user->name = 'Admin';
        $user->email = 'Admin@example.com';
        $user->role = "admin";
        $user->password = Hash::make('admin');
        $user->save();
        return redirect()->route('admin.login')->with('success', 'User create successfully');
    }

```

### register define in route

   ```Route::get('admin/register',[AdminController::class,'register'])->name('admin.register');```

when u hit http://127.0.0.1:8000/admin/register .it will save admin@examle.com admin user in database . that way i save static user


### session
```
    @if (Session::has('success'))
        <p class="alert alert-success">
            {{Session::get('success')}}
        </p>
    @endif
    @if (Session::has('error'))
        <p class="alert alert-danger">
            {{Session::get('error')}}
        </p>
    @endif
```



### logout system
        ```
        public function logout()
            {
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login')->with('success', 'successfully log out');
            }

        ```  


### logout route define
 ```Route::get('admin/logout',[AdminController::class,'logout'])->name('admin.logout');```


## middleware

create 2 middleware 

```
php artisan make:middleware AdminAuthenticate
php artisan make:middleware AdminRedirect
```

## AdminRedirect
```
    public function handle(Request $request, Closure $next): Response
        {

            if(Auth::guard('auth')->check()){
                return redirect()->route('admin.dashboard');
            }
            return $next($request);
        }
```


## AdminAuthenticate

``` 
    public function handle(Request $request, Closure $next): Response
        {
            if(!Auth::guard('auth')->check()){
                return redirect()->route('admin.login');
            }
            return $next($request);
        }
```

## this 2 middleware register in boostrap/app.php file
``` 
    ->withMiddleware(function (Middleware $middleware) {
            $middleware->alias([
                'admin.guest'=> AdminRedirect::class,
                'admin.auth'=> AdminAuthenticate::class,
            ]);

      })
```


## next i need to use this in route


```

    Route::group(['prefix'=>'admin'],function(){
        Route::group(['middleware'=>'admin.guest'],function(){
            
        });
        Route::group(['middleware'=>'admin.auth'],function(){
            
        });  
    });

```


## web.php

```
   Route::group(['prefix'=>'admin'],function(){
    Route::group(['middleware'=>'admin.guest'],function(){
        Route::get('login',[AdminController::class,'index'])->name('admin.login');
        Route::get('register',[AdminController::class,'register'])->name('admin.register');
        Route::post('authenticate',[AdminController::class,'authenticate'])->name('admin.authenticate');
        
    });
    Route::group(['middleware'=>'admin.auth'],function(){
        Route::get('logout',[AdminController::class,'logout'])->name('admin.logout');
        Route::get('dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
        Route::get('form',[AdminController::class,'form'])->name('admin.form');
        Route::get('table',[AdminController::class,'table'])->name('admin.table');
    });  
});

```