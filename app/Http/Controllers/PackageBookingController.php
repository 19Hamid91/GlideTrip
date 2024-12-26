<?php

namespace App\Http\Controllers;

use App\Models\PackageBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PackageBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = PackageBooking::with(['tour.category', 'customer'])->orderByDesc('id')->get()->each(function ($booking) {
            $booking->tour->thumbnail_url = Storage::url($booking->tour->thumbnail);
            return $booking;
        });
        return Inertia::render('Admin/PackageBooking/Index', [
            'bookings' => $bookings
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PackageBooking $packageBooking)
    {
        $packageBooking->load(['tour.category', 'customer']);
        $packageBooking->tour->thumbnail_url = Storage::url($packageBooking->tour->thumbnail);
        $packageBooking->formatted_start_date = $packageBooking->start_date->format('d M Y');
        $packageBooking->formatted_end_date = $packageBooking->end_date->format('d M Y');
        $packageBooking->proof_url = Storage::url($packageBooking->proof);
        return Inertia::render('Admin/PackageBooking/Show', [
            'packageBooking' => $packageBooking
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PackageBooking $packageBooking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PackageBooking $packageBooking)
    {
        DB::transaction(function () use ($packageBooking) {
            $packageBooking->update([
                'is_paid' => true
            ]);
        });
        return redirect()->route('admin.package_bookings.show', $packageBooking->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PackageBooking $packageBooking)
    {
        //
    }
}
