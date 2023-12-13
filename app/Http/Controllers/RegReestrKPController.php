<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegReestrKP;

class RegReestrKPController extends Controller
{
    public function index()
    {
        $RegReestrKP = RegReestrKP::all();

        return view('commercial-offers', compact('RegReestrKP'));
    }
}
