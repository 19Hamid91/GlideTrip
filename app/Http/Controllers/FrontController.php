<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageBookingCheckoutRequest;
use App\Http\Requests\PackageBookingRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Category;
use App\Models\PackageBank;
use App\Models\PackageBooking;
use App\Models\PackageTour;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class FrontController extends Controller
{
    public function index()
    {
        $categories = Category::orderByDesc('id')
            ->get()
            ->map(function ($category) {
                $category->icon_url = Storage::url($category->icon);
                return $category;
            });
        $package_tours = PackageTour::orderbyDesc('id')
            ->take(3)
            ->get()
            ->map(function ($package_tour) {
                $package_tour->thumbnail_url = Storage::url($package_tour->thumbnail);
                $package_tour->formatted_price = 'Rp ' . number_format($package_tour->price, 0, ',', '.');
                return $package_tour;
            });
        return Inertia::render('Front/Index', [
            'package_tours' => $package_tours,
            'categories' => $categories
        ]);
    }

    public function category(Category $category)
    {
        $category->load('tours');

        $category->tours->each(function ($tour) {
            $tour->thumbnail_url = Storage::url($tour->thumbnail);
            $tour->formatted_price = 'Rp ' . number_format($tour->price, 0, ',', '.');
        });
        return Inertia::render('Front/Category', [
            'category' => $category
        ]);
    }

    public function details($slug)
    {
        $package_tour = PackageTour::with('package_photos')->where('slug', $slug)->first();
        $package_tour->package_photos->each(function ($photo) {
            $photo->photo_url = Storage::url($photo->photo);
        });
        $package_tour->thumbnail_url = Storage::url($package_tour->thumbnail);
        $package_tour->formatted_price = 'Rp ' . number_format($package_tour->price, 0, ',', '.');
        $package_tour->truncated_about = Str::limit($package_tour->about, 100);

        return Inertia::render('Front/Details', [
            'package_tour' => $package_tour,
        ]);
    }

    public function book(PackageTour $packageTour)
    {
        $packageTour->thumbnail_url = Storage::url($packageTour->thumbnail);
        return Inertia::render('Front/Book', [
            'package_tour' => $packageTour
        ]);
    }

    public function book_store(PackageBookingRequest $request, PackageTour $packageTour)
    {
        $user = Auth::user();
        $bank = PackageBank::orderByDesc('id')->first();
        $packageBookingId = null;

        DB::transaction(function () use ($request, $user, $packageTour, $bank, &$packageBookingId) {
            $validated = $request->validated();

            $start_date = new Carbon($validated['start_date']);
            $totalDays = $packageTour->days - 1;

            $end_date = $start_date->addDays($totalDays);

            $sub_total = $packageTour->price * $validated['quantity'];
            $insurance = 300000 * $validated['quantity'];
            $tax = 0.11 * $sub_total;

            $validated['end_date'] = $end_date;
            $validated['user_id'] = $user->id;
            $validated['is_paid'] = false;
            $validated['proof'] = 'proof.png';
            $validated['package_tour_id'] = $packageTour->id;
            $validated['package_bank_id'] = $bank->id;
            $validated['insurance'] = $insurance;
            $validated['tax'] = $tax;
            $validated['subtotal'] = $sub_total;
            $validated['total_amount'] = $sub_total + $tax + $insurance;
            // dd($validated);

            $packageBooking = PackageBooking::create($validated);
            $packageBookingId = $packageBooking->id;
        });

        if (!$packageBookingId) return back()->withErrors('failed to create booking');

        return redirect()->route('front.choose_bank', $packageBookingId);
    }

    public function choose_bank(PackageBooking $packageBooking)
    {
        $user = Auth::user();
        if ($packageBooking->user_id != $user->id) {
            abort(403);
        }
        $banks = PackageBank::all();
        $banks = $banks->map(function ($bank) {
            $bank->logo_url = Storage::url($bank->logo);
            return $bank;
        });
        return Inertia::render('Front/ChooseBank', [
            'banks' => $banks,
            'packageBooking' => $packageBooking
        ]);
    }

    public function choose_bank_store(PackageBookingRequest $request, PackageBooking $packageBooking)
    {
        $user = Auth::user();
        if ($packageBooking->user_id != $user->id) {
            abort(403);
        }

        DB::transaction(function () use ($request, $packageBooking) {
            $validated = $request->validated();
            $packageBooking->update([
                'package_bank_id' => $validated['package_bank_id']
            ]);
        });
        return redirect()->route('front.book_payment', $packageBooking->id);
    }

    public function book_payment(PackageBooking $packageBooking)
    {
        $packageBooking->load(['tour', 'bank']);

        $packageBooking->tour->thumbnail_url =  Storage::url($packageBooking->tour->thumbnail);
        $packageBooking->bank->logo_url =  Storage::url($packageBooking->bank->logo);
        $packageBooking->date_range =
            Carbon::parse($packageBooking->start_date)->format('d M Y') . ' - ' . Carbon::parse($packageBooking->end_date)->format('d M Y');

        return Inertia::render('Front/BookPayment', [
            'packageBooking' => $packageBooking
        ]);
    }

    public function book_payment_store(PackageBookingCheckoutRequest $request, PackageBooking $packageBooking)
    {
        $user = Auth::user();
        if ($packageBooking->user_id != $user->id) {
            abort(403);
        }

        DB::transaction(function () use ($request, $packageBooking) {
            $validated = $request->validated();
            if ($request->hasFile('proof')) {
                $proofPath = $request->file('proof')->store('proofs', 'public');
                $validated['proof'] = $proofPath;
            }
            $packageBooking->update($validated);
        });

        return redirect()->route('front.book_finish', $packageBooking->id);
    }

    public function book_finish()
    {
        return Inertia::render('Front/BookFinish');
    }

    public function search(Request $request)
    {
        $searchValue = $request->input('search');
        $packageTours = [];

        if ($searchValue) {
            $packageTours = PackageTour::where('name', 'LIKE', '%' . $searchValue . '%')
                ->orderByDesc('id')
                ->get()
                ->map(function ($tour) {
                    $tour->thumbnail_url = Storage::url($tour->thumbnail);
                    $tour->formatted_price = 'Rp ' . number_format($tour->price, 0, ',', '.');
                    return $tour;;
                });
        }

        if ($request->expectsJson()) {
            return response()->json($packageTours);
        }

        return Inertia::render('Front/Search', [
            'packageTours' => $packageTours
        ]);
    }

    public function profile_edit()
    {
        $user = Auth::user();
        $user->avatar_url = Storage::url($user->avatar);
        return Inertia::render('Front/Profile', [
            'user' => $user
        ]);
    }

    public function profile_update(ProfileUpdateRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();
            $user = $request->user();

            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
            }

            // Update data pengguna
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->phone_number = $validated['phone_number'];
            $user->avatar = $avatarPath ?? $user->avatar;
            $user->save();
        });

        return Redirect::route('front.profile.edit')->with('success', 'Profile updated successfully.');
    }
}
