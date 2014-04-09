<?php
namespace Basico\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session As SessionStorage;

class UserInfo extends AbstractHelper {

    public function __invoke($namespace = null){
        $sessionStorage = new SessionStorage($namespace);
        
        $authService = new AuthenticationService();
        $authService->setStorage($sessionStorage);
        if ($authService->hasIdentity()){
            return $authService->getIdentity();
        } else {
            return false;
        }
    }
}

?>