<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    
    public function index(Request $request)
    {
        $vendors = Vendor::query()
            ->when($request->search, fn($q) =>
                $q->where('vendor_name', 'ILIKE', "%{$request->search}%")
            )
            ->when($request->category, fn($q) =>
                $q->where('category', $request->category)
            )
            ->when($request->city, fn($q) =>
                $q->where('city', $request->city)
            )
            ->paginate(12);

        $categories = Vendor::select('category')->distinct()->get();
        $cities     = Vendor::select('city')->distinct()->get();

        // 👉 EXACT FILE NAME YOU USE
        return view('wedding.browsevendors', compact('vendors', 'categories', 'cities'));
    }

    public function show($id)
    {
        $vendor = Vendor::findOrFail($id);

        // buat file vendor-details nanti
        return view('wedding.vendor-details', compact('vendor'));
    }
}
