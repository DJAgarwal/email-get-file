<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Mail\OtpEmail;
use Cache, Mail, Auth;
use App\Models\{User};

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated($request, $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.index');
        } else {
            return redirect()->route('home');
        }
    }

    public function showAdminLoginForm()
    {
        return view('admin.login');
    }

    public function userGetOtp(Request $request)
    {
        $user = User::where('email', $request->email)->whereNot('role','admin')->first();
        if($user){
            $otp = random_int(100000, 999999); 
            Cache::forget('otp_login_email-'.$request->email);                 
            Cache::add('otp_login_email-'.$request->email, $otp, now()->addMinutes(10));    
            Mail::to($user->email)->send(new OtpEmail($otp));
            return redirect()->route('otp')->with(['status' => 'success', 'message' => 'The OTP is sent to mobile number/E-mail','email' => $request->email], 200); 
        } else {
            return redirect()->back()->with('error', "Email doesn't exist.");
        }
    }

    public function otp()
    {
        return view('auth.otp');
    }

    public function userVerifyOtp(Request $request)
    {
        $otp = $request->otp;
        $email = $request->email;
        if(Cache::has('otp_login_email-'.$request->email)){                
            $otp_login_email = Cache::get('otp_login_email-'.$request->email); 
            if($otp_login_email == $otp){
                $user = User::where('email', $request->email)->whereNot('role','admin')->first();
                Auth::login($user);
                return redirect()->route('home');
            }else{
                return redirect()->back()->with('error', "Invalid OTP");
            }
        }else{
            return redirect()->back()->with('error', "Invalid OTP");
        }       
    }
}
