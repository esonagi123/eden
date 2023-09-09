<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\member;

class Dashboard extends Controller
{
	
    public function index()
    {
		if (session()->exists("uid"))
		{
			return view('admin.dashboard.index');
		}
		else
		{
			return redirect('login');
		}
		
    }
}
