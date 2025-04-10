<?php

namespace App\Console\Commands;

use App\Mail\SendMail;
use App\Models\Mail_Queue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;


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
            ->select('mail_Queue.id', 'mail_Queue.users_email', 'mail_Queue.subject', 'mail_Queue.mail_body', 'mail_queue.attachment_ids')
            ->get();
        // dd($emails);

        foreach ($emails as $email) {
            $changeEmail = trim($email->users_email, "\" \t\n\r\0\x0B");
            $attachmentIds = json_decode($email->attachment_ids, true);

            $attachments = [];
            if (!empty($attachmentIds)) {
                $attachments = DB::table('attachments')
                    ->whereIn('id', $attachmentIds)
                    ->pluck('path')
                    ->toArray();
            }

            Mail::html($email->mail_body, function ($message) use ($email, $changeEmail, $attachments) {
                $message->to($changeEmail)
                    ->subject($email->subject);

                foreach ($attachments as $path) {
                    $message->attach(storage_path('app/public/' . $path));
                }

                $email->is_sent = 1;
                $email->save();
            });
        }
    }
}
