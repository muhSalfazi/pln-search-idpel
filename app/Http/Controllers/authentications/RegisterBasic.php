<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class RegisterBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-register-basic');
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'username' => 'required|string|max:50|unique:users,username',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:2',
    ]);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    // Simpan data user
    try {
      $user = User::create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
      ]);

      return redirect('/')->with('success', 'Registration successful! Please log in.');
    } catch (\Exception $e) {
      return redirect()->back()->with('error', 'Failed to register user. Please try again.');
    }
  }


}
