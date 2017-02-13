<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\User;

use Session;

class FrontendController extends Controller
{
    public function renderFrontend() {
    	$userData = Session::get('userData');
    	$isLogged = false;
    	if(!empty($userData)) {
    		$isLogged = true;
    	}

    	$partnerLogos = User::select('packages.logo_size', 'users.id', 'users.full_name', 'users.site_url')
    						->join('packages', 'packages.id', '=', 'users.package_id')
    						->where('users.privilege', 2)
    						->get();

    	$logos = array();
    	foreach($partnerLogos as $logo) {
    		$logos[] = array(
    			'img'	=>	$logo->id,
    			'size'	=>	$logo->logo_size,
    			'name'	=>	$logo->full_name,
    			'url'	=>	$logo->site_url
    		);
    	}

    	// Events.
    	$events = Event::all();
    	$eventsArr = array();
    	foreach ($events as $event) {
    		$eventsArr[] = array(
    			'id'	=>	$event->id,
    			'name'	=>	$event->name,
    			'start'	=>	$event->date_start,
    			'end'	=>	$event->date_end
    		);
    	}

    	$addToView = array(
    		'userData'	=>	$userData,
    		'is_logged'	=>	$isLogged,
    		'logos'		=>	$logos,
    		'events'	=>	$eventsArr
    	);

    	return view('frontend', $addToView);
    }
}
