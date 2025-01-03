<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeBanner;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Traits\ApiResponse;

class homeBannerController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = HomeBanner::get();
        return view('admin/HomeBanner/home_banners', get_defined_vars());
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

    

    // fresh one
    //   public function store(Request $request)
    // {
    //     $validation = Validator::make($request->all(), [
    //         'text' => 'required|string|max:255',
    //         'image' => 'mimes:jpeg,png,jpg,gif|max:5120',
    //         'link' => 'string|max:255',
    //         'id' => 'required',
    //     ]);

    //     if ($validation->fails()) {
    //         return $this->error($validation->errors()->first(), 400, []);
    //     } else {
    //         $image_name = ''; // Initialize the variable to avoid undefined errors

    //         if ($request->hasfile('image')) {
    //             if ($request->id > 0) {
    //                 $image = HomeBanner::where('id', $request->id)->first();
    //                 $image_path = "images/" . $image->image . "";
    //                 if (File::exists($image_path)) {
    //                     File::delete($image_path);
    //                 }
    //             }
    //             $image_name = time() . '.' . $request->image->extension();
    //             $request->image->move(public_path('images/'), $image_name);
    //         } elseif ($request->id > 0) {
    //             $image_name = HomeBanner::where('id', $request->post('id'))->pluck('image')->first();
    //         }

    //         HomeBanner::updateOrCreate(
    //             ['id' => $request->id],
    //             ['text' => $request->text, 'link' => $request->link, 'image' => $image_name]
    //         );

    //         return back()->with('success', 'Updated successfully!');
    //     }
    // }
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

        // Find the existing banner or create a new instance
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
            $banner->image = $imageName;
        } elseif (!$banner->exists) {
            // Set a default image if creating a new banner without an image
            $banner->image = 'default.png'; // Ensure this image exists in your `public/images` directory
        }

        // Update other fields
        $banner->text = $request->text;
        $banner->link = $request->link;

        // Save the banner
        $banner->save();

        // Redirect with success message
        return back()->with('success', 'Home Banner saved successfully!');
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
