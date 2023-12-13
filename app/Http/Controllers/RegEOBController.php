<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegEOB;

class RegEOBController extends Controller
{
    public function index()
    {
        $data = RegEOB::all();
        return view('home', ['data' => $data]);
    }
}
