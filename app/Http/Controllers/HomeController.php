<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Libraries\ConsumerPaypal;
use App\PaypalTransactions;
use Config;

use Illuminate\Support\Facades\DB;

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
            if (\Carbon\Carbon::parse($user->created_at)->addDay(Config::get('constants.options.end_date')) < \Carbon\Carbon::now()){
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

                $data = array ('name' => $user->name, 'email' => $user->email);

                Mail::send('emails.welcome', $data, function($message) use ($data){
                    $message->from(Config::get('constants.options.no_reply'), "Pulsar Tec");
                    $message->subject("Welcome to PulsarTec");
                    $message->to($data['email']);
                });

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
            $message->subject("Register into PulsarTec");
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
        $user->created_at = \Carbon\Carbon::now()->addDay(Config::get('constants.options.end_date'));
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
            return view('renew');
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

    public function updatePayWithPayPal($transaction_id,$amt,$currency)
    {
        $user = Auth::user();

        $paypalTransaction = new PaypalTransactions();
        $paypalTransaction->user_id = $user->id;
        $paypalTransaction->transaction_id = $transaction_id;
        $paypalTransaction->amount = $amt;
        $paypalTransaction->currency = $currency;

        $paypalTransaction->save();

    }

    public function testByDue()
    {
        $endDateBegin = \Carbon\Carbon::today()->subDays(Config::get('constants.options.end_date_begin'))->toDateTimeString();
        $endDateEnd = \Carbon\Carbon::today()->addDays(Config::get('constants.options.end_date_end'))->toDateTimeString();

        $userEndDate = DB::table('users')
              ->whereBetween('created_at',array($endDateBegin,$endDateEnd))
              ->get();

        $data = array('begin'=>$endDateBegin, 'end'=>$endDateEnd, 'data'=>$userEndDate, 'key'=>0, 'beginDate'=>null, 'endDate'=>null);

        foreach ($data['data'] as $key=>$user) {
            $data['endDate'] = date('Y-m-d H:s', strtotime($user->created_at . " +30 days"));
            $data['key']=$key;

            Mail::send('emails.cron', $data, function($message) use ($data){
                $message->from(Config::get('constants.options.no_reply'), "Pulsar Tec");
                $message->subject("Cron of PulsarTec");
                $message->to($data['data'][$data['key']]->email);
            });            

        }

        Mail::send('emails.cron_summary', $data, function($message) use ($data){
            $message->from(Config::get('constants.options.no_reply'), "Pulsar Tec");
            $message->subject("Summary Cron of PulsarTec");
            $message->to(Config::get('constants.options.cron_mail'));
        });

        echo "Mailed sender By Cron";
    }

    public function testByEnding(){
        $endDate = \Carbon\Carbon::today()->subDays(Config::get('constants.options.end_date'))->toDateTimeString();

        $userEndDate = DB::table('users')
              ->where('created_at','<',$endDate)
              ->get();

        $data = array('data'=>$userEndDate, 'key'=>0);

        foreach ($data['data'] as $key=>$user) {
            $data['key']=$key;

            Mail::send('emails.cron_ending', $data, function($message) use ($data){
                $message->from(Config::get('constants.options.no_reply'), "Pulsar Tec");
                $message->subject("Ending Trial PulsarTec");
                $message->to($data['data'][$data['key']]->email);
            });            

        }

        Mail::send('emails.cron_summary_ending', $data, function($message) use ($data){
            $message->from(Config::get('constants.options.no_reply'), "Pulsar Tec");
            $message->subject("Summary Cron Endining of PulsarTec");
            $message->to(Config::get('constants.options.cron_mail'));
        });

        echo "Mailed sender By Ending";
    }


}
