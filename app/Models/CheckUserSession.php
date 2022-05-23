<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class CheckUserSession extends Model
{
    public static function check($session = [])
    {
        try {
            if (!isset($session['before_session_userid'])) {
                $last_activity = $session['last_activity'] ? $session['last_activity'] : false;
                if ((!isset($session['uid'])  || !isset($session['uname'])) && $last_activity + 120 * 60 < time()) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        } catch (\Exception $e) {
        }
    }
}
