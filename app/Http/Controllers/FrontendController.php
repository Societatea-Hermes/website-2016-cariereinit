<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\User;

use Carbon\Carbon;
use Session;

class FrontendController extends Controller
{
    public function renderFrontend() {
    	return view('frontend');
    }
}
