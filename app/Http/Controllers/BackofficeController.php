<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

class BackofficeController extends Controller
{
    public function login() {
    	return view('backoffice/login');
    }

    public function home() {
    	$userData = Session::get('userData');

        if(empty($userData) || $userData['privilege'] == 1) {
            return redirect()->route('login');
        }

    	switch ($userData['privilege']) {
    		case '2':
    			return view('backoffice/partner');
    		case '3':
    			return view('backoffice/admin');
    	}
    }

    public function events() {
        return view('backoffice/events');
    }

    public function packages() {
        return view('backoffice/packages');
    }

    public function users() {
        return view('backoffice/users');
    }

    public function profile() {
        $userData = Session::get('userData');

        if(empty($userData) || $userData['privilege'] == 1) {
            return redirect()->route('login');
        }

        return view('backoffice/profile', $userData);
    }

    public function offers() {
        return view('backoffice/offers');
    }

    public function logout() {
        Session::flush();
        return redirect("/");
    }
}
