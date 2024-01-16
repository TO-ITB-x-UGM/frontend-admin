<?php

namespace App\Libraries;

class Passport
{
    protected array $user;

    function __construct()
    {
        $user = \Config\Services::session()->get('user_logged_in');
        if ($user) {
            $this->user = $user;
        }
    }

    function __get($name)
    {
        if (isset($this->user[$name])) {
            return $this->user[$name];
        } else {
            return null;
        }
    }
}
