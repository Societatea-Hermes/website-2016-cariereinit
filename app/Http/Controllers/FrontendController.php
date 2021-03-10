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
    	$userData = Session::get('userData');
    	$isLogged = false;
    	if(!empty($userData)) {
    		$isLogged = true;
    	}

    	$partnerLogos = User::select('packages.logo_size', 'users.id', 'users.full_name', 'users.site_url')
    						->join('packages', 'packages.id', '=', 'users.package_id')
    						->where('users.privilege', 2)
                            ->orderBy("packages.logo_size")
    						->get();

    	$logos = array();
    	foreach($partnerLogos as $logo) {
    		$logos[] = array(
    			'img'	=>	$logo->id,
    			'size'	=>	$logo->logo_size,
    			'name'	=>	$logo->full_name,
    			'url'	=>	$logo->site_url
    		);
    	};

        $ceva = $logos[3];
        $logos[3] = $logos[4];
        $logos[4] = $ceva;

        // Events.
    	$events = Event::all();
    	$eventsArr = array();
    	foreach ($events as $event) {
            $dateStart = Carbon::createFromFormat('Y-m-d H:i:s', $event->date_start);
            $dateEnd = Carbon::createFromFormat('Y-m-d H:i:s', $event->date_end);
    		$eventsArr[] = array(
    			'id'	=>	$event->id,
    			'name'	=>	$event->name,
    			'start'	=>	$dateStart->format('d/m/Y H:i'),
    			'end'	=>	$dateEnd->format('d/m/Y H:i')
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
