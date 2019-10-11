<?php

namespace App\Controller;

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
    }

    public function destroySession()
    {
        $_SESSION['user'] = [];
        session_destroy();
    }

    public function isLogged()
    {
        if (array_key_exists('user', $this->session)) {
            if (!empty($this->user)) {

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
}
