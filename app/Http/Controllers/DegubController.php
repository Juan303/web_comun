<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Csnet\Facades\Debug;
use Illuminate\Support\Facades\Auth;

class DegubController extends Controller
{
    public function switchDebug(Request $request){
        dd($request->all());
        $desactivarDebug = $request->get('desactivarDebug');
        Session::put('desactivarDebug', $desactivarDebug);
        dd(Session::all());
        Debug::setDatabase();
        Auth::guard('admin')->logout();
        Auth::guard('web')->logout();
        return back();
    }
}
