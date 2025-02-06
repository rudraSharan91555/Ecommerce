<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Validator;

class colorController extends Controller
{
    use ApiResponse;

     public function index()
    {
        $data = Color::get();
        return view('admin/Color/color', get_defined_vars());
    }

    // public function store(Request $request)
    // {

    //     $validation = Validator::make($request->all(), [
    //         'value'    => 'required|string|max:255',
    //         'text'    => 'required|string|max:255',
    //         'id'    => 'required',
    //     ]);

    //     if ($validation->fails()) {
    //         return $this->error($validation->errors()->first(), 400, []);
    //         // return response()->json(['status'=>400,'message'=>$validation->errors()->first()]);
    //     } else {
           
    //         Color::updateOrCreate(
    //             ['id' => $request->id],
    //             ['text' => $request->text,'value' => $request->value, ]
    //         );
    //         return $this->success(['reload' => true], 'Successfully updated');
    //     }
    // }
    public function store(Request $request)
{
    $validation = Validator::make($request->all(), [
        'value' => 'required|string|max:255',
        'text'  => 'required|string|max:255',
        'id'    => 'required',
    ]);

    if ($validation->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => $validation->errors()->first()
        ]);
    }

    Color::updateOrCreate(
        ['id' => $request->id],
        ['text' => $request->text, 'value' => $request->value]
    );

    return response()->json([
        'status' => 'success',
        'message' => 'Successfully updated'
    ]);
}

}