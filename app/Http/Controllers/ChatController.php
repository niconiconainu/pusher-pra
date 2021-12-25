<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('post');
    }

    public function fetchMessages()
    {
        // dd(Message::with('user')->get());
        return Message::with('user')->get();
    }

    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        dd($user);
        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);
        
        dd($message);
        event(new MessageSent($user, $message));

        return ['status' => 'Message Sent!'];
    }
}
