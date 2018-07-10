<?php

namespace App\Events\LoanApproval;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Saved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {

        DB::connection('loan')->table('application_process')->insert(
            [
                'action'         => 'update'
                , 'application_id' => 1
                , 'status'         => 1
                , 'user_id'        => Auth::id()
                , 'description'    => 1
                , 'created_at'     => Carbon::now()
                , 'updated_at'     => Carbon::now()
            ]
        );

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
