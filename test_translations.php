<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Test key translations
    $testKeys = [
        'Login' => 'ورود',
        'Register' => 'ثبت نام',
        'Name' => 'نام',
        'Email' => 'ایمیل',
        'Password' => 'رمز عبور',
        'Confirm Password' => 'تایید رمز عبور',
        'Remember me' => 'مرا به خاطر بسپار',
        'Already have an account?' => 'قبلاً حساب کاربری دارید؟',
        "Don't have an account?" => 'حساب کاربری ندارید؟',
        'Enter your name' => 'نام خود را وارد کنید',
        'Enter your email' => 'ایمیل خود را وارد کنید',
        'Enter your password' => 'رمز عبور خود را وارد کنید',
        'Create your account to start playing' => 'حساب کاربری خود را برای شروع بازی ایجاد کنید'
    ];

    echo "Testing Farsi translations:\n";
    echo "==========================\n\n";

    $allPassed = true;

    foreach ($testKeys as $key => $expectedTranslation) {
        $actualTranslation = __($key);

        if ($actualTranslation === $expectedTranslation) {
            echo "✓ '$key' → '$actualTranslation'\n";
        } else {
            echo "✗ '$key' → Expected: '$expectedTranslation', Got: '$actualTranslation'\n";
            $allPassed = false;
        }
    }

    echo "\n==========================\n";
    if ($allPassed) {
        echo "✓ All translation tests PASSED\n";
    } else {
        echo "✗ Some translation tests FAILED\n";
    }

} catch (Exception $e) {
    echo "✗ Error during translation test: " . $e->getMessage() . "\n";
}
