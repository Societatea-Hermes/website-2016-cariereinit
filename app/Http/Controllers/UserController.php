<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\ModelNotFoundException;

/* Requests */
use App\Http\Requests\AddPartnerAccountRequest;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoggedInRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PartnerRequest;

/* Models */
use App\Models\Auth;
use App\Models\Package;
use App\Models\User;

/* Libraries */
use File;
use Hash;
use Image;
use Input;
use Response;
use Session;
use Socialite;
use Uuid;

class UserController extends Controller
{
    public function login(Auth $auth, User $user, LoginRequest $req) {
    	$username = Input::get('username');
    	$password = Input::get('password');

    	$auth->ip = $req->ip();
    	$auth->user_agent = $req->header('User-Agent');

    	$rawRequestParams = http_build_query($req->all());
    	$rawRequestParams = preg_replace('/password=.*/', "password=CENSORED", $rawRequestParams);

    	$auth->raw_request_params = $rawRequestParams;

    	$toReturn = array(
			'success'	=>	0,
			'message'	=>	'Username / password invalid!'
		);

    	// Checking user..
    	try {
	    	$userExists = $user->where('username', $username)->whereNotNull('password')->firstOrFail();
    	} catch(ModelNotFoundException $ex) {
    		$auth->save();
    		return $this->returnResponseJson($toReturn);
    	}

    	// We found a user..
    	$auth->user_id = $userExists->id;

    	// Invalid password
    	if(!Hash::check($password, $userExists->password)) {
    		$auth->save();
    		return $this->returnResponseJson($toReturn);
    	}

    	// all good..
    	$loginKey = Uuid::generate(1);
    	$loginKey = $loginKey->string;

    	$auth->token_generated = $loginKey;
    	$auth->save();

    	$userData = $userExists->toArray();
    	$userData['token'] = $loginKey;
    	Session::put('userData', $userData);

        // $userDataX = Session::get('userData');

    	$toReturn = array(
			'success'	=>	1,
			'message'	=>	$loginKey
		);

		return $this->returnResponseJson($toReturn);
    }

    public function addPartnerAccount(AddPartnerAccountRequest $req, User $user, Package $pkg) {
        $toReturn = array();

        $user->username = Input::get('username');
        $password = Input::get('password');

        $user->password = Hash::make($password);
        $user->full_name = Input::get('full_name');
        $user->privilege = 2;
        $user->email = Input::get('email');
        $user->site_url = Input::get('site_url');

        $user->package_id = Input::get('package_id');

        // Saving img..
        $allowedExt = array(
            'png', 'jpg', 'jpeg'
        );

        $copyDirectory = storage_path()."/partners/";
        if(!file_exists($copyDirectory)) {
            mkdir($copyDirectory, 0777, true);
        }

        $file = $req->file('avatar');

        $filename = $file->getClientOriginalName();
        $extension = explode('.', $filename);
        $extension = strtolower($extension[count($extension)-1]);
        if(!in_array($extension, $allowedExt)) {
            // continue; // Not allowed extension detected..
            $toReturn['success'] = 0;
            $toReturn['message'] = "File extension not allowed!";
            return $this->returnResponseJson($toReturn);
        }
        $user->save();

        $filename = $user->id."_".$filename;
        $file->move($copyDirectory, $filename);
        $user->avatar = $filename;
        $user->save();

        $toReturn['success'] = 1;
        return $this->returnResponseJson($toReturn);
    }

