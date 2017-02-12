<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferApplication extends Model
{
    public function getFiltered($search = array(), $onlyTotal = false) {
        $obj = $this->select('offer_applications.id', 'users.full_name', 'users.email')
        			->join('users', 'users.id', '=', 'offer_applications.user_id');

        // Filters here..
        if(isset($search['offer_id']) && !empty($search['offer_id'])) {
            $obj = $obj->where('offer_id', $search['offer_id']);
        }
        // END filters..

        if($onlyTotal) {
            return $obj->count();
        }

        // Ordering..
        $sOrder = (isset($search['sord']) && ($search['sord'] == 'asc' || $search['sord'] == 'desc')) ? $search['sord'] : 'asc';
        if(isset($search['sidx'])) {
            switch ($search['sidx']) {
                case 'full_name':
                case 'email':
                    $obj = $obj->orderBy($search['sidx'], $search['sord']);
                    break;

                default:
                    $obj = $obj->orderBy('full_name', $search['sord']);
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
