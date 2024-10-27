<?php

namespace App\Jobs;

use App\Http\Controllers\Dashboard\NotificationController;
use App\Models\Client;
use App\Models\ClientFriend;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $friends,$client_id,$share_data,
        $propertiesModified_add,$propertiesModified_update,$client_name;
    protected $properties_add    = [];
    protected $properties_update = [];
    public function __construct($friends, $client_id, $info)
    {
        $this->friends            = $friends;
        $this->client_id          = $client_id;
        $this->properties_add     = $info['properties']->properties_add;
        $this->properties_update  = $info['properties']->properties_update;
        $this->client_name        = $info['client_name'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(){

        $client = Client::find($this->client_id);
        $my_qr_code = $client['qr_code'];
        foreach ($this->friends as $friend) {
            $this->propertiesModified_add    = null;
            $this->propertiesModified_update = null;
            $client_friend  = ClientFriend::where([
                'client_id'       => $friend['id'],
                'friend_id'       => $client['id']
            ])->first();
            $share_data = $client_friend['share_data'];

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

                NotificationController::sendSingleNotification( $friend->id ,
                    __('api.Your friend has changed their profile',[],$friend['lang']),
                    __('api.Your friend has changed their profile',[],$friend['lang']),
                    $body,
                    $body,
                    $my_qr_code ,$share_data,1, 1);
      }
    }
}