    public function getAvatar(User $user, $id) {
        $userAvatar = $user->where('id', $id)->where("privilege", 2)->firstOrFail();
        $path = storage_path()."/partners/".$userAvatar->avatar;

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    public function changeAvatar(PartnerRequest $req, User $user) {
        $userData = $req->userData;

        $user = $user->find($userData['id']);

        $allowedExt = array(
            'png', 'jpg', 'jpeg'
        );
        $copyDirectory = storage_path()."/partners/";

        $file = $req->file('avatar');
        $filename = $file->getClientOriginalName();
        $extension = explode('.', $filename);
        $extension = strtolower($extension[count($extension)-1]);
        if(!in_array($extension, $allowedExt)) {
            // continue; // Not allowed extension detected..
            $toReturn['success'] = 0;
            $toReturn['message'] = "File extension not allowed!";
            return $this->returnResponseJson($toReturn);
        }

        // deleting old logo..
        @unlink(storage_path()."/partners/".$user->avatar);

        $filename = $user->id."_".$filename;
        $file->move($copyDirectory, $filename);
        $user->avatar = $filename;
        $user->save();

        $toReturn['success'] = 1;
        return $this->returnResponseJson($toReturn);
    }

    public function changePassword(ChangePasswordRequest $req, User $user) {
        $password = Input::get('password');

        $userData = $req->userData;

        $user = $user->find($userData['id']);
        $user->password = Hash::make($password);
        $user->save();

        $toReturn['success'] = 1;
        return $this->returnResponseJson($toReturn);
    }

    public function resetPartnerPassword(AdminRequest $req, User $user) {
        $partner_id = Input::get('partner_id');

        $user = $user->findOrFail($partner_id);
        
        $password = Input::get('password');
        
        $user->password = Hash::make($password);
        $user->save();

        $toReturn['success'] = 1;
        return $this->returnResponseJson($toReturn);
    }

    public function getUsers(AdminRequest $req, User $user) {
        $search = array(
            'privilege'     =>  Input::get('privilege'),
            'sidx'          =>  Input::get('sidx'),
            'sord'          =>  Input::get('sord'),
            'limit'         =>  empty(Input::get('rows')) ? 10 : Input::get('rows'),
            'page'          =>  empty(Input::get('page')) ? 1 : Input::get('page')
        );

        $users = $user->getFiltered($search);

        $usersCount = $user->getFiltered($search, true);
        if($usersCount == 0) {
            $numPages = 0;
        } else {
            if($usersCount % $search['limit'] > 0) {
                $numPages = ($usersCount - ($usersCount % $search['limit'])) / $search['limit'] + 1;
            } else {
                $numPages = $usersCount / $search['limit'];
            }
        }

        $toReturn = array(
            'rows'      =>  array(),
            'records'   =>  $usersCount,
            'page'      =>  $search['page'],
            'total'     =>  $numPages
        );

        $isGrid = Input::get('is_grid', false); // Checking if the caller is jqGrid -> if yes, we add actions to the response..

        foreach($users as $userX) {
            $actions = $userX->id;

            if($isGrid != false) {
                $actions = "";
                if($userX->privilege != 1) {

                    $actions .= "<button class='btn btn-default btn-xs' title='Reset password' onclick='resetPassword(".$userX->id.")'><i class='fa fa-pencil'></i></button>";
                }
            }

            $toReturn['rows'][] = array(
                'id'    =>  $userX->id,
                'cell'  =>  array(
                    $actions,
                    $userX->full_name,
                    $userX->username,
                    $userX->privilege_text,
                    $userX->email,
                    $userX->site_url
                )
            );
        }

        return $this->returnResponseJson($toReturn);
    }

    public function facebookLogin() {
        return Socialite::driver('facebook')->redirect();
    }

    public function oAuthRedirect(User $user, Auth $auth, Request $req) {
        $fbUser = Socialite::driver('facebook')->user();

        $user = $user->where('username', $fbUser->id)->first();
        if($user == null) {
            $user = new User();
            $user->username = $fbUser->id;
            $user->email = $fbUser->email;
            $user->full_name = $fbUser->name;
            $user->privilege = 1;
            $user->save();
        }

        $auth->ip = $req->ip();
        $auth->user_agent = $req->header('User-Agent');
        $rawRequestParams = http_build_query($req->all());
        $auth->raw_request_params = $rawRequestParams;

        $auth->user_id = $user->id;

        $loginKey = Uuid::generate(1);
        $loginKey = $loginKey->string;

        $auth->o_auth_token = $fbUser->token;
        $auth->o_auth_refresh_token = $fbUser->refreshToken;

        $auth->token_generated = $loginKey;
        $auth->save();

        $userData = $user->toArray();
        $userData['token'] = $loginKey;
        Session::put('userData', $userData);

        $hasRedirect = Session::get('redirectToOverlay');
        if($hasRedirect) {
            Session::forget('redirectToOverlay');
            return redirect()->action('UserController@getOverlay');
        }

        return redirect('/');
    }

    public function getOverlay(User $user, Auth $auth) {
        $userData = Session::get('userData');
        if(empty($userData)) {
            Session::put('redirectToOverlay', true);
            // redirecting to oAuth..
            return redirect()->action('UserController@facebookLogin');
        }

        $auth = $auth->where('token_generated', $userData['token'])->first();
        $fbUser = Socialite::driver('facebook')->userFromToken($auth->o_auth_token);

        $imgName = Uuid::generate('4');

        $fbAvatar = $fbUser->avatar_original;
        $fbAvatar = explode('?', $fbAvatar);
        $fbAvatar = $fbAvatar[0]."?width=500&height=500";

        $img = Image::make($fbAvatar)->resize(500, null, function($constraint) {
                $constraint->aspectRatio();
            })->insert('images/overlay.png', 'bottom-left')->save('images/overlays/'.$imgName.".jpg");

        $addToView['imgSrc'] = $imgName;
        
        return view('facebookOverlay', $addToView);

    }
}
