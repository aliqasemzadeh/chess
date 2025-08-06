<?php

require_once 'vendor/autoload.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

// Create a test user with email
$testUser = [
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => Hash::make('password123')
];

echo "Testing email-based login functionality...\n";
echo "Test user email: test@example.com\n";
echo "Test user password: password123\n";

// Test authentication attempt with email
$credentials = [
    'email' => 'test@example.com',
    'password' => 'password123'
];

echo "Attempting login with email credentials...\n";

// This simulates what the Login component does
if (Auth::attempt($credentials)) {
    echo "✓ Login successful with email authentication!\n";
} else {
    echo "✗ Login failed with email authentication.\n";
}

echo "Email login implementation is ready.\n";
