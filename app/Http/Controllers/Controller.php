<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use File;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function returnResponseJson($response, $code = 200, $log = true) {
		$toReturn = json_encode($response);

    	// Logging..
		if($log) {
	    	$logFileName = "api_".date('Y-m-d').".log";
	    	$path = storage_path('logs/'.$logFileName);
			$textToLog = "[".date('Y-m-d H:i:s')."][RESPONSE][".$code."] => ".$toReturn."\n";
			File::append($path, $textToLog);
		}	

    	return response($toReturn, $code)->header('Content-Type', 'text/json');
    }
}
