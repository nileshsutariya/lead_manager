<?php

namespace App\Console\Commands;

use App\Mail\SendMail;
use App\Models\Mail_Queue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class Laravel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Scheduled Mail';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $emails = Mail_Queue::where('mail_queue.is_sent', 0)
            ->join('data', 'mail_queue.users_email', '=', 'data.id')
            ->select('data.email', 'mail_queue.id', 'mail_Queue.mail_body', 'mail_Queue.subject')
            ->get();

        print_r($emails);
        die;

        foreach ($emails as $email) {
            Mail::raw($email->message, function ($message) use ($email) {
                $message->to($email->email)
                    ->subject('Your Email Subject Here');
                $email->is_sent = 1;
                $email->save();
            });
        }
    }
}
