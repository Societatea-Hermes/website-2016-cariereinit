<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function getFiltered($search = array(), $onlyTotal = false) {
        $obj = $this;

        // Filters here..

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
                case 'max_participants':
                    $obj = $obj->orderBy($search['sidx'], $search['sord']);
                    break;

                default:
                    $obj = $obj->orderBy('name', $search['sord']);
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
