<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    
    // use middleware so the functions of this controller can only be accessed by user with role 'Member'
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get the current user data and then pass the user data with success/warning messages 
     * from the Session to the edit profile view
     */
    public function edit() {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        return view('auth.edit')->with([
            'user' => $user,
            'message_success' => Session::get('message_success'),
            'message_warning' => Session::get('message_warning')
        ]);
    }

    /**
     * Perform update profile operation
     * First validate the input from the Request
     * Then update the profile onto the database based on the current user id
     * After that, return back to the page with a success message.
     */
    public function update(Request $request) {
        $this->validate($request, [
            'name' => ['required', 'string', 'min:6', 'max:255'],
            'dob' => ['required', 'date_format:Y-m-d', 'before:today'],
            'address' => ['required', 'string', 'min:10'],
            'gender' => ['required', 'in:male,female'],
        ]);

        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $user->update([
            'name' => $request->name,
            'dob' => $request->dob,
            'address' => $request->address,
            'gender' => $request->gender,
        ]);

        return redirect()->back()->with([
            'message_success' => "Your profile has been successfully updated."
        ]);
    }
}
