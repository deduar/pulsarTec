<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Libraries\ConsumerPaypal;
use App\PaypalTransactions;

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
        $paypalTransaction = PaypalTransactions::where('user_id','=',$user->id)->get();
        if ($user->confirmed != FALSE) {
            if (\Carbon\Carbon::parse($user->created_at)->addDay(1) < \Carbon\Carbon::now()){
                if(count($paypalTransaction) > 0){
                    return view('renew');
                } else {
                    return view('endDate');
                }
            } else {
                if(count($paypalTransaction) == 0){
                    return view('home');
                } else {
                    return view('renew');
                }
            }
        } else {
            return view('verify');
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

    public function pay($amt, $lang)
    {
        if ($lang == "en"){
            $currency = "USD";
            $amount = ((float)$amt)*1.23;
        } else {
            $currency = "EUR";
            $amount = ((float)$amt);
        }
        $paypal = new ConsumerPaypal();
        $approvalUrl = $paypal->savePaymentWithPaypal($currency,$amount);

        header('Location: '.$approvalUrl);
        exit;
    }

    public function payRenew(){
        $user = Auth::user();
        $user->created_at = \Carbon\Carbon::now()->addDay(-20);
        return view('endDate');
    }

    public function paypalpaymentresponse($res)
    {
        if($res == true)
        {
            $paymentId = $_GET["paymentId"];
            $token = $_GET["token"];
            $payerId = $_GET["PayerID"];
            
            $paypal = new ConsumerPaypal();
            $payment = $paypal->execute_payment($paymentId, $payerId);

            $this->getPaymentWithPayPal(
                $payment->toArray()['transactions'][0]['related_resources'][0]['authorization']['id'],
                $payment->toArray()['transactions'][0]['amount']['total'],
                $payment->toArray()['transactions'][0]['amount']['currency']
            );

            $this->updatePayWithPayPal(
                $payment->toArray()['transactions'][0]['related_resources'][0]['authorization']['id'],
                $payment->toArray()['transactions'][0]['amount']['total'],
                $payment->toArray()['transactions'][0]['amount']['currency']
            );
            return view('home');

        }
        else 
        {
            echo "Payment failed";
        }
    }


    public function getPaymentWithPayPal($transactions_id,$amt,$currency)
    {
        $paypalTest = new ConsumerPaypal();
        $get_payment_with_paypal = $paypalTest->getPaymentWithPayPal($transactions_id,$amt,$currency);
        return view ('home');
    }

    public function updatePayWithPayPal($transaction_id,$amt,$currency){
        $user = Auth::user();

        $paypalTransaction = new PaypalTransactions();
        $paypalTransaction->user_id = $user->id;
        $paypalTransaction->transaction_id = $transaction_id;
        $paypalTransaction->amount = $amt;
        $paypalTransaction->currency = $currency;

        $paypalTransaction->save();

    }
}
