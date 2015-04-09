<?php
/*
 * Trivial abstraction layer for PHP session
 */
namespace Neochic\SlimTools\Misc;

class Session
{
    public function __construct()
    {
        if (session_id() === '') {
            ini_set("session.use_trans_sid", 0);
            ini_set("session.use_only_cookies", 1);
            session_start();
        }
    }
    public function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return false;
    }

    public function set($key, $val)
    {
        $_SESSION[$key] = $val;
        return true;
    }

    public function delete($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
        return true;
    }
}