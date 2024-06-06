<?php

namespace Framework;

class  Session {
    public static function start()
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set($key,$value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * get a session value by key
     * @param $key
     * @param $default
     * @return mixed|null
     */
    public static function get($key,$default = null){
        return $_SESSION[$key] ?? $default;
    }

    /**
     * check is session key exists
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * clear session by key
     * @param string $key
     * @return void
     */
    public static function clear($key)
    {
        if(isset($_SESSION[$key])){
            unset($_SESSION[$key]);
        }
    }

    /**
     * clear all session data
     * @return void
     */
    public static function clearAll()
    {
        session_unset();
        session_destroy();
    }

}