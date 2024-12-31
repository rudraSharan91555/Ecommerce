<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Traits\ApiResponse;

class profileController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin/profile');
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
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . Auth::id(),
            'phone' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif|max:5120',
            'address' => 'string|max:255',
            'twitter_link' => 'string|max:255',
            'fb_link' => 'string|max:255',
            'insta_link' => 'string|max:255',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            // Check if the user uploaded a new image
            if ($request->hasFile('image')) {
                // Generate a unique name for the uploaded image
                $image_name = time() . '.' . $request->image->extension();
                // Move the image to the 'images' folder in the public directory
                $request->image->move(public_path('images'), $image_name);
            } else {
                // If no new image is uploaded, keep the current image
                $image_name = Auth::User()->image;
            }

            // Update or create the user record
            $user = User::updateOrCreate(
                ['id' => Auth::user()->id],
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'image' => $image_name, // Store the image name, not the raw image file
                    'address' => $request->address,
                    'twitter_link' => $request->twitter_link,
                    'fb_link' => $request->fb_link,
                    'insta_link' => $request->insta_link,
                ]
            );

            // Redirect with a success message
            return redirect()->route('profile.index')->with('success', 'Profile updated successfully!');
        }
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
