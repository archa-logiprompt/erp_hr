<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Center;

class CenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $centerdetails = Center::all();
        return view('dashboard.center.index', compact('centerdetails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.center.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {
        $imagePath = null;
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'mobile' => 'required|digits:10|unique:center,mobile|',
            'email' => 'required|email|regex:/^[^.-][A-Za-z0-9._%+-]*@[A-Za-z0-9.-]+\.[A-Za-z]{2,6}$/',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048'
        ], [
            'image.required' => 'Image upload is required.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'Only JPG, PNG, JPEG, and GIF images are allowed.',
            'image.max' => 'Image size cannot exceed 2MB.',

            'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.regex' => 'Invalid email format. Email should not begin with a full stop or hyphen and must contain "@" symbol.',

            'mobile.required' => 'Mobile number is required.',
            'mobile.string' => 'Mobile number must be 10 digits.',
            'mobile.unique' => 'This mobile number is already in use.',

            'address.required' => 'Address is required.',
            'address.string' => 'Address must be a valid string.',
            'address.max' => 'Address cannot exceed 255 characters.',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = 'image/' . time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image'), $imagePath);
        }
        $data = $request->except('_token');
        $data['image'] = $imagePath;
        Center::create($data);
        return redirect('/admin/center');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $centerdata = Center::find($id);
        return view('dashboard.center.edit', compact('centerdata'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $imagePath = null;
        $request->validate([
            'name' => 'string|max:255',
            'address' => 'string|max:255',
            'mobile' => 'string|max:12',
            'email' => 'email|regex:/^[^.-][A-Za-z0-9._%+-]*@[A-Za-z0-9.-]+\.[A-Za-z]{2,6}$/',
            'image' => 'image|mimes:jpg,png,jpeg,gif|max:2048'
        ], [
            // 'image.required' => 'Image upload is required.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'Only JPG, PNG, JPEG and GIF images are allowed.',
            'image.max' => 'Image size cannot exceed 2MB.',

            // 'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.regex' => 'Invalid email format. Email should not begin with a full stop or hyphen and must contain "@" symbol.',

            // 'mobile.required' => 'Mobile number is required.',
            'mobile.digits' => 'Mobile number must be 10 digits.',
            'mobile.unique' => 'This mobile number is already in use.',

            // 'address.required' => 'Address is required.',
            'address.string' => 'Address must be a valid string.',
            'address.max' => 'Address cannot exceed 255 characters.',
        ]);

        $center = Center::find($id);
        $data = $request->except(['id', '_token']);
        if (!empty($center->image) && file_exists(public_path($center->image))) {
            unlink(public_path($center->image));
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = 'image/' . time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image'), $imagePath);
            $data['image'] = $imagePath;
        }

        $center->update($data);
        // return redirect('/admin/center');
        return response()->json(['message' => 'center updated successfully !'], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Center::destroy($id);
        // return redirect()->back();
        return response()->json(['message' => 'center deleted successfully !'], 200);

    }
}
