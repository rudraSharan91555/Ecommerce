<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeBanner;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Traits\ApiResponse;
use DB;

class HomeBannerController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = HomeBanner::get();
        return view('admin/HomeBanner/home_banners', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Add logic if a separate create view is needed
    }

    /**
     * Store a newly created or updated resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validation = Validator::make($request->all(), [
            'id' => 'nullable|integer',
            'text' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        }

        // Find existing banner or create a new instance
        $banner = $request->id ? HomeBanner::findOrFail($request->id) : new HomeBanner();

        // Handle the image upload
        if ($request->hasFile('image')) {
            // Delete old image if updating
            if ($banner->image) {
                $oldImagePath = public_path("images/{$banner->image}");
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            // Upload new image
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/'), $imageName);
            // $banner->image = $imageName;
            $banner->image = 'storage/images/' . $imageName;

        } elseif (!$banner->exists) {
            // Set default image if creating a new banner without an image
            $banner->image = 'default.png'; // Ensure 'default.png' exists in 'public/images/'
        }

        // Update other fields
        $banner->text = $request->text;
        $banner->link = $request->link;

        // Save the banner
        $banner->save();

        // Redirect with success message
        return back()->with(['success' => 'Successfully updated!', 'reload' => true]);
    }





    public function deletData($id = '', $table = '') {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Add logic to display a specific resource if needed
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Add logic to edit a specific resource if needed
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Add logic to update a specific resource if needed
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Add logic to delete a specific resource
    }
}
