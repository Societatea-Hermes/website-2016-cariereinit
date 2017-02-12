<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    public function getFiltered($search = array(), $onlyTotal = false) {
        $obj = $this->select('offers.*', 'users.full_name')
        			->join('users', 'users.id', '=', 'offers.partner_id');

        // Filters here..
        if(isset($search['partner_id']) && !empty($search['partner_id'])) {
            $obj = $obj->where('partner_id', $search['partner_id']);
        }
        // END filters..

        if($onlyTotal) {
            return $obj->count();
        }

        // Ordering..
        $sOrder = (isset($search['sord']) && ($search['sord'] == 'asc' || $search['sord'] == 'desc')) ? $search['sord'] : 'asc';
        if(isset($search['sidx'])) {
            switch ($search['sidx']) {
                case 'title':
                case 'partner_id':
                    $obj = $obj->orderBy($search['sidx'], $search['sord']);
                    break;

                default:
                    $obj = $obj->orderBy('title', $search['sord']);
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
