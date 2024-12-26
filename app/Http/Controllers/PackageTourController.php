<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageTourRequest;
use App\Models\Category;
use App\Models\PackagePhoto;
use App\Models\PackageTour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PackageTourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $package_tours = PackageTour::with('category')->orderByDesc('id')->paginate('10');
        $package_tours->getCollection()->map(function ($package_tour) {
            $package_tour->thumbnail_url = Storage::url($package_tour->thumbnail);
            $package_tour->formatted_price = 'Rp ' . number_format($package_tour->price, 0, ',', '.');
            return $package_tour;
        });
        return Inertia::render('Admin/PackageTour/Index', [
            'package_tours' => $package_tours
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderByDesc('id')->get();
        return Inertia::render('Admin/PackageTour/Create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PackageTourRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails/' . date('Y/m/d'), 'public');
                $validated['thumbnail'] = $thumbnailPath;
            }
            $validated['slug'] = Str::slug($validated['name']);

            $newPackageTour = PackageTour::create($validated);

            if ($request->hasFile('package_photos')) {
                foreach ($request->package_photos as $photo) {
                    $photoPath = $photo->store('package_photos/' . date('Y/m/d'), 'public');
                    $newPackageTour->package_photos()->create([
                        'photo' => $photoPath
                    ]);
                }
            }
        });

        return redirect()->route('admin.package_tours.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(PackageTour $packageTour)
    {
        $packageTour->load('category');
        $packageTour->thumbnail_url = Storage::url($packageTour->thumbnail);
        $packageTour->formatted_price = 'Rp ' . number_format($packageTour->price, 0, ',', '.');
        $latestPhotos = $packageTour->package_photos()->orderByDesc('id')->take(3)->get()->map(function ($latestPhoto) {
            $latestPhoto->photo_url = Storage::url($latestPhoto->photo);
            return $latestPhoto;
        });
        return Inertia::render('Admin/PackageTour/Show', [
            'package_tour' => $packageTour,
            'latestPhotos' => $latestPhotos
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PackageTour $packageTour)
    {
        $packageTour->thumbnail_url = Storage::url($packageTour->thumbnail);
        $categories = Category::orderByDesc('id')->get();
        $latestPhotos = $packageTour->package_photos()->orderByDesc('id')->take(3)->get()->map(function ($latestPhoto) {
            $latestPhoto->photo_url = Storage::url($latestPhoto->photo);
            return $latestPhoto;
        })->toArray();
        return Inertia::render('Admin/PackageTour/Edit', [
            'package_tour' => $packageTour,
            'categories' => $categories,
            'latestPhotos' => $latestPhotos
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PackageTourRequest $request, PackageTour $packageTour)
    {
        DB::transaction(function () use ($request, $packageTour) {
            $validated = $request->validated();

            $validated['thumbnail'] = $packageTour->thumbnail;
            $validated['slug'] = Str::slug($validated['name']);

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails/' . date('Y/m/d'), 'public');
                $validated['thumbnail'] = $thumbnailPath;
            }

            $packageTour->update($validated);

            if ($request->hasFile('package_photos')) {
                foreach ($request->photo as $photo) {
                    $photoPath = $photo->store('package_photos/' . date('Y/m/d'), 'public');
                    $packageTour->package_photos()->create([
                        'photo' => $photoPath
                    ]);
                }
            }
        });

        return redirect()->route('admin.package_tours.show', $packageTour->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PackageTour $packageTour)
    {
        DB::transaction(function () use ($packageTour) {
            $packageTour->delete();
        });
        return redirect()->route('admin.package_tours.index');
    }
}
