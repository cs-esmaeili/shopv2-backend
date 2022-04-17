<?php

namespace App\Http\classes;

use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Support\Str;

class G
{

    public static $cour_price = 5000;
    public static $max_price = 75000;
    public static $main_admin = 1;

    public static function changeWords($str)
    {
        $str = strtolower($str);
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $englishNumbersOnly = str_replace($persian, $num, $str);
        return $englishNumbersOnly;
    }
    public static function timeNow($hours = 0)
    {
        return  Carbon::now()->addMinutes($hours)->format('Y-m-d H:i:s');
    }

    public static function newToken($unicData, $token_id = -1, $time = 0)
    {
        $token = G::getHash($unicData . rand(0, 1000) . Carbon::now() .  Str::uuid());
        $result = Token::updateOrCreate(['token_id' => $token_id], [
            'token' => $token,
            'expiration' => self::timeNow($time),
        ]);
        if ($result) {
            return ['token' => $token, 'token_id' => $result->token_id];
        } else {
            return false;
        }
    }

    public static function checkToken($token, $admin = false, $action = null)
    {
        $token =  Token::where('token', '=', $token)->get();
        if ($token->count() == 1) {
            $token = $token[0];
            if (Carbon::createFromFormat('Y-m-d H:i:s', $token->expiration)->lessThan(self::timeNow())) {
                return ['status' => false, 'meessage' => "token expired"];
            } else {
                if ($admin) {
                    if ($token->person != null) {
                        $permissions = $token->person->role->permissions->toArray();
                        foreach ($permissions as  $key => $value) {
                            if ($value['name'] == $action) {
                                return ['status' => true, 'token' => $token];
                            }
                        }
                        return ['status' => false, 'meessage' => "permission denid"];
                    } else {
                        return ['status' => false, 'meessage' => "Person not found"];
                    }
                } else {
                    //user
                    return ['status' => true, 'token' => $token];
                }
            }
        } else {
            return ['status' => false, 'meessage' => "token is wrong"];
        }
    }
    public static function getPersonFromToken($token)
    {
        $token = Token::where('token', '=', $token)->get()[0];
        $person = $token->person;
        return $person;
    }

    public static function getHash($str)
    {
        $saltstr = env('APP_URL') . '###JavadEsmaeili###'; //APP_URL = https://www.cheemarket.com
        $encrypt = sha1(sha1($str . $saltstr) . md5($saltstr . $str) . sha1($saltstr . $str . $str . $saltstr));
        return $encrypt;
    }

    public static function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public static function strposX($haystack, $needle, $number)
    {
        if ($number == '1') {
            return strpos($haystack, $needle);
        } elseif ($number > '1') {
            return strpos($haystack, $needle, self::strposX($haystack, $needle, $number - 1) + strlen($needle));
        } else {
            return error_log('Error: Value for parameter $number is out of range');
        }
    }

    public static function customtime($time)
    {
        $date = date_create($time);
        $time =  date_format($date, "Y/m/d");
        $arr_parts = explode('/', $time);
        $gYear  = $arr_parts[0];
        $gMonth = $arr_parts[1];
        $gDay   = $arr_parts[2];
        $current_jdate = jdf::gregorian_to_jalali($gYear, $gMonth, $gDay, '/');
        $month = substr($current_jdate, strpos($current_jdate, '/') + 1, G::strposX($current_jdate, '/', 2) - (strpos($current_jdate, '/') + 1));
        $temp = new jdf();
        $month = $temp->jdate_words(['mm' => $month]);

        return $current_jdate;
    }

    public static function getArrayItems($array, $params, $newItems = null)
    {
        $outPut = [];
        foreach ($array as  $key => $value) {
            foreach ($params as  $pkey => $pvalue) {
                if ($key === $pkey || $key === $pvalue) {
                    $outPut[$key] = $value;
                }
            }
        }
        if ($newItems != null) {
            foreach ($newItems as  $key => $value) {
                $outPut[$key] = $value;
            }
        }
        return $outPut;
    }
    public  static function converToShamsi($created_at)
    {
        $date = date_create($created_at);
        $time =  date_format($date, "Y/m/d");
        $arr_parts = explode('/', $time);
        $gYear  = $arr_parts[0];
        $gMonth = $arr_parts[1];
        $gDay   = $arr_parts[2];
        $current_jdate = jdf::gregorian_to_jalali($gYear, $gMonth, $gDay, '/');


        return $current_jdate;
    }
}
