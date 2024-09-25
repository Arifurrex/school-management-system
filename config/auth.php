<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option defines the default authentication "guard" and password
    | reset "broker" for your application. You may change these values
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | which utilizes session storage plus the Eloquent user provider.
    |
    | All authentication guards have a user provider, which defines how the
    | users are actually retrieved out of your database or other storage
    | system used by the application. Typically, Eloquent is utilized.
    |
    | Supported: "session"
    |এরপর, আপনি আপনার অ্যাপ্লিকেশনের জন্য প্রতিটি authentication গার্ড সংজ্ঞায়িত করতে        পারেন। | অবশ্যই, আপনার জন্য একটি চমৎকার ডিফল্ট কনফিগারেশন নির্ধারিত হয়েছে, | যা সেশন স্টোরেজ এবং Eloquent ইউজার প্রোভাইডার ব্যবহার করে। | 
    
    | প্রতিটি authentication গার্ডের একটি ইউজার প্রোভাইডার থাকে, | যা নির্ধারণ করে ইউজাররা কীভাবে আপনার ডাটাবেস বা অন্য কোনো স্টোরেজ সিস্টেম থেকে | প্রকৃতপক্ষে রিট্রিভ করা হবে, যা অ্যাপ্লিকেশন দ্বারা ব্যবহৃত হয়। সাধারণত, Eloquent ব্যবহৃত হয়। | | সমর্থিত: "session"
    |
    */

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

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication guards have a user provider, which defines how the
    | users are actually retrieved out of your database or other storage
    | system used by the application. Typically, Eloquent is utilized.
    |
    | If you have multiple user tables or models you may configure multiple
    | providers to represent the model / table. These providers may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"

    |
    | প্রতিটি authentication গার্ডের একটি ইউজার প্রোভাইডার থাকে, যা নির্ধারণ করে
    | ইউজাররা কীভাবে আপনার ডাটাবেস বা অন্য কোনো স্টোরেজ সিস্টেম থেকে
    | অ্যাপ্লিকেশনে রিট্রিভ করা হবে। সাধারণত, Eloquent ব্যবহৃত হয়।
    |
    | যদি আপনার একাধিক ইউজার টেবিল বা মডেল থাকে, তাহলে আপনি একাধিক
    | প্রোভাইডার কনফিগার করতে পারেন, যেগুলো সেই নির্দিষ্ট মডেল বা টেবিলের
    | প্রতিনিধিত্ব করবে। এরপর এই প্রোভাইডারগুলোকে যেকোনো অতিরিক্ত authentication
    | গার্ডে অ্যাসাইন করা যেতে পারে, যা আপনি সংজ্ঞায়িত করেছেন।
    |
    | সমর্থিত: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | These configuration options specify the behavior of Laravel's password
    | reset functionality, including the table utilized for token storage
    | and the user provider that is invoked to actually retrieve users.
    |
    | The expiry time is the number of minutes that each reset token will be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    | The throttle setting is the number of seconds a user must wait before
    | generating more password reset tokens. This prevents the user from
    | quickly generating a very large amount of password reset tokens.

    |
    | এই কনফিগারেশন অপশনগুলো Laravel-এর পাসওয়ার্ড রিসেট ফাংশনালিটির আচরণ নির্ধারণ করে,
    | যার মধ্যে টোকেন সংরক্ষণের জন্য ব্যবহৃত টেবিল এবং ইউজার প্রোভাইডার অন্তর্ভুক্ত,
    | যা ইউজারদের রিট্রিভ করার জন্য আহ্বান করা হয়।
    |
    | Expiry time হলো সময়ের পরিমাণ, মিনিটে নির্ধারিত, যার মধ্যে প্রতিটি রিসেট টোকেন
    | বৈধ হিসাবে গণ্য করা হবে। এই সিকিউরিটি ফিচারটি টোকেনকে স্বল্প সময়ের জন্য সক্রিয় রাখে,
    | যাতে সেগুলো অনুমান করার সুযোগ কম থাকে। আপনি প্রয়োজন অনুযায়ী এটি পরিবর্তন করতে পারেন।
    |
    | Throttle setting হলো সময়ের পরিমাণ, সেকেন্ডে, যে সময়ের জন্য একজন ইউজারকে
    | অপেক্ষা করতে হবে আরও পাসওয়ার্ড রিসেট টোকেন তৈরি করার আগে। এটি ইউজারকে খুব
    | দ্রুত বড় পরিমাণে টোকেন তৈরি করা থেকে প্রতিরোধ করে।
        |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | window expires and users are asked to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
        
    | পাসওয়ার্ড নিশ্চিতকরণ সময়সীমা
    |--------------------------------------------------------------------------
    |
    | এখানে আপনি নির্ধারণ করতে পারেন কত সেকেন্ড পর পাসওয়ার্ড নিশ্চিতকরণের উইন্ডোর মেয়াদ শেষ হবে এবং
    | ব্যবহারকারীদের পুনরায় পাসওয়ার্ড প্রবেশ করতে বলা হবে। ডিফল্টভাবে, এই সময়সীমা তিন ঘন্টা স্থায়ী হয়।
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
