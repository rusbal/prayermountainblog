<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests\UserProfileRequest;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        return view('admin.profile', compact('user'));
    }

    public function update(UserProfileRequest $request)
    {
        $user = Auth::user();
        $user->name     = $request->name;
        $user->initials = $request->initials;
        $user->color    = $request->color;
        $user->save();

        return redirect()->back()->with('status', 'Your profile was successfully updated.'); 
    }
}
