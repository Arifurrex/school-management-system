### ইন্ডেক্স (Index)
1. **গার্ড এবং প্রোভাইডার কনফিগারেশন**
2. **লগইন রুট এবং কন্ট্রোলার**
3. **ভিউ: লগইন ফর্ম তৈরি**
4. **অথেন্টিকেশন কন্ট্রোলার মেথড এবং রুট**
5. **ড্যাশবোর্ড রুট এবং কন্ট্রোলার**
6. **লগআউট ফাংশনালিটি**
7. **পাসওয়ার্ড রিসেট রুট এবং কন্ট্রোলার**
8. **মিডলওয়্যার: অথেন্টিকেশন এবং রিডিরেক্ট**
9. **মিডলওয়্যার রেজিস্ট্রেশন**
10. **রাউট গোষ্ঠীকরণ (Route Grouping)**

---

### ১. গার্ড এবং প্রোভাইডার কনফিগারেশন
প্রথমে আপনাকে `config/auth.php` ফাইলে গার্ড এবং প্রোভাইডার তৈরি করতে হবে। এখানে 'teacher' নামের গার্ড এবং প্রোভাইডার তৈরি করা হবে।

**config/auth.php**:
```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'admin' => [
        'driver' => 'session',
        'provider' => 'admins',
    ],
    'teacher' => [
        'driver' => 'session',
        'provider' => 'teachers',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
    'admins' => [
        'driver' => 'eloquent',
        'model' => App\Models\Admin::class,
    ],
    'teachers' => [
        'driver' => 'eloquent',
        'model' => App\Models\Teacher::class,
    ],
],
```
এখানে 'teacher' গার্ডটি 'teachers' প্রোভাইডার ব্যবহার করবে, যেখানে 'Teacher' মডেল থাকবে।

---

### ২. লগইন রুট এবং কন্ট্রোলার
এখন আমরা লগইনের জন্য একটি রুট এবং কন্ট্রোলার তৈরি করব।

**Route:**
```php
Route::get('adminTeacher/login', [AdminTeacherController::class, 'index'])->name('adminTeacher.login');
```

**কন্ট্রোলার মেথড:**
```php
public function index() {
    return view('adminTeacher.login');
}
```

---

### ৩. ভিউ: লগইন ফর্ম তৈরি
লগইন ফর্ম তৈরি করা হবে `resources/views/adminTeacher/login.blade.php` ফাইলে।

**login.blade.php:**
```html
<form action="{{ route('adminTeacher.authenticate') }}" method="post">
    @csrf
    <div>
        <div class="text-danger">
            @error('email')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="text-danger">
            @error('password')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
    </div>
</form>
```

---

### ৪. অথেন্টিকেশন কন্ট্রোলার মেথড এবং রুট
এখন আমরা অথেন্টিকেশন এর জন্য মেথড এবং রুট তৈরি করব।

**Route:**
```php
Route::post('authenticate', [AdminTeacherController::class, 'authenticate'])->name('adminTeacher.authenticate');
```

**Controller Method:**
```php
public function authenticate(Request $request) {
    $request->validate([
        'email' => 'required',
        'password' => 'required'
    ]);

    if (Auth::guard('teacher')->attempt(['email' => $request->email, 'password' => $request->password])) {
        if (Auth::guard('teacher')->user()->role != 'teacher') {
            return redirect()->route('adminTeacher.logout')->with('error', 'Unauthorized user');
        } else {
            return redirect()->route('adminTeacher.dashboard');
        }
    } else {
        return redirect()->route('adminTeacher.login')->with('error', 'Something went wrong');
    }
}
```

---

### ৫. ড্যাশবোর্ড রুট এবং কন্ট্রোলার
যখন অথেন্টিকেশন সফলভাবে সম্পন্ন হবে, তখন ব্যবহারকারীকে ড্যাশবোর্ডে নিয়ে যাওয়া হবে।

**Route:**
```php
Route::get('dashboard', [AdminTeacherController::class, 'dashboard'])->name('adminTeacher.dashboard');
```

**Controller Method:**
```php
public function dashboard() {
    return view('adminTeacher.dashboard');
}
```

---

