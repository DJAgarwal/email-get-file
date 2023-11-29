<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{File, User};

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = User::whereNotNull('last_seen')->where('role','user')->orderBy('last_seen','DESC')->get();
        return view('admin.index',compact('data'));
    }
}
