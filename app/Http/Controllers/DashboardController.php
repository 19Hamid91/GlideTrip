<?php

namespace App\Http\Controllers;

use App\Models\PackageBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function my_bookings()
    {
        $user = Auth::user();
        $packageBookings = PackageBooking::with('tour')
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($packageBooking) {
                $packageBooking->day = $packageBooking->start_date->format('d');
                $packageBooking->month = $packageBooking->start_date->format('M');
                $packageBooking->year = $packageBooking->start_date->format('Y');
                $packageBooking->tour->thumbnail_url = Storage::url($packageBooking->tour->thumbnail);
                $packageBooking->tour->formatted_price = 'Rp ' . number_format($packageBooking->tour->price, 0, ',', '.');
                return $packageBooking;
            });


        return Inertia::render('Dashboard/MyBookings', [
            'packageBookings' => $packageBookings
        ]);
    }

    public function booking_details(PackageBooking $packageBooking)
    {
        $packageBooking->load('tour');
        $packageBooking->formatted_start_date = $packageBooking->start_date->format('d M Y');
        $packageBooking->formatted_end_date = $packageBooking->end_date->format('d M Y');
        $packageBooking->tour->thumbnail_url = Storage::url($packageBooking->tour->thumbnail);
        return Inertia::render('Dashboard/BookingDetail', [
            'packageBooking' => $packageBooking
        ]);
    }
}
