<?php

// app/Http/Controllers/ChatsController.php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = Auth::id();

        // Ambil ID pengguna yang telah berinteraksi dengan pengguna saat ini
        $chattedUserIds = Chat::where('user_id', $userId)
            ->orWhere('recipient_id', $userId)
            ->pluck('user_id')
            ->merge(Chat::where('recipient_id', $userId)->pluck('user_id'))
            ->unique()
            ->filter(fn ($id) => $id != $userId)
            ->values();

        // Ambil data pengguna yang telah berinteraksi
        $chattedUsers = User::whereIn('id', $chattedUserIds)->get();

        // Ambil data semua pengguna kecuali pengguna saat ini
        $allUsers = User::where('id', '!=', $userId)->get();

        return view('chats.index', compact('chattedUsers', 'allUsers', 'chattedUserIds'));
    }

    public function fetchMessages($recipientId)
    {
        $chats = Chat::where(function ($query) use ($recipientId) {
            $query->where('user_id', Auth::id())
                ->where('recipient_id', $recipientId);
        })->orWhere(function ($query) use ($recipientId) {
            $query->where('user_id', $recipientId)
                ->where('recipient_id', Auth::id());
        })->with('user', 'recipient')->orderBy('created_at', 'asc')->get();

        return response()->json($chats);
    }

    public function send(Request $request, $recipientId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $chat = Chat::create([
            'user_id' => Auth::id(),
            'recipient_id' => $recipientId,
            'message' => $request->message,
        ]);

        return response()->json(['status' => 'Message sent successfully!', 'chat' => $chat]);
    }
}
