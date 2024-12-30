<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersCT extends Controller
{
  public function index()
  {
    return view('content.Users.users');
  }
}
