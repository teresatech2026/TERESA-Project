<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Farmer;

class FarmerProfileController extends Controller
{
    /**
     * Show a farmer's public profile: their info, active listings, and reviews.
     */
    public function show(Farmer $farmer)
    {
        $farmer->load('user');

        $activeProducts = $farmer->products()
            ->where('status', 'active')
            ->with('primaryImage')
            ->latest()
            ->get();

        $reviews = $farmer->reviews()
            ->with('buyer')
            ->latest()
            ->get();

        return view('buyer.farmers.show', compact('farmer', 'activeProducts', 'reviews'));
    }
}