<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;


class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', array('except' => 'index'));
    }

    public function edit()
    {
        return view('auth.passwords.edit');
    }

    public function store(ChangePasswordRequest $request, Validator $validator)
    {
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('admin-profile', [Auth::user()->id])->with('status', 'Your new password was successfully saved.'); 
    }
}
