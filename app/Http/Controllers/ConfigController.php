<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfigController extends Controller
{
    public function category()
    {
        $data = [
            'page' => 'Management Category',
            'user' => Auth::user(),
        ];
        return view('config.category', $data);
    }
}
