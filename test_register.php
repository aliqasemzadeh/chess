<?php

require_once 'vendor/autoload.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Test user creation
    $testUser = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => Hash::make('password123'),
    ];

    // Check if user already exists
    $existingUser = User::where('email', $testUser['email'])->first();
    if ($existingUser) {
        echo "Test user already exists. Deleting...\n";
        $existingUser->delete();
    }

    // Create new user
    $user = User::create($testUser);

    if ($user) {
        echo "✓ User registration test PASSED\n";
        echo "User ID: " . $user->id . "\n";
        echo "User Name: " . $user->name . "\n";
        echo "User Email: " . $user->email . "\n";

        // Clean up
        $user->delete();
        echo "✓ Test user cleaned up\n";
    } else {
        echo "✗ User registration test FAILED\n";
    }

} catch (Exception $e) {
    echo "✗ Error during registration test: " . $e->getMessage() . "\n";
}
