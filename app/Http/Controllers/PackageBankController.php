<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageBankRequest;
use App\Models\PackageBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PackageBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banks = PackageBank::orderByDesc('id')->paginate(10);
        $banks->getCollection()->map(function ($bank) {
            $bank->logo_url = Storage::url($bank->logo);
            $bank->formatted_created_at = $bank->created_at->format('M d, Y');
            return $bank;
        });
        return Inertia::render('Admin/PackageBank/Index', [
            'banks' => $banks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/PackageBank/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PackageBankRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
                $validated['logo'] = $logoPath;
            }

            $newBank = PackageBank::create($validated);
        });

        return redirect()->route('admin.package_banks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(PackageBank $packageBank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PackageBank $packageBank)
    {
        $packageBank->logo_url = Storage::url($packageBank->logo);
        return Inertia::render('Admin/PackageBank/Edit', [
            'bank' => $packageBank
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PackageBankRequest $request, PackageBank $packageBank)
    {
        DB::transaction(function () use ($request, $packageBank) {
            $validated = $request->validated();
            $validated['logo'] = $packageBank->logo;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
                $validated['logo'] = $logoPath;
            }

            $packageBank->update($validated);
        });

        return redirect()->route('admin.package_banks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PackageBank $packageBank)
    {
        DB::transaction(function () use ($packageBank) {
            $packageBank->delete();
        });
        return redirect()->back();
    }
}
