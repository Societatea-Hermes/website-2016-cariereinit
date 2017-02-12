<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* Requests */
use App\Http\Requests\AddEditPackage;
use App\Http\Requests\AdminRequest;

/* Models */
use App\Models\Package;

/* Libraries */
use Input;

class PackageController extends Controller
{
    public function addEditPackage(AddEditPackage $req, Package $pkg) {
    	$id = Input::get('id');

    	if(!empty($id)) {
    		$pkg = $pkg->findOrFail($id);
    	}

    	$pkg->package_name = Input::get('package_name');
    	$pkg->logo_size = Input::get('logo_size');
    	$pkg->save();

    	$toReturn = array(
			'success'	=>	1
		);

		return $this->returnResponseJson($toReturn);
    }

    public function getPackages(AdminRequest $req, Package $pkg) {
    	$search = array(
            'sidx'          =>  Input::get('sidx'),
            'sord'          =>  Input::get('sord'),
            'limit'         =>  empty(Input::get('rows')) ? 10 : Input::get('rows'),
            'page'          =>  empty(Input::get('page')) ? 1 : Input::get('page')
        );

        $pkgs = $pkg->getFiltered($search);

        $pkgsCount = $pkg->getFiltered($search, true);
        if($pkgsCount == 0) {
            $numPages = 0;
        } else {
            if($pkgsCount % $search['limit'] > 0) {
                $numPages = ($pkgsCount - ($pkgsCount % $search['limit'])) / $search['limit'] + 1;
            } else {
                $numPages = $pkgsCount / $search['limit'];
            }
        }

        $toReturn = array(
            'rows'      =>  array(),
            'records'   =>  $pkgsCount,
            'page'      =>  $search['page'],
            'total'     =>  $numPages
        );

        $isGrid = Input::get('is_grid', false); // Checking if the caller is jqGrid -> if yes, we add actions to the response..

        foreach($pkgs as $pkgX) {
        	$actions = $pkgX->id;

        	if($isGrid != false) {
        		$actions = "<button class='btn btn-default btn-xs' title='Edit' onclick='edit(".$pkgX->id.")'><i class='fa fa-pencil'></i></button>";
        	}

            $toReturn['rows'][] = array(
                'id'    =>  $pkgX->id,
                'cell'  =>  array(
                	$actions,
                    $pkgX->package_name,
                    $pkgX->logo_size
                )
            );
        }

        return $this->returnResponseJson($toReturn);
    }

    public function getPackageById(AdminRequest $req, Package $pkg) {
    	$id = Input::get('id');
    	$pkg = $pkg->findOrFail($id);
    	return $this->returnResponseJson($pkg);
    }
}
