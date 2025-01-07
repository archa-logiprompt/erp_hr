<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientDetails;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Nakanakaii\Countries\Countries;

class ClentController extends Controller
{

    public function index()
    {

        $clientdetails = ClientDetails::all();

        return view('dashboard.clientData.index', compact('clientdetails'));
    }

    public function create()
    {
        $countries = Countries::all();
        // dd($countries);
        return view('dashboard.clientData.create', compact('countries'));
    }


    public function store(Request $request)
    {

       $request->validate(
    [
        'salutation' => 'nullable|string|max:50',  // Optional, string, and limit to 50 characters.
        'name' => 'required|string|max:255',  // Name is required, string, and max 255 characters.
        'email' => 'nullable|email|max:255',  // Email is optional, but if provided must be a valid email.
        'ProfilePicture' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Optional, image file and size restriction.
        'country' => 'nullable|string|max:100',  // Optional, string, with a max length of 100 characters.
        'mobileDialCode' => 'nullable|string|max:10',  // Optional, string with a max length of 10 characters.
        'mobile' => 'nullable|string|regex:/^\d{10,15}$/',  // Mobile number is required, must be between 10-15 digits.
        'gender' => 'nullable|string|in:Male,Female,Others',  // Optional, string and must be one of the defined values.
        'companyName' => 'required|string|max:255',  // Optional, string, and max length of 255 characters.
        'officialWebsite' => 'nullable|url|max:255',  // Optional, valid URL format.
        'gstNumber' => 'required|string|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9]{1}[A-Z]{1}[0-9]{1}$/',  // Optional, GST number validation regex.
        'officePhone' => 'required|string|regex:/^\d{10,15}$/',  // Optional, must be 10-15 digits.
        'city' => 'nullable|string|max:100',  // Optional, string with a max length of 100 characters.
        'state' => 'nullable|string|max:100',  // Optional, string with a max length of 100 characters.
        'postalCode' => 'nullable|string|max:20',  // Optional, postal code as string to accommodate different formats.
        'companyAddress' => 'required|string|max:500',
        'shippingAddress' => 'nullable|string|max:500', 
        'note' => 'nullable|string|max:1000',  
        'logo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        'password' => 'nullable|string|min:6|max:255', 
    ],
    [
        'ProfilePicture.mimes' => 'Only jpeg, png, jpg, gif, svg extensions are allowed for the Profile Picture!',
        'logo.mimes' => 'Only jpeg, png, jpg, gif, svg extensions are allowed for the Logo!',
        'gstNumber.regex' => 'Please enter a valid GST/VAT number!',
        'mobile.regex' => 'Please enter a valid mobile number (10 to 15 digits)!',
        'officePhone.regex' => 'Please enter a valid office phone number (10 to 15 digits)!',
        'officialWebsite.url' => 'Please enter a valid URL for the official website!',
    ]
);


        $userid = User::insertGetId(
            [
                'name' => $request->name,
                'email' => $request->email,
                // 'password' => $request->password
                'password' => Hash::make($request->password),
            ]
        );
        $data = $request->except('_token', 'password', 'email');

        $imagePath = null;
        if ($request->hasFile('ProfilePicture')) {
            $image = $request->file('ProfilePicture');
            $imagePath = 'profilePicture/' . time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('profilePicture'), $imagePath);
        }

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoPath = 'logo/' . time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('logo'), $logoPath);
        }

        $data['salutation'] = $request->salute;
        $data['shippingAddress'] = $request->shippingAdd;
        $data['ProfilePicture'] = $imagePath;
        $data['logo'] = $logoPath;
        $data['userId'] = $userid;
        $data['mobileDialCode'] = $request->dialCode;

        
       
        ClientDetails::create($data);
        return redirect('/admin/client');
    }

    public function destroy($id){
   
        ClientDetails::destroy($id);
    
        // return redirect()->back(); 
        return response()->json(['message' => 'Client deleted successfully !'], 200);

    }

    public function edit($id)
    {
        $clientdata = ClientDetails::with('user')->find($id);
        $countries = Countries::all();
        return view('dashboard.clientData.edit', compact('clientdata','countries'));
    }


    // public function update(Request $request, $id)
    // {
    //     // $request->validate([
    //     //     'coursename' => 'required|unique:courses',
    //     //     'fee' => 'required',
    //     //     'duration' => 'required',
    //     // ]);
    //     $client = ClientDetails::find($id);

    //     if (!$client) {
    //         return redirect()->back()->with('error', 'Client not found');
    //     }
    //     $user = User::find($client->userId);

    //     if ($user) {
    //         $user->update([
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             // 'password' => $request->password ? Hash::make($request->password) : $user->password,
    //             'password' => $request->password,

    //         ]);
    //     }

    //     $data = $request->except('_token', 'password', 'email',);

    //     $imagePath = null;
    //     if ($request->hasFile('ProfilePicture')) {
    //         $image = $request->file('ProfilePicture');
    //         $imagePath = 'profilePicture/' . time() . '_' . $image->getClientOriginalName();
    //         $image->move(public_path('profilePicture'), $imagePath);
    //     }

    //     $logoPath = null;
    //     if ($request->hasFile('logo')) {
    //         $logo = $request->file('logo');
    //         $logoPath = 'logo/' . time() . '_' . $logo->getClientOriginalName();
    //         $logo->move(public_path('logo'), $logoPath);
    //     }

    //     $data['salutation'] = $request->salute;
    //     $data['shippingAddress'] = $request->shippingAdd;
    //     $data['ProfilePicture'] = $imagePath;
    //     $data['logo'] = $logoPath;

    //     // ClientDetails::find($id)->update($data);

    //     $client->update($data);
    //     return redirect('/admin/client');
    // }


