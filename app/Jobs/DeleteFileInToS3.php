<?php

namespace App\Jobs;

use App\Http\Controllers\ImageController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class DeleteFileInToS3 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $file_path;
    public $file_name;
    public $folder_name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file_path, $file_name, $folder_name)
    {
        $this->file_path = $file_path;
        $this->file_name = $file_name;
        $this->folder_name = $folder_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {

            if (config('constants.STORAGE') === 'S3_BUCKET') {
                (new ImageController())->deleteObjectFromS3($this->file_name, $this->folder_name);
            } else {
                (new ImageController())->unlinkFileFromLocalStorage($this->file_name, './public/' . $this->file_path);
            }

        } catch (Exception $e) {
            Log::error('DeleteFileInToS3 : ', ['Exception' => $e->getMessage(), '\nTraceAsString' => $e->getTraceAsString()]);
        }
    }

    public function failed()
    {
        try {

            $template = 'simple';
            $email_id = config('constants.ADMIN_EMAIL_ID');
            $subject = 'Email failed';
            $message_body = array(
                'message' => 'API Name = DeleteFileInToS3 <br> API Description = DeleteFileInToS3 job failed',
                'user_name' => 'Admin'
            );

            $data = array('template' => $template, 'email' => $email_id, 'subject' => $subject, 'message_body' => $message_body);

            Mail::send($data['template'], $data, function ($message) use ($data) {
                $message->to(config('constants.SUB_ADMIN_EMAIL_ID'))->subject($data['subject']);
            });

            Log::error('DeleteFileInToS3 failed try : ');

        } catch (Exception $e) {
            Log::error('DeleteFileInToS3 failed catch : ', ['Exception' => $e->getMessage(), '\nTraceAsString' => $e->getTraceAsString()]);
        }
    }
}
