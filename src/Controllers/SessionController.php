<?php

namespace App\Controller;

use \Datetime;

class SessionController
{

    private $session;
    private $user;

    public function __construct()
    {
        $this->session = filter_var_array($_SESSION);
        if (isset($this->session['user'])) {
            $this->user = $this->session['user'];
        }
    }

    public function createSession(int $idy, string $username, string $email, string $status)
    {
        $_SESSION['user'] = [
            'id' => $idy,
            'username' => $username,
            'email' => $email,
            'status' => $status,
        ];
        // in init session generate token
        $this->generateToken();
    }

    public function destroySession()
    {
        $_SESSION['user'] = [];
        session_destroy();
    }

    public function isLogged()
    {
        echo 'isLogged';
        if (array_key_exists('user', $this->session)) {
            if (!empty($this->user)) {
                // check if token exist, if not generate it
                if(!$this->checkTokenValid()) {
                    // $this->generateToken();
                    return false;
                }
                return true;
            }
        }
        return false;
    }

    public function checkStatus(string $info)
    {
        if ($info === 'admin') {

            return true;
        }
        return false;
    }

    public function getUserVar($var)
    {
        if ($this->isLogged() === false) {

            return null;
        }
        return $this->user[$var];
    }

    public function checkAdmin()
    {
        if ($this->isLogged()) {
            if ($this->getUserVar('status') === '1') {

                return true;
            }
            $this->destroySession();
        }
        return false;
    }

    protected function checkTokenExpired() {
        if(isset($_SESSION['token']) && isset($_SESSION['tk_ct'])){
            $currentTime = new DateTime();
            $interval = $currentTime->diff($_SESSION['tk_ct']);
            if(($currentTime->getTimestamp() - $_SESSION['tk_ct']->getTimestamp()) > (60 * 10) ) {
                return true;
            }
            return false;
        } else {
            return true;
        }
    }

    protected function checkTokenValid() {
        if(isset($_SESSION['token']) && isset($_GET['token']) && $_SESSION['token'] == $_GET['token']) {
            return true;
        }
        return false;
    }

    protected function generateToken() {
        $token = bin2hex(random_bytes(32));
        $currentTime = new DateTime();
        $_SESSION['token'] = $token;
        $_SESSION['tk_ct'] = $currentTime;
    }
}
