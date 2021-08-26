<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLog;
use Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {  
        $exito = false;
        $user = $request->user;
        $password = $request->password;

        if (Auth::attempt(['user' => $user, 'password' => $password])) {
            $request->session()->regenerate();
            $exito = true;
            
            //Registra al usuario en el log
            $userLog = new UserLog;
            $userLog->user = $user;
            $userLog->save();

            return response()->json(['user' => Auth::user(), 'exito' => $exito]);
        }else{
            return response()->json(['exito' => $exito]);
        }

    }

    public function index(){

        if(Auth::user()){
            return redirect('/');
        }

        return view('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
