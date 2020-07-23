<?php

namespace services;

use model\User;
use model\UserDAO;

class UserService extends AbstractService
{

    protected function setDao()
    {
        $this->dao = new UserDAO();
    }

    public function login(array $postParams)
    {
        $params = [
            'email' => $postParams['email']
        ];
        $user = $this->dao->findBy($params, true);
        if (!$user) {
            $msg = "Invalid password or email! Try again.";

            include_once "view/login.php";

        }
        if (password_verify($postParams['password'], $user['password'])) {
            unset($user["password"]);
            $_SESSION['logged_user'] = $user;
            header('Location:/Bookstore/view/main');
            echo "Successful login! <br>";
        }
        else {
            $msg = "Invalid password or email! Try again.";

            include_once "view/login.php";
        }
    }
    public function register(array $postParams)
    {
        $firstName = $postParams['firstName'];
        $lastName = $postParams['lastName'];
        $email = $postParams['email'];
        $password = $postParams['password'];
        $cpassword = $postParams['cpassword'];
        $role = $postParams['role'];
        $active = true;

        $userDao = new UserDAO();
        $params = [
            'email' => $email
        ];
        $user = $userDao->findBy($params, true);
        if ($user) {
            $msg = "User with that email already exists!";

            include_once "view/login.php";

            return;
        }
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $user = new User($firstName,$lastName, $email, $hashedPassword, $active, $role);
        $userDao->registerUser($user);
        $arrayUser = [];
        $arrayUser['id'] = $user->getId();
        $arrayUser['firstName'] = $user->getFirstName();
        $arrayUser['lastName'] = $user->getLastName();
        $arrayUser['email'] = $user->getEmail();
        $arrayUser["active"] = $user->getActive();
        $arrayUser["role"] = $user->getRole();
        $_SESSION['logged_user'] = $arrayUser;

        header('Location:/Bookstore/view/main');

        echo "Successful registration! You are now logged in.<br>";
    }
}