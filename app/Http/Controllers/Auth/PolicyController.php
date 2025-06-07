<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function update(Request $request)
    {
        $request->user()->update(['policy_accepted' => true]);

        return redirect()->back();
    }
}
