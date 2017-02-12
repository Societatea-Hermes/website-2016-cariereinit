<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\User;

use File;
use Session;

class LoggedInRequest extends FormRequest
{
    public $userData = null;
    public $isApi = false;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->logRequest();
        $this->userData = Session::get('userData');

        if(empty($this->userData)) {
            $xAuthToken = isset($_SERVER['HTTP_X_AUTH_TOKEN']) ? $_SERVER['HTTP_X_AUTH_TOKEN'] : '';
            $user = User::select('users.*')
                        ->join('auths', 'auths.user_id', '=', 'users.id')
                        ->where('auths.token_generated', $xAuthToken)
                        ->first();
            if(!empty($user)) {
                $this->userData = $user->toArray();
                $this->isApi = true;
                return true;
            }
        } else {
            return true;
        }

        $this->logUnauthorized();
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    private function logRequest() {
        $logFileName = "api_".date('Y-m-d').".log";
        $path = storage_path('logs/'.$logFileName);
        $textToLog = "[".date('Y-m-d H:i:s')."][REQUEST] IP: ".$this->ip()." | URL: ".FormRequest::url()." | Request params: ".http_build_query(FormRequest::all(), '', ', ')."\n";
        File::append($path, $textToLog);
    }

    private function logUnauthorized() {
        $logFileName = "api_".date('Y-m-d').".log";
        $path = storage_path('logs/'.$logFileName);
        $textToLog = "[".date('Y-m-d H:i:s')."][RESPONSE][403] IP: ".$this->ip()." | URL: ".FormRequest::url()." | Request params: ".http_build_query(FormRequest::all(), '', ', ')." => Forbidden \n";
        File::append($path, $textToLog);
    }
}
