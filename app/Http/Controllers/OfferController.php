<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\AddEditOfferRequest;
use App\Http\Requests\LoggedInRequest;
use App\Http\Requests\PartnerRequest;
use App\Http\Requests\UserRequest;

use App\Models\Offer;
use App\Models\OfferApplication;
use App\Models\User;

use File;
use Input;
use Response;

class OfferController extends Controller
{
    public function addEditOffer(AddEditOfferRequest $req, Offer $offer) {
    	$id = Input::get('id');
    	$userData = $req->userData;

    	if(!empty($id)) {
    		$offer = $offer->where('id', $id)->where('partner_id', $userData['id'])->firstOrFail();
    	}

    	$offer->title = Input::get('title');
    	$offer->description = Input::get('description');
    	$offer->partner_id = $userData['id'];

    	$offer->save();

    	$toReturn = array(
			'success'	=>	1
		);

		return $this->returnResponseJson($toReturn);
    }

    public function getOffers(LoggedInRequest $req, Offer $offer, User $user) {
        $userData = $req->userData;
        $search = array(
    		'partner_id'	=>	Input::get('partner_id'),
            'sidx'          =>  Input::get('sidx'),
            'sord'          =>  Input::get('sord'),
            'limit'         =>  empty(Input::get('rows')) ? 10 : Input::get('rows'),
            'page'          =>  empty(Input::get('page')) ? 1 : Input::get('page')
        );

        $isGrid = Input::get('is_grid', false); // Checking if the caller is jqGrid..
        
        if($userData['privilege'] == 2) { // Can only see his own offers
            $search['partner_id'] = $userData['id'];
        }

        $offers = $offer->getFiltered($search);

        $offersCount = $offer->getFiltered($search, true);
        if($offersCount == 0) {
            $numPages = 0;
        } else {
            if($offersCount % $search['limit'] > 0) {
                $numPages = ($offersCount - ($offersCount % $search['limit'])) / $search['limit'] + 1;
            } else {
                $numPages = $offersCount / $search['limit'];
            }
        }

        // Getting partner data..
        $user = $user->findOrFail($search['partner_id']);

        $toReturn = array(
            'rows'      =>  array(),
            'partner'   =>  $user->full_name,
            'records'   =>  $offersCount,
            'page'      =>  $search['page'],
            'total'     =>  $numPages
        );

        foreach($offers as $offerX) {
            $actions = $offerX->id;

            if($isGrid != false) {
                $actions = "<button class='btn btn-default btn-xs' title='Edit' onclick='edit(".$offerX->id.")'><i class='fa fa-pencil'></i></button>";
            }

            $toReturn['rows'][] = array(
                'id'    =>  $offerX->id,
                'cell'  =>  array(
                    $actions,
                    $offerX->title,
                    $offerX->description,
                    $offerX->full_name
                )
            );
        }

        return $this->returnResponseJson($toReturn);
    }

    public function getOfferById(PartnerRequest $req, Offer $offer) {
        $userData = $req->userData;
        
        $id = Input::get('id');
        $offer = $offer->where('id', $id)->where('partner_id', $userData['id'])->firstOrFail();
        return $this->returnResponseJson($offer);
    }

    public function applyForOffer(UserRequest $req, Offer $offer) {
    	$userData = $req->userData;

    	$offer_id = Input::get('id');

    	$offer = $offer->findOrFail($offer_id);

    	$allowedExt = array(
            'docx', 'doc', 'pdf'
        );

        $copyDirectory = storage_path()."/applications/";
        if(!file_exists($copyDirectory)) {
            mkdir($copyDirectory, 0777, true);
        }

        $file = $req->file('application');

        $filename = $file->getClientOriginalName();
        $extension = explode('.', $filename);
        $extension = strtolower($extension[count($extension)-1]);
        if(!in_array($extension, $allowedExt)) {
            // continue; // Not allowed extension detected..
            $toReturn['success'] = 0;
            $toReturn['message'] = "File extension not allowed!";
            return $this->returnResponseJson($toReturn);
        }

        $filename = $offer->id."_".$userData['id']."_".$filename;

        $hasAlreadyApplied = OfferApplication::where('user_id', $userData['id'])->where('offer_id', $offer->id)->first();
        if($hasAlreadyApplied == null) {
        	$hasAlreadyApplied = new OfferApplication();
        	$hasAlreadyApplied->user_id = $userData['id'];
        	$hasAlreadyApplied->offer_id = $offer->id;
        }

        $file->move($copyDirectory, $filename);
        $hasAlreadyApplied->file_path = $filename;
        $hasAlreadyApplied->save();

        $toReturn['success'] = 1;
        return $this->returnResponseJson($toReturn);
    }

    public function getOfferApplications(PartnerRequest $req, Offer $offer, OfferApplication $offApp) {
    	$userData = $req->userData;

    	$offer_id = Input::get('id');
    	$offer = $offer->where('id', $offer_id)->where('partner_id', $userData['id'])->firstOrFail();

    	$search = array(
    		'offer_id'		=>	$offer_id,
            'sidx'          =>  Input::get('sidx'),
            'sord'          =>  Input::get('sord'),
            'limit'         =>  empty(Input::get('rows')) ? 10 : Input::get('rows'),
            'page'          =>  empty(Input::get('page')) ? 1 : Input::get('page')
        );

        $offerApplications = $offApp->getFiltered($search);

        $offerApplicationsCount = $offApp->getFiltered($search, true);
        if($offerApplicationsCount == 0) {
            $numPages = 0;
        } else {
            if($offerApplicationsCount % $search['limit'] > 0) {
                $numPages = ($offerApplicationsCount - ($offerApplicationsCount % $search['limit'])) / $search['limit'] + 1;
            } else {
                $numPages = $offerApplicationsCount / $search['limit'];
            }
        }

        $toReturn = array(
            'rows'      =>  array(),
            'records'   =>  $offerApplicationsCount,
            'page'      =>  $search['page'],
            'total'     =>  $numPages
        );

        $isGrid = Input::get('is_grid', false); // Checking if the caller is jqGrid -> if yes, we add actions to the response..

        foreach($offerApplications as $offerX) {
            $actions = $offerX->id;

            if($isGrid != false) {
                $actions = "<button class='btn btn-default btn-xs' title='Download application' onclick='download(".$offerX->id.")'><i class='fa fa-download'></i></button>";
            }

            $toReturn['rows'][] = array(
                'id'    =>  $offerX->id,
                'cell'  =>  array(
                    $actions,
                    $offerX->full_name,
                    $offerX->email,
                )
            );
        }

        return $this->returnResponseJson($toReturn);
    }

    public function downloadApplication(PartnerRequest $req, Offer $offer, OfferApplication $offApp, $id_application) {
    	$userData = $req->userData;

    	$application = $offApp->findOrFail($id_application);
    	
    	$offer = $offer->where('id', $application->offer_id)->where('partner_id', $userData['id'])->firstOrFail();

        $path = storage_path()."/applications/".$application->file_path;

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }
}