//     public function update(Request $request, $id)
// {
//     $client = ClientDetails::find($id);

//     if (!$client) {
//         return redirect()->back()->with('error', 'Client not found');
//     }
    
//     $user = User::find($client->userId);

//     if ($user) {
//         $user->update([
//             'name' => $request->name,
//             'email' => $request->email,
//             'password' => $request->password ? Hash::make($request->password) : $user->password,
//         ]);
//     }

//     $data = $request->except('_token', 'password', 'email');

//     $imagePath = $client->ProfilePicture; 
//     if ($request->hasFile('ProfilePicture')) {
//         $image = $request->file('ProfilePicture');
//         $imagePath = 'profilePicture/' . time() . '_' . $image->getClientOriginalName();
//         $image->move(public_path('profilePicture'), $imagePath);
//     }

//     $logoPath = $client->logo; 
//     if ($request->hasFile('logo')) {
//         $logo = $request->file('logo');
//         $logoPath = 'logo/' . time() . '_' . $logo->getClientOriginalName();
//         $logo->move(public_path('logo'), $logoPath);
//     }

//     $data['salutation'] = $request->salute;
//     $data['shippingAddress'] = $request->shippingAdd;
//     $data['ProfilePicture'] = $imagePath;
//     $data['logo'] = $logoPath;
//     $data['mobileDialCode'] = $request->dialCode;


//     $client->update($data);

//     return redirect('/admin/client');
// }
public function update(Request $request, $id)
{
    $client = ClientDetails::find($id);

    if (!$client) {
        return redirect()->back()->with('error', 'Client not found');
    }
    
    $user = User::find($client->userId);

    if ($user) {
        // Ensure that password is updated only if new one is provided
        $password = $request->password ? Hash::make($request->password) : $user->password;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
        ]);
    }

    // Get all fields except the ones we excluded
    $data = $request->except('_token', 'password', 'email');

    // Handle Profile Picture upload
    $imagePath = $client->ProfilePicture; 
    if ($request->hasFile('ProfilePicture')) {
        // Validate the image file (optional)
        $image = $request->file('ProfilePicture');
        $image->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = 'profilePicture/' . time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('profilePicture'), $imagePath);
    }

    // Handle Logo upload
    $logoPath = $client->logo; 
    if ($request->hasFile('logo')) {
        // Validate the logo file (optional)
        $logo = $request->file('logo');
        $logo->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $logoPath = 'logo/' . time() . '_' . $logo->getClientOriginalName();
        $logo->move(public_path('logo'), $logoPath);
    }

    // Update other fields
    $data['salutation'] = $request->salute;
    $data['shippingAddress'] = $request->shippingAdd;
    $data['ProfilePicture'] = $imagePath;
    $data['logo'] = $logoPath;
    $data['mobileDialCode'] = $request->dialCode;

    // Update client details
    $client->update($data);
    return response()->json(['message' => 'Client data updated successfully in web!'], 200);

    // return redirect('/admin/client')->with('success', 'Client updated successfully');
}



}
