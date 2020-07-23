<?php

namespace controller;

use components\router\http\Request;
use exceptions\AuthorizationException;
use exceptions\InvalidArgumentException;
use exceptions\InvalidFileException;
use model\User;
use model\UserDAO;
use services\UserService;

class UserController extends AbstractController
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->userService = new UserService();
    }

    /**
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function login()
    {
        $postParams = $this->request->getPostParams();
        if (isset($postParams['login'])) {
            if (!isset($postParams['email']) || !isset($postParams['password'])) {
                throw new InvalidArgumentException("Invalid arguments.");
            }
            $email = $postParams['email'];
            $password = $postParams['password'];
            if (empty(trim($email)) || empty(trim($password))) {
                $msg = "Empty field(s)!";

                include_once "view/login.php";

                return;
            }
            $this->userService->login($postParams);
        } else {
            throw new InvalidArgumentException("Invalid arguments.");
        }
    }

    /**
     * @return void
     *
     */
    public function register()
    {
        $postParams = $this->request->getPostParams();
        if (isset($postParams['register'])) {
            $error = false;
            $msg = "";
            if (!isset($postParams["firstName"]) || empty(trim($postParams["firstName"]))) {
                $msg = "First name is empty!";
                $error = true;
            } elseif (!isset($postParams["lastName"]) || empty(trim($postParams["lastName"]))) {
                $msg = "Last name is empty!";
                $error = true;
            } elseif (!isset($postParams["email"]) || empty(trim($postParams["email"]))) {
                $msg = "Email is empty!";
                $error = true;
            } elseif (!isset($postParams["password"]) || empty(trim($postParams["password"]))) {
                $msg = "Password is empty!";
                $error = true;
            } elseif (!isset($postParams["cpassword"]) || empty(trim($postParams["cpassword"]))) {
                $msg = "Confirm password is empty!";
                $error = true;
            }
            if ($error) {
                include_once "view/register.php";
                return;
            }
            $msg = $this->registerValidator(
                $postParams['email'],
                $postParams['password'],
                $postParams['cpassword']
            );
            if ($msg != '') {

                include_once "view/register.php";

                return;
            }
            $this->userService->register($postParams);
        }
    }

    /**
     * @return void
     */
    public function logout()
    {
        unset($_SESSION);
        session_destroy();
        header("Location:../view/login");
        exit;
    }

    /**
     * @param string $email
     * @param string|null $password
     * @param string|null $cpassword
     *
     * @return string
     */
    public function registerValidator($email, $password = null, $cpassword = null): string
    {
        $msg = '';
        if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
            $msg .= " Invalid email. <br> ";
        }
        if ($password != null && $cpassword != null) {
            if ($password === $cpassword) {
                if (!(preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $password))) {
                    $msg .= " Wrong password input. <br> Password should be at least 8 characters, including lowercase, uppercase, number and symbol. <br>";
                }
            } else {
                $msg .= "Passwords not matching! <br>";
            }
        }

        return $msg;
    }

    /**
     * @return void
     *
     * @throws AuthorizationException
     * @throws InvalidArgumentException
     * @throws InvalidFileException
     */
    public function edit()
    {
        $postParams = $this->request->getPostParams();
        if (isset($postParams['edit'])) {
            $error = false;
            $msg = "";
            if (!isset($postParams["first_name"]) || empty(trim($postParams["first_name"]))) {
                $msg = "First name is empty";
                $error = true;
            } elseif (!isset($postParams["last_name"]) || empty(trim($postParams["last_name"]))) {
                $msg = "Last name is empty";
                $error = true;
            } elseif (!isset($postParams["email"]) || empty(trim($postParams["email"]))) {
                $msg = "Email is empty";
                $error = true;
            } elseif (!isset($postParams["password"]) || empty(trim($postParams["password"]))) {
                $msg = "Password is empty";
                $error = true;
            } elseif ((!isset($postParams["cpassword"]) || empty(trim($postParams["cpassword"]))) &&
                (isset($postParams["new_password"]) && !empty(trim($postParams["new_password"])))) {
                $msg = "Confirm new password is empty";
                $error = true;
            }
            if ($error) {

                include_once "view/editProfile.php";

                return;
            }
            $userDao = new UserDAO();
            $params = [
                'email' => $_SESSION["logged_user"]["email"]
            ];
            $user = $userDao->findBy($params, true);
            if (empty($user)) {
                throw new AuthorizationException("Unauthorized user.");
            }
            var_dump($user);
            $password = $user['password'];
            if (password_verify($postParams['password'], $password)) {
                $first_name = $postParams["first_name"];
                $email = $postParams["email"];
                $last_name = $postParams["last_name"];
                $role = $postParams['role'];
            }

            if (isset($postParams['new_password']) && isset($postParams['cpassword'])) {
                $msg = $this->registerValidator($email, $postParams["new_password"], $postParams["cpassword"]);
                if ($msg) {

                    include_once "view/editProfile.php";

                    echo $msg;

                    return;
                }
                $password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
            }
            $user = new User($first_name, $last_name, $email, $password, true, $role);
            $user->setId($_SESSION['logged_user']['id']);
            $params = [
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'active' => $user->getActive(),
                'role' => $user->getRole()
            ];
            $conditions = [
                'id' => $user->getId()
            ];
            $userDao->update($params, $conditions);
            $arrayUser = [];
            $arrayUser['id'] = $user->getId();
            $arrayUser['first_name'] = $user->getFirstName();
            $arrayUser['last_name'] = $user->getLastName();
            $arrayUser['email'] = $user->getEmail();
            $arrayUser["role"] = $user->getRole();
            $_SESSION['logged_user'] = $arrayUser;

            include_once "view/main.php";

            echo "Profile changed successfully!";
        } else {

            include_once "view/editProfile.php";

            echo "Incorrect password!";
        }
    }
}