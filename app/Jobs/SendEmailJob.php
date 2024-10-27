<?php

namespace App\Jobs;

use App\Mail\NotifyMail;
use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $friends,$client_id,$client_name,
        $subject,$msg,$propertiesModified,
        $propertiesModified_add,$propertiesModified_update;
    public $properties_add = [];
    public $properties_update = [];
    public function __construct($friends, $client_id, $info)
    {
        $this->friends     = $friends;
        $this->client_id   = $client_id;
        $this->properties_add     = $info['properties']->properties_add;
        $this->properties_update  = $info['properties']->properties_update;
        $this->client_name        = $info['client_name'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = Client::find($this->client_id);
        $qr_code    = $client['qr_code'];
            foreach ($this->friends as $friend){
            //    $data = ['msg' => 'لا حول ولا قوة الا بالله العلى العظيم'];
                foreach ($this->properties_add as $index => $property){
                    if ($index)
                        $this->propertiesModified_add .= ' - ';
                    $this->propertiesModified_add .=
                        __('site.' . $property ,[],$friend['lang']);
                }
                foreach ($this->properties_update as $index => $property){
                    if ($index)
                        $this->propertiesModified_update .= ' - ';
                    $this->propertiesModified_update .=
                        __('site.' . $property ,[],$friend['lang']);
                }
                $body_add    = $this->client_name .   __('site.added their',[],$friend['lang']) . ' ' . $this->propertiesModified_add;
                $body_update =  __('site.updated their',[],$friend['lang']) . ' ' . $this->propertiesModified_update;

                if ($this->propertiesModified_add){
                    $body = $body_add;
                }
                if ($this->propertiesModified_update){
                    $body =  $this->client_name .__('site.updated their',[],$friend['lang']) . ' ' . $this->propertiesModified_update;
                }
                if ($this->propertiesModified_add && $this->propertiesModified_update){
                    $body = $body_add . __('site.and',[],$friend['lang']) . $body_update;
                }
                    $this->subject = __('api.Your friend has changed their profile',[],$friend['lang']);
                    $this->msg     =  $body;



                $data = [
                'subject'     => $this->subject,
                'msg'         => $this->msg,
                'qr_code'     => $qr_code
            ];
            Mail::to($friend['email'])->send(new NotifyMail($data));

        }
    }
}
