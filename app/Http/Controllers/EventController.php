<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\AddEditEventRequest;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\LoggedInRequest;
use App\Http\Requests\UserRequest;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\EventTimeline;

use Carbon\Carbon;
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
                $actions = "<button class='btn btn-default btn-xs' title='Add timeline for event' onclick='addEventTimeline(".$event->id.")'><i class='fa fa-plus'></i></button>";
                $actions .= "<button class='btn btn-default btn-xs' title='Edit' onclick='edit(".$event->id.")'><i class='fa fa-pencil'></i></button>";
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

    public function getEventById(LoggedInRequest $req, Event $ev, EventTimeline $evTimeline) {
    	$id = Input::get('id');
    	$ev = $ev->findOrFail($id);

        $toReturn = array(
            'event'     =>  $ev->toArray(),
            'timeline'  =>  array()
        );

        $evTimeline = $evTimeline->where('event_id', $ev->id)->orderBy('date_start', 'ASC')->get();

        foreach($evTimeline as $timeline) {
            $dateStart = Carbon::createFromFormat('Y-m-d H:i:s', $timeline->date_start);
            $dateEnd = Carbon::createFromFormat('Y-m-d H:i:s', $timeline->date_end);

            $toReturn['timeline'][] = array(
                'name'          =>  $timeline->name,
                'description'   =>  $timeline->description,
                'date_start'    =>  $dateStart->format('d/m/Y H:i'),
                'date_end'      =>  $dateEnd->format('d/m/Y H:i')
            );
        }

    	return $this->returnResponseJson($toReturn);
    }

    public function registerForEvent(UserRequest $req, EventRegistration $evReg, Event $ev) {
    	$id = Input::get('id');
    	$ev = $ev->findOrFail($id);

    	$userData = $req->userData;

    	if(!empty($ev->max_participants)) {
	    	$alreadyRegisteredPeople = $evReg->where('event_id', $ev->id)->count();
	    	if($alreadyRegisteredPeople >= $ev->max_participants) {
	    		$toReturn['success'] = 0;
	    		$toReturn['message'] = "Toate locurile au fost ocupate!";
	    		return $this->returnResponseJson($ev);
	    	}
    	}

    	$evRegX = EventRegistration::firstOrCreate([
    		'user_id'	=>	$userData['id'],
    		'event_id'	=>	$ev->id
    	]);

    	$toReturn['success'] = 1;
		return $this->returnResponseJson($toReturn);
    }

    public function getEventRegistrations(AdminRequest $req, EventRegistration $evReq) {
        $search = array(
            'event_id'      =>  Input::get('event_id'),
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

    public function addEditEventTimeline(AdminRequest $req, EventTimeline $evTimeline, Event $ev) {
        $id_event = Input::get('id_event');
        $ev = $ev->findOrFail($id_event);

        $id = Input::get('timeline_id');

        if(!empty($id)) {
            $evTimeline = $evTimeline->findOrFail($id);
        }

        $evTimeline->name = Input::get('name');
        $evTimeline->description = Input::get('description');
        $evTimeline->event_id = $id_event;
        $evTimeline->date_start = Input::get('date_start');
        $evTimeline->date_end = Input::get('date_end');
        $evTimeline->save();

        $toReturn['success'] = 1;
        return $this->returnResponseJson($toReturn);
    }

    public function getEventTimelineById(AdminRequest $req, EventTimeline $evTimeline) {
        $id = Input::get('id');
        $evTimeline = $evTimeline->findOrFail($id);

        $toReturn['success'] = 1;
        $toReturn['event_timeline'] = $evTimeline;

        return $this->returnResponseJson($toReturn);
    }

    public function deleteEventTimeline(AdminRequest $req, EventTimeline $evTimeline) {
        $id = Input::get('id');
        $evTimeline = $evTimeline->findOrFail($id);
        $evTimeline->delete();

        $toReturn['success'] = 1;

        return $this->returnResponseJson($toReturn);
    }

    public function getEventTimelines(AdminRequest $req, EventTimeline $evTimeline) {
        $search = array(
            'event_id'      =>  Input::get('event_id'),
            'sidx'          =>  Input::get('sidx'),
            'sord'          =>  Input::get('sord'),
            'limit'         =>  empty(Input::get('rows')) ? 10 : Input::get('rows'),
            'page'          =>  empty(Input::get('page')) ? 1 : Input::get('page')
        );

        $timelines = $evTimeline->getFiltered($search);

        $timelinesCount = $evTimeline->getFiltered($search, true);
        if($timelinesCount == 0) {
            $numPages = 0;
        } else {
            if($timelinesCount % $search['limit'] > 0) {
                $numPages = ($timelinesCount - ($timelinesCount % $search['limit'])) / $search['limit'] + 1;
            } else {
                $numPages = $timelinesCount / $search['limit'];
            }
        }

        $toReturn = array(
            'rows'      =>  array(),
            'records'   =>  $timelinesCount,
            'page'      =>  $search['page'],
            'total'     =>  $numPages
        );

        $isGrid = Input::get('is_grid', false); // Checking if the caller is jqGrid -> if yes, we add actions to the response..

        foreach($timelines as $timeline) {
            $actions = $timeline->id;

            if($isGrid != false) {
                $actions = "<button class='btn btn-default btn-xs' title='Edit' onclick='editEventTimeline(".$timeline->id.")'><i class='fa fa-pencil'></i></button>";
                $actions .= "<button class='btn btn-default btn-xs' title='Delete' onclick='deleteEventTimeline(".$timeline->id.")'><i class='fa fa-recycle'></i></button>";
            }

            $toReturn['rows'][] = array(
                'id'    =>  $timeline->id,
                'cell'  =>  array(
                    $actions,
                    $timeline->name,
                    $timeline->date_start,
                    $timeline->date_end
                )
            );
        }

        return $this->returnResponseJson($toReturn);
    }
}
