<?php

namespace App\Events;

use App\Models\MembershipRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MembershipRequestReviewed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public MembershipRequest $membershipRequest;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MembershipRequest $membershipRequest)
    {
        $this->membershipRequest = $membershipRequest;
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