### ৬. লগআউট ফাংশনালিটি
লগআউট এর জন্য আমরা একটি রুট এবং মেথড তৈরি করব।

**Route:**
```php
Route::get('logout', [AdminTeacherController::class, 'logout'])->name('adminTeacher.logout');
```

**Controller Method:**
```php
public function logout() {
    Auth::guard('teacher')->logout();
    return redirect()->route('adminTeacher.login')->with('success', 'Successfully logged out');
}
```

---

### ৭. পাসওয়ার্ড রিসেট রুট এবং কন্ট্রোলার
পাসওয়ার্ড রিসেট এর জন্য রুট এবং কন্ট্রোলার মেথড তৈরি করব।

**Route:**
```php
Route::get('password-reset', [AdminTeacherController::class, 'passwordReset'])->name('adminTeacher.passwordReset');
Route::post('password-reset/store', [AdminTeacherController::class, 'passwordResetStore'])->name('adminTeacher.passwordReset.store');
```

**Controller Methods:**
```php
public function passwordReset() {
    return view('adminTeacher.passwordReset');
}

public function passwordResetStore(Request $request) {
    $request->validate([
        'oldPass' => 'required',
        'newPass' => 'required',
        'confirmPass' => 'required|same:newPass',
    ]);

    if (Hash::check($request->oldPass, Auth::guard('teacher')->user()->password)) {
        Auth::guard('teacher')->user()->password = Hash::make($request->confirmPass);
        Auth::guard('teacher')->user()->save();
        Auth::guard('teacher')->logout();

        return redirect()->route('adminTeacher.login')->with('success', 'Password updated successfully');
    } else {
        return redirect()->back()->with('error', 'Incorrect old password');
    }
}
```

---

### ৮. মিডলওয়্যার: অথেন্টিকেশন এবং রিডিরেক্ট
এখন আমরা দুটি মিডলওয়্যার তৈরি করব, একটি অথেন্টিকেশন চেক করার জন্য এবং অন্যটি লগইন হলে রিডিরেক্ট করার জন্য।

**TeacherAuthenticate Middleware:**
```php
public function handle(Request $request, Closure $next): Response {
    if (!Auth::guard('teacher')->check()) {
        return redirect()->route('adminTeacher.login');
    }
    return $next($request);
}
```

**TeacherRedirect Middleware:**
```php
public function handle(Request $request, Closure $next): Response {
    if (Auth::guard('teacher')->check()) {
        return redirect()->route('adminTeacher.dashboard');
    }
    return $next($request);
}
```

---

### ৯. মিডলওয়্যার রেজিস্ট্রেশন
`bootstrap/app.php` ফাইলে আমরা এই মিডলওয়্যারগুলো রেজিস্টার করব।

```php
$middleware->alias([
    'teacher.guest' => \App\Http\Middleware\TeacherRedirect::class,
    'teacher.auth' => \App\Http\Middleware\TeacherAuthenticate::class,
]);
```

---

### ১০. রাউট গোষ্ঠীকরণ (Route Grouping)
অবশেষে, আমরা সমস্ত রুটগুলোকে একটি গ্রুপের মধ্যে রাখব এবং মিডলওয়্যার প্রয়োগ করব।

```php
Route::group(['prefix' => 'adminTeacher'], function () {

    Route::group(['middleware' => 'teacher.guest'], function () {
        Route::get('login', [AdminTeacherController::class, 'index'])->name('adminTeacher.login');
        Route::post('authenticate', [AdminTeacherController::class, 'authenticate'])->name('adminTeacher.authenticate');
    });

    Route::group(['middleware' => 'teacher.auth'], function () {
        Route::get('dashboard', [AdminTeacherController::class, 'dashboard'])->name('adminTeacher.dashboard');
        Route::get('logout', [AdminTeacherController::class, 'logout'])->name('adminTeacher.logout');
        Route::get('password-reset', [AdminTeacherController::class, 'passwordReset'])->name('adminTeacher.passwordReset');
        Route::post('password-reset/store', [AdminTeacherController::class, 'passwordResetStore'])->name('adminTeacher.passwordReset.store');
    });
});
```

---

