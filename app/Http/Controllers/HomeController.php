<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;


class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->confirmed != FALSE) {            
            return view('home');
        } else {
            return view('verify');
            //die("Primero verificar la cuenta");
        }
    }

    public function editProfile(){
        die("Edit Profile acction");
    }

    public function verify($register_code){
        $user = Auth::user();
        if ($user->confirmed){
            return view('home');
        }else {
            if ($register_code == $user->register_code){
                $user->confirmed = TRUE;
                $user->save();
                return view('home'); 
            } else {
                return view('verify');
            }
        }
    }

    public function resend(){
        $user = Auth::user();

        $data = array ('name' => $user->name, 'email' => $user->email, 'register_code' => $user->register_code);

        Mail::send('emails.welcome', $data, function($message) use ($data)
        {
            $message->from('no-reply@site.com', "Pulsar Tec");
            $message->subject("Welcome to PulsarTec");
            $message->to($data['email']);
        });

        \Session::flash('resend_message','A mail with instructions was sent to you email.');

        return view('verify');
    }

}
