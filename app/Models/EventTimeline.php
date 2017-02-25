<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventTimeline extends Model
{
    // protected $dates = ['created_at', 'updated_at', 'date_start', 'date_end'];

    public function getFiltered($search = array(), $onlyTotal = false) {
        $obj = $this;

        // Filters here..
        if(isset($search['event_id']) && !empty($search['event_id'])) {
        	$obj = $obj->where('event_id', $search['event_id']);
        }
        // END filters..

        if($onlyTotal) {
            return $obj->count();
        }

        // Ordering..
        $sOrder = (isset($search['sord']) && ($search['sord'] == 'asc' || $search['sord'] == 'desc')) ? $search['sord'] : 'asc';
        if(isset($search['sidx'])) {
            switch ($search['sidx']) {
                case 'name':
                case 'date_start':
                case 'date_end':
                    $obj = $obj->orderBy($search['sidx'], $search['sord']);
                    break;

                default:
                    $obj = $obj->orderBy('date_start', $search['sord']);
                    break;
            }
        }

        if(!isset($search['noLimit']) || !$search['noLimit']) {
            $limit  = !isset($search['limit']) || empty($search['limit']) ? 10 : $search['limit'];
            $page   = !isset($search['page']) || empty($search['page']) ? 1 : $search['page'];
            $from   = ($page - 1)*$limit;
            $obj = $obj->take($limit)->skip($from);
        }

        return $obj->get();
    }
}
