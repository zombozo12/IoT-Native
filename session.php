<?php

namespace session;

class session
{
    /**
     * Constructor.
     */
    public function __construct(){
        if(!$this->isRegistered()){
            session_start();
        }else{
            $this->renew();
        }
    }

    /**
     *
     * @param integer $time.
     */
    public function register($time = 60)
    {
        $_SESSION['session_id'] = session_id();
        $_SESSION['session_start'] = $this->timeNow();
        $_SESSION['session_time'] = intval($time);
    }

    /**
     *
     * @return  True if it is, False if not.
     */
    public function isRegistered()
    {
        if (! empty($_SESSION['session_id'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     *
     * @var mixed
     * @return mixed
     */
    public function get($key)
    {
        return $_SESSION[$key];
    }

    public function unSession($key){
        unset($_SESSION[$key]);
    }

    /**
     *
     * @return array
     */
    public function getSession()
    {
        return $_SESSION;
    }

    /**
     *
     * @return integer - session id
     */
    public function getSessionId()
    {
        return $_SESSION['session_id'];
    }

    /**
     *
     * @return boolean
     */
    public function isExpired()
    {
        if ($_SESSION['session_start'] < $this->timeNow()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Memperbarui Session yang ada.
     */
    public function renew()
    {
        $_SESSION['session_start'] = $this->newTime();
    }

    /**
     *
     * @return unix timestamp
     */
    private function timeNow()
    {
        $currentHour = date('H');
        $currentMin = date('i');
        $currentSec = date('s');
        $currentMon = date('m');
        $currentDay = date('d');
        $currentYear = date('y');
        return mktime($currentHour, $currentMin, $currentSec, $currentMon, $currentDay, $currentYear);
    }

    /**
     *
     * @return unix timestamp
     */
    private function newTime()
    {
        $currentHour = date('H');
        $currentMin = date('i');
        $currentSec = date('s');
        $currentMon = date('m');
        $currentDay = date('d');
        $currentYear = date('y');
        return mktime($currentHour, ($currentMin + $_SESSION['session_time']), $currentSec, $currentMon, $currentDay, $currentYear);
    }

    /**
     * Menghapus session
     */
    public function end()
    {
        session_destroy();
        $_SESSION = array();
    }
}
