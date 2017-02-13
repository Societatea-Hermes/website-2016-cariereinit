<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\AddEditEventRequest;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\LoggedInRequest;

use App\Models\Event;
use App\Models\EventRegistration;

use Input;

class EventController extends Controller
{
    public function addEditEvent(AddEditEventRequest $req, Event $ev) {
    	$id = Input::get('id');

    	if(!empty($id)) {
    		$ev = $ev->findOrFail($id);
    	}

    	$ev->name = Input::get('name');
    	$ev->description = Input::get('description');
    	$ev->date_start = Input::get('date_start');
    	$ev->date_end = Input::get('date_end');
    	$ev->max_participants = Input::get('max_participants');

    	$ev->save();

    	$toReturn = array(
			'success'	=>	1
		);

		return $this->returnResponseJson($toReturn);
    }

    public function getEvents(LoggedInRequest $req, Event $ev) {
        $search = array(
            'sidx'          =>  Input::get('sidx'),
            'sord'          =>  Input::get('sord'),
            'limit'         =>  empty(Input::get('rows')) ? 10 : Input::get('rows'),
            'page'          =>  empty(Input::get('page')) ? 1 : Input::get('page')
        );

        $events = $ev->getFiltered($search);

        $eventsCount = $ev->getFiltered($search, true);
        if($eventsCount == 0) {
            $numPages = 0;
        } else {
            if($eventsCount % $search['limit'] > 0) {
                $numPages = ($eventsCount - ($eventsCount % $search['limit'])) / $search['limit'] + 1;
            } else {
                $numPages = $eventsCount / $search['limit'];
            }
        }

        $toReturn = array(
            'rows'      =>  array(),
            'records'   =>  $eventsCount,
            'page'      =>  $search['page'],
            'total'     =>  $numPages
        );

        $isGrid = Input::get('is_grid', false); // Checking if the caller is jqGrid -> if yes, we add actions to the response..

        foreach($events as $event) {
            $actions = $event->id;

            if($isGrid != false) {
                $actions = "<button class='btn btn-default btn-xs' title='Edit' onclick='edit(".$event->id.")'><i class='fa fa-pencil'></i></button>";
            }

            $toReturn['rows'][] = array(
                'id'    =>  $event->id,
                'cell'  =>  array(
                    $actions,
                    $event->name,
                    $event->date_start,
                    $event->date_end,
                    $event->max_participants
                )
            );
        }

        return $this->returnResponseJson($toReturn);
    }

    public function getEventById(LoggedInRequest $req, Event $ev) {
    	$id = Input::get('id');
    	$ev = $ev->findOrFail($id);

    	return $this->returnResponseJson($ev);
    }

    public function registerForEvent(UserRequest $req, EventRegistration $evReg, Event $ev) {
    	$id = Input::get('id');
    	$ev = $ev->findOrFail($id);

    	$userData = $req->userData;

    	if(!empty($ev->max_participants)) {
	    	$alreadyRegisteredPeople = $evReg->where('event_id', $ev->id)->count();
	    	if($alreadyRegisteredPeople >= $ev->max_participants) {
	    		$toReturn['success'] = 0;
	    		$toReturn['message'] = "All places were occupied!";
	    		return $this->returnResponseJson($ev);
	    	}
    	}

    	$evRegX = EventRegistration::firstOrCreate([
    		'user_id'	=>	$userData['id'],
    		'event_id'	=>	$ev->id
    	]);

    	$toReturn['success'] = 1;
		return $this->returnResponseJson($ev);
    }

    public function getEventRegistrations(AdminRequest $req, EventRegistration $evReq) {
        $search = array(
            'event_id'            =>  Input::get('event_id'),
            'sidx'          =>  Input::get('sidx'),
            'sord'          =>  Input::get('sord'),
            'limit'         =>  empty(Input::get('rows')) ? 10 : Input::get('rows'),
            'page'          =>  empty(Input::get('page')) ? 1 : Input::get('page')
        );

        $registrations = $evReq->getFiltered($search);

        $registrationsCount = $evReq->getFiltered($search, true);
        if($registrationsCount == 0) {
            $numPages = 0;
        } else {
            if($registrationsCount % $search['limit'] > 0) {
                $numPages = ($registrationsCount - ($registrationsCount % $search['limit'])) / $search['limit'] + 1;
            } else {
                $numPages = $registrationsCount / $search['limit'];
            }
        }

        $toReturn = array(
            'rows'      =>  array(),
            'records'   =>  $registrationsCount,
            'page'      =>  $search['page'],
            'total'     =>  $numPages
        );

        $isGrid = Input::get('is_grid', false); // Checking if the caller is jqGrid -> if yes, we add actions to the response..

        foreach($registrations as $register) {
            $toReturn['rows'][] = array(
                'id'    =>  $register->id,
                'cell'  =>  array(
                    $register->full_name,
                    $register->email
                )
            );
        }

        return $this->returnResponseJson($toReturn);
    }

    public function deRegisterFromEvent(UserRequest $req, EventRegistration $evReg, Event $ev) {
    	$id = Input::get('id');
    	$ev = $ev->findOrFail($id);

    	$userData = $req->userData;

    	// TODO
    }
}
