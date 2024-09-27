<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function message(MessageRequest $request): JsonResponse
    {
        $message = new Message();
        $message->ticket_id = $request->ticket_id;
        $message->message = $request->message;
        $message->creater()->associate(admin());
        $message->save();
        $query = Message::where('ticket_id', $request->ticket_id);
        if ((clone $query)->count() == 1) {
            $ticket = Ticket::findOrFail($request->ticket_id);
            $ticket->status = 1;
            $ticket->updater()->associate(admin());
            $ticket->save();
        }
        $message = $query->with(['creater', 'ticket'])->where('id', $message->id)->first();
        $message->created_at = $message->created_at->diffForHumans();
        $message->author = getModelName($message->creater_type);
        $message->author_image = auth_storage_url($message->creater->image, $message->creater->gender);
        $message->ticket->getStatusBadgeBg = $message->ticket->getStatusBadgeBg();
        $message->ticket->getStatusBadgeTitle = $message->ticket->getStatusBadgeTitle();
        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
            'data' => $message
        ], 200);
    }
}
