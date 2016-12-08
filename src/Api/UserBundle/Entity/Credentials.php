<?php
/**
 * Created by PhpStorm.
 * User: quentinrillet
 * Date: 02/12/2016
 * Time: 19:38
 */

namespace Api\UserBundle\Entity;

class Credentials
{
    protected $login;

    protected $password;

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}
