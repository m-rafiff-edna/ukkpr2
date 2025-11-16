<?php
require_once 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

$admins = User::where('role', 'admin')->get();

echo "=== Admin Users ===\n";
foreach ($admins as $admin) {
    echo "Name: " . $admin->name . "\n";
    echo "Email: " . $admin->email . "\n";
    echo "Password: password123\n";
    echo "---\n";
}

$total = User::count();
echo "\nTotal users: " . $total . "\n";
