<?php
namespace Neochic\SlimTools\Misc;

class Session
{
    public static function get($key)
    {
        SESSION::initSession();
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return false;
    }

    public static function set($key, $val)
    {
        SESSION::initSession();
        $_SESSION[$key] = $val;
        return true;
    }

    public static function delete($key)
    {
        SESSION::initSession();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
        return true;
    }

    public static function initSession()
    {
        if (session_id() === '') {
            ini_set("session.use_trans_sid", 0);
            ini_set("session.use_only_cookies", 1);
            session_start();
        }
        return true;
    }
}