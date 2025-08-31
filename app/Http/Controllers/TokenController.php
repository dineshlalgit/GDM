<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function view(Token $token)
    {
        return view('tokens.view', compact('token'));
    }

    public function markAsUsed(Token $token)
    {
        $token->update(['status' => 'used']);

        return redirect()->back()->with('success', 'Token marked as used successfully!');
    }
}
