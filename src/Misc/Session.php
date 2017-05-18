<?php
/*
 * Trivial abstraction layer for PHP sessions
 */
namespace Neochic\SlimTools\Misc;

class Session
{
    protected function __isStarted() {
        return session_id() !== '';
    }

    public function start($expiration = 0) {
        if (!$this->__isStarted()) {
            session_set_cookie_params($expiration);
            ini_set("session.use_trans_sid", 0);
            ini_set("session.use_only_cookies", 1);
            session_start();
        }
    }

    public function end() {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', -1, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));
        if ($this->__isStarted()) {
            session_destroy();
        }
    }

    public function get($key)
    {
        if($this->__isStarted() || isset($_COOKIE[session_name()])) {
            $this->start();
            if (isset($_SESSION[$key])) {
                return $_SESSION[$key];
            }
        }
        return false;
    }

    public function set($key, $val)
    {
        $this->start();
        $_SESSION[$key] = $val;
        return true;
    }

    public function delete($key)
    {
	    if($this->__isStarted() || isset($_COOKIE[session_name()])) {
		    $this->start();
		    if (isset($_SESSION[$key])) {
			    unset($_SESSION[$key]);
		    }
		    return true;
	    }

	    return false;
    }
}
