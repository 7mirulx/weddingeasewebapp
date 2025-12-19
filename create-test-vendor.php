<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Vendor;

// Create a test vendor
$vendor = Vendor::create([
    'vendor_name' => 'Test Photography Studio',
    'category' => 'Photography',
    'description' => 'Professional wedding photography services',
    'email' => 'test.photographer@jomkahwin.local',
    'phone' => '+60123456789',
    'starting_price' => 2500,
    'city' => 'Kuala Lumpur',
    'state' => 'Wilayah Persekutuan',
    'status' => 'unclaimed',
    'owner_user_id' => null,
    'created_by_type' => 'admin',
    'created_by_id' => 1,
]);

echo "✅ Test vendor created!\n";
echo "Vendor ID: " . $vendor->id . "\n";
echo "Email: " . $vendor->email . "\n";
echo "Status: " . $vendor->status . "\n";
echo "\n📍 Admin Edit URL: /admin/vendors/" . $vendor->id . "/edit\n";
