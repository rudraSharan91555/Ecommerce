<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; // Corrected import statement
use App\Models\User; // Import the User model

class profileController extends Controller
{
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
            'email' => 'required|string|email|unique:users,email,'. Auth::id(),
            'image' => 'mimes:jpeg,png,jpg,gif|max:5120',
            'address' => 'required|string|max:255',
            'twitter_link' => 'string|max:255' ,
            'fb_link' => 'string|max:255' ,
            'insta_link' => 'string|max:255' ,
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => 400, 'message' => $validation->errors()->first()]);
        } else {
            if ($request->hasFile('image')) {
                $image_name = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $image_name);
            }

            $user = User::updateOrCreate(
                ['id' => Auth::user()->id],
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'image' => $image_name ?? null, 
                    'address' => $request->address,
                    'twitter_link' => $request->twitter_link,
                    'fb_link' => $request->fb_link,
                    'insta_link' => $request->insta_link,
                ]
            );

            return response()->json(['status' => 200, 'message' => 'Successfully updated']);
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
