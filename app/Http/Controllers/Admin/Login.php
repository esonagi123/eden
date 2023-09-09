<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\member;

class Login extends Controller
{
	public function index()
	{
		return view('admin.login.index');
	}

    public function check()
	{
        $uid = request('uid');
        $pwd = request('pwd');
		
		
		$row = member::where('uid', '=', $uid) -> where('pwd', '=', $pwd) -> first();
		if (!$row)
		{
			return redirect()->back()->with('fail', '일치하는 정보가 없습니다.');
		}
		else
		{
			session()->put('id', $row->id);
			session()->put('uid', $row->uid);
			session()->put('nickname', $row->nickname);
			session()->put('gubun', $row->gubun);
			return redirect('admin');
		}
		
	}

    public function logout(Request $request)
    {
        $request->session()->forget('uid');
		$request->session()->forget('id');
		$request->session()->forget('nickname');
		$request->session()->forget('gubun');
        return redirect('index');
    }	

}
