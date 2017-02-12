<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function getPrivilegeTextAttribute($value) {
        $valueX = $this->privilege;
        switch ($valueX) {
            case '1':
                return "User";
            case '2':  
                return "Partner";
            case '3':  
                return "Admin";
        }
    }

    public function getFiltered($search = array(), $onlyTotal = false) {
        $obj = $this;

        // Filters here..
        if(isset($search['privilege']) && !empty($search['privilege'])) {
            $obj = $obj->where('privilege', $search['privilege']);
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
                case 'username':
                case 'privilege':
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
