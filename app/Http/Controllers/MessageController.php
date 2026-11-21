<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function create()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:160',
            'body' => 'required|string|min:10|max:5000',
        ]);

        $data['user_id'] = $request->user()?->id;
        Message::create($data);

        return back()->with('success', 'Köszönjük, üzenetét elmentettük.');
    }

    public function index()
    {
        return view('messages.index', ['messages' => Message::latest()->paginate(20)]);
    }
}