### ১১. শিক্ষকের ড্যাশবোর্ড ভিউ
ড্যাশবোর্ড ভিউ তৈরি করুন যা লগইন করা শিক্ষকের জন্য ড্যাশবোর্ডের তথ্য প্রদর্শন করবে। এটি `resources/views/adminTeacher/dashboard.blade.php` ফাইলে থাকবে।

**dashboard.blade.php:**
```html
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome, {{ Auth::guard('teacher')->user()->name }}</h1>
    <a href="{{ route('adminTeacher.logout') }}" class="btn btn-danger">Logout</a>
    <a href="{{ route('adminTeacher.passwordReset') }}" class="btn btn-warning">Change Password</a>
</div>
@endsection
```

---

### ১২. পাসওয়ার্ড রিসেট ভিউ
পাসওয়ার্ড রিসেট করার জন্য একটি ভিউ তৈরি করুন `resources/views/adminTeacher/passwordReset.blade.php` ফাইলে।

**passwordReset.blade.php:**
```html
<form action="{{ route('adminTeacher.passwordReset.store') }}" method="post">
    @csrf
    <div>
        <label>Old Password</label>
        <input type="password" name="oldPass" required>
    </div>
    <div>
        <label>New Password</label>
        <input type="password" name="newPass" required>
    </div>
    <div>
        <label>Confirm New Password</label>
        <input type="password" name="confirmPass" required>
    </div>
    <button type="submit">Reset Password</button>
</form>
```

---

### ১৩. সফল এবং ত্রুটি বার্তা পরিচালনা
লগইন, লগআউট, এবং পাসওয়ার্ড রিসেটের সফল এবং ত্রুটি বার্তাগুলো ব্যবহারকারীর জন্য দেখতে সুন্দরভাবে উপস্থাপন করতে পারেন। Blade টেমপ্লেটে বার্তা দেখানোর জন্য নিচের কোডটি ব্যবহার করুন।

```blade
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
```

---

### ১৪. শেষ কথা
এখন আপনি Laravel ব্যবহার করে একটি সম্পূর্ণ শিক্ষক অথেন্টিকেশন সিস্টেম তৈরি করেছেন। শিক্ষকের লগইন, লগআউট, পাসওয়ার্ড পরিবর্তন এবং ড্যাশবোর্ড ফিচার সফলভাবে কার্যকর হয়েছে।

#### টেস্টিং
এই সিস্টেমটি টেস্ট করতে হবে। নিশ্চিত করুন যে:
- সঠিক তথ্য দিয়ে লগইন করলে সফলভাবে ড্যাশবোর্ডে প্রবেশ করা যায়।
- ভুল তথ্য দিলে সঠিক ত্রুটি বার্তা প্রদর্শিত হচ্ছে।
- পাসওয়ার্ড পরিবর্তন করতে পারা যাচ্ছে এবং পরিবর্তন সফলভাবে কার্যকর হচ্ছে।
- লগআউট করলে ব্যবহারকারীকে লগইন পৃষ্ঠায় নিয়ে যাওয়া হচ্ছে।

---

### ১৫. পরবর্তী পদক্ষেপ
এখন আপনি এই সিস্টেমে কিছু উন্নতি করতে পারেন যেমন:
- **শিক্ষক রেজিস্ট্রেশন**: নতুন শিক্ষকদের নিবন্ধনের জন্য ফর্ম এবং লজিক যোগ করা।
- **রোল এবং পারমিশন**: শিক্ষকদের জন্য বিভিন্ন রোল এবং তাদের জন্য বিশেষ পারমিশন সেট আপ করা।
- **প্রোফাইল আপডেট**: শিক্ষকদের তাদের প্রোফাইল তথ্য আপডেট করার জন্য একটি ফিচার যোগ করা।

এটি একটি মৌলিক অথেন্টিকেশন সিস্টেম তৈরি করতে সাহায্য করেছে, এবং আপনি আপনার প্রয়োজন অনুযায়ী এটি আরও উন্নত করতে পারেন।

---

এখন আপনি আপনার Laravel প্রকল্পে এই শিক্ষকের অথেন্টিকেশন সিস্টেমটি সফলভাবে সেট আপ করেছেন। যদি কোনও প্রশ্ন থাকে, দয়া করে জিজ্ঞাসা করতে দ্বিধা করবেন না!
