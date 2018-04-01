<?php
namespace App\Console\Commands;
 
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Mail;
use Config;
 
class UserStatistics extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'statistics:user';
 
  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Update user statistics';
 
  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }
 
  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    $endDateBegin = \Carbon\Carbon::today()->subDays(Config::get('constants.options.end_date_begin'))->toDateTimeString();
    $endDateEnd = \Carbon\Carbon::today()->addDays(Config::get('constants.options.end_date_end'))->toDateTimeString();

    $userEndDate = DB::table('users')
          ->whereBetween('created_at',array($endDateBegin,$endDateEnd))
          ->get();

    $data = array('begin'=>$endDateBegin, 'end'=>$endDateEnd, 'data'=>$userEndDate);
    Mail::send('emails.cron', $data, function($message) use ($data){
        $message->from(Config::get('constants.options.no_reply'), "Pulsar Tec");
        $message->subject("Cron of PulsarTec");
        $message->to(Config::get('constants.options.cron_mail'));
    });
  }
}