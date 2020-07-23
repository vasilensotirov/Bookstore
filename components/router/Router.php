<?php
namespace router;

use components\router\http\Request;
use exceptions\AuthorizationException;
use components\Authenticator;

class Router
{
    const PREFIX_TO_REMOVE_FROM_URI = '/Bookstore';
    const REGEX = '/\d+/';
    const URI_DELIMITER = '/';
    const WILDCARD = '{id}';
    const CLASS_AND_METHOD_DELIMITER = '@';
    const CONTROLLER_DIR = '\\controller\\';
    const VIEW_ROUTER = 'view';
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Authenticator
     */
    private $authenticate;

    /**
     * @param Request       $request
     * @param Authenticator $authenticate
     */
    public function __construct(Request $request, Authenticator $authenticate)
    {
        $this->request = $request;
        $this->authenticate = $authenticate;
    }

    /**
     * @param string $route
     * @param string $classAndMethod
     * @param bool   $authenticate
     *
     * @return mixed
     *
     * @throws AuthorizationException
     */
    public function route($route, $classAndMethod, $authenticate = false)
    {
        $requestUri = str_replace(self::PREFIX_TO_REMOVE_FROM_URI, '', $this->request->getRequestUri());
        $dynamicRoute = preg_match(self::REGEX, $requestUri);
        $arrayUri = explode(self::URI_DELIMITER, $requestUri);
        switch ($dynamicRoute) {
            case true:
                foreach ($arrayUri as $key => $value) {
                    if (is_numeric($value)) {
                        $this->request->addGetParam('id', $arrayUri[$key]);
                        $arrayUri[$key] = self::WILDCARD;

                    }
                }
                $uri = implode(self::URI_DELIMITER, $arrayUri);
                if ($route === $uri) {
                    $classAndMethodArray = explode(self::CLASS_AND_METHOD_DELIMITER, $classAndMethod);
                    $className = self::CONTROLLER_DIR . ucfirst($classAndMethodArray[0]);
                    $method = $classAndMethodArray[1];
                    $controller = new $className($this->request);
                    if ($authenticate) {
                        $this->authenticate->authenticate();
                    }
                    $controller->$method();
                    die;
                }
                break;
            case false:
                if ($route === $requestUri) {
                    $classAndMethodArray = explode(self::CLASS_AND_METHOD_DELIMITER, $classAndMethod);
                    $className = self::CONTROLLER_DIR . ucfirst($classAndMethodArray[0]);
                    $method = $classAndMethodArray[1];
                    $controller = new $className($this->request);
                    if ($authenticate) {
                        $this->authenticate->authenticate();
                    }
                    $arrayUri[1] == self::VIEW_ROUTER ?
                        $controller->$method($arrayUri[2]) :
                        $controller->$method();
                    die;
                }
        }
    }
}