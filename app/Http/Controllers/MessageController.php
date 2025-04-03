<?php

namespace App\Http\Controllers;

use App\Jobs\SendMessage;
use App\Message;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function messages(Request $request): JsonResponse {
        $chatId = $request->chat_id;
        $messages = Message::where('chat_id', $chatId)
            ->orderBy('created_at', 'asc')
            ->get()->append("time");

        return response()->json($messages);
    }

    public function message(Request $request): JsonResponse {
        $channelName = $request->chat_id;
        $message = Message::create([
            'user_id' => auth()->id(),
            'chat_id' => $channelName,
            'text' => $request->get('text'),
        ]);
        SendMessage::dispatch($message, $channelName);

        return response()->json([
            'success' => true,
            'message' => "Message created and job dispatched.",
        ]);
    }
}
