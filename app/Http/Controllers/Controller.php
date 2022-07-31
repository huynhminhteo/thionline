<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use \Firebase\JWT\JWT;
use Config;
use App\Model;
use Auth;
use \Spatie\Activitylog\Models\Activity;
use Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function instance($class)
    {
        try {
            $instantiator = new \Doctrine\Instantiator\Instantiator();
            $instance = $instantiator->instantiate($class);
            return $instance;
        } catch (\Exception $e) {
            return null;
        }
    }

    static public function getUser()
    {
        try {
            if (\Request::is('api/*') || \Request::is('*/webview/*')) {
                $user = auth('api')->user();
            } else {
                $user = Auth::user();
            }
            return $user;
        } catch(\Exception $e) {
            return;
        }
    }

    static public function getUID()
    {
        try {
            if (\Request::is('api/*') || \Request::is('*/webview/*')) {
                $user = auth('api')->user()->id;
            } else {
                $user = Auth::user()->id;
            }
            return $user;
        } catch(\Exception $e) {
            return null;
        }
    }

    static public function XORCipher($data)
    {
        try {
            $dataLen = strlen($data);
            $key = config('constant.XOR_KEY');
            $keyLen = strlen($key);
            $output = $data;

            for ($i = 0; $i < $dataLen; ++$i) {
                $output[$i] = $data[$i] ^ $key[$i % $keyLen];
            }

            return $output;
        } catch (\Exception $e) {
            return '';
        }
    }

    static public function Pagination($result, $page, $record = 10)
    {
        try {
            if ($record != null && $page != null) {
                $count_all = $result->count();
                $custom = collect(['recordsTotal' => $count_all, 'recordsFiltered' => $count_all]);
                $pagination = $result->paginate($record, ['*'], 'page', $page)->appends(Input::except('page'));
                $data = $custom->merge($pagination);
                return $data;
            } else {
                return $result->get();
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    static public function JsonExport($code, $msg, $data = null, $optinal = null)
    {
        try {
            $callback = [
                'code' => $code,
                'msg' => $msg
            ];
            if ($data != null) {
                $callback['data'] = $data;
            } else if (is_array($data) && count($data) == 0) {
                $callback['data'] = array();
            } else {
                $callback['data'] = (object)[];
            }
            if ($optinal != null && is_array($optinal)) {
                if (count($optinal) > 1) {
                    for ($i = 0; $i < count($optinal); $i++) {
                        $callback[$optinal[$i]['name']] = $optinal[$i]['data'];
                    }
                } else {
                    $callback[$optinal[0]['name']] = $optinal[0]['data'];
                }
            }
            return response()->json($callback, 200, []);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'msg' => 'Internal Server Error'], 200, []);
        }
    }

    static public function JsonExportWithCookie($code, $msg, $data = null, $cookie)
    {
        try {
            $callback = [
                'code' => $code,
                'msg' => $msg
            ];
            if ($data != null) {
                $callback['data'] = $data;
            } else if (is_array($data) && count($data) == 0) {
                $callback['data'] = array();
            } else {
                $callback['data'] = (object)[];
            }

            return response()->json($callback, 200, [])->cookie($cookie);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'msg' => 'Internal Server Error'], 500, []);
        }
    }

    static public function JsonExportAPI($code, $msg, $data = null, $optinal = null)
    {
        try {
            $callback = [
                'msg' => $msg
            ];
            if ($data != null) {
                $callback['data'] = $data;
            } else if (is_array($data) && count($data) == 0) {
                $callback['data'] = array();
            } else {
                $callback['data'] = (object)[];
            }
            if ($optinal != null && is_array($optinal)) {
                if (count($optinal) > 1) {
                    for ($i = 0; $i < count($optinal); $i++) {
                        $callback[$optinal[$i]['name']] = $optinal[$i]['data'];
                    }
                } else {
                    $callback[$optinal[0]['name']] = $optinal[0]['data'];
                }
            }
            return response()->json($callback, $code, []);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'msg' => 'Internal Server Error'], 500, []);
        }
    }

    static public function EncodeJWT($user)
    {
        $time = time();
        $token = new \StdClass();
        $token->iat = $time;
        $token->uuid = self::uuid() . $time;
        $token->user = json_decode($user);
        return JWT::encode(json_decode(json_encode($token), true), Config::get('env.key_jwt'));
    }

    static public function DecodeJWT($request)
    {
        JWT::$leeway = 60;
        $decoded = JWT::decode($request->header('token'), Config::get('env.key_jwt'), array('HS256'));
        return $decoded;
    }

    function CallAPI($method, $url, $data = false)
    {
        $curl = curl_init();

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
      
        curl_close($curl);
        
        return $result;
    }

    public function generatePassword($length = 8) {
        $array_letter = [];
        $uppercases = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $lowercases = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $sign = '!@#$%^&*()_-+=./?';
        array_push($array_letter, $uppercases, $lowercases,$numbers);
     
        $randomString = '';
        for ($i = 0; $i < $length - 1; $i++) {
            $string = $array_letter[rand(0, count($array_letter) - 1)];
            $charactersLength = strlen($string);
            $randomString .= $string[rand(0, $charactersLength - 1)];
        }
        $charactersLength = strlen($sign);
        $randomString .= $sign[rand(0, $charactersLength - 1)];
        return $randomString;
    }

    static public function getInfoUserCookie()
    {
        $token = Cookie::get('_token_mainte');
        $tokenParts = explode("|", $token);
        $tokenUser = Crypt::decryptString($tokenParts[1]);
        $user = json_decode($tokenUser,true);
        $user_return = Model\MUser::withTrashed()->find($user['id']);
        return $user_return;
    }

    static public function __writeLog500($ip, $method, $path, $msg) {
        try {
            Log::error($ip.' - "'.$method.' /'.$path.'" - 500 - '.$msg);
        } catch (\Exception $e) {
            return null;
        }
    }

    static public function __writeLogExternal($request, $code, $msg) {
        try {
            if ($code == 200) {
                Log::channel('external')->info($request->ip().' - "'.$request->method().' /'.$request->path().'"'."\n". 'Request Parameter:'."\n".$request->getContent()."\n". 'Response Parameter:'."\n".'{"code" : '.$code.', "msg" : "'.$msg.'"}');
            } else {
                Log::channel('external')->error($request->ip().' - "'.$request->method().' /'.$request->path().'"'."\n". 'Request Parameter:'."\n".$request->getContent()."\n". 'Response Parameter:'."\n".'{"code" : '.$code.', "msg" : "'.$msg.'"}');
            }
        } catch (\Exception $e) {
            return null;
        }
    }
}
