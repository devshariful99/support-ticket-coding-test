<?php

namespace App\Http\Controllers\User;

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
        $this->middleware('auth');
    }

    public function message(MessageRequest $request): JsonResponse
    {
        $message = new Message();
        $message->ticket_id = $request->ticket_id;
        $message->message = $request->message;
        $message->creater()->associate(user());
        $message->save();

        $message = Message::with(['creater', 'ticket'])->findOrFail($message->id);
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
