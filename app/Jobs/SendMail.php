<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email_id;

    protected $subject;

    protected $message_body;

    protected $template;

    protected $api_name;

    protected $api_description;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($email_id, $subject, $message_body, $template, $api_name, $api_description)
    {
        $this->email_id = $email_id;
        $this->subject = $subject;
        $this->message_body = $message_body;
        $this->template = $template;
        $this->api_name = $api_name;
        $this->api_description = $api_description;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $template = $this->template;
        $email_id = $this->email_id;
        $subject = $this->subject;
        $message_body = $this->message_body;
        $data = array('template' => $template, 'email' => $email_id, 'subject' => $subject, 'message_body' => $message_body);

        Mail::send($data['template'], $data, function ($message) use ($data) {
            $message->to($data['email'])->subject($data['subject']);
            $message->bcc(config('constants.ADMIN_EMAIL_ID'))->subject($data['subject']);
            $message->bcc(config('constants.SUB_ADMIN_EMAIL_ID'))->subject($data['subject']);
            $message->bcc(config('constants.PROJECT_MANAGER_EMAIL_ID'))->subject($data['subject']);
        });
    }

    public function failed()
    {
        try {

            $template = $this->template;
            $api_name = $this->api_name;
            $api_description = $this->api_description;
            $email_id = config('constant.ADMIN_EMAIL_ID');
            $subject = 'Email failed';
            $message_body = array(
                'message' => 'API Name = ' . $api_name . ' <br> API Description = ' . $api_description . '',
            );

            $data = array('template' => $template, 'email' => $email_id, 'subject' => $subject, 'message_body' => $message_body);

            Mail::send($data['template'], $data, function ($message) use ($data) {
                $message->to(config('constants.SUB_ADMIN_EMAIL_ID'))->subject($data['subject']);
            });

            Log::error('SendMail failed try : ');

        } catch (Exception $e) {
            Log::error('SendMail failed catch : ', ['Exception' => $e->getMessage(), '\nTraceAsString' => $e->getTraceAsString()]);
        }
    }

}
