<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessageNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $order;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($order,$message)
    {
        $this->message = $message;
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    { 
        return new Channel('orderNotification');
    }
    public function broadcastWith()
    {   
        if (filter_var(Auth::guard('web')->user()->avatar, FILTER_VALIDATE_URL)){
            $image = Auth::guard('web')->user()->avatar;
        }
        else{
            $image = Storage::disk('user-avatar')->url(Auth::guard('web')->user()->avatar == null ? 'unknown.png' : Auth::guard('web')->user()->avatar);
        }
        return ['image' => $image,'message' => $this->message,'link' => url('admin/orders/'.$this->order->id)];
    }
}