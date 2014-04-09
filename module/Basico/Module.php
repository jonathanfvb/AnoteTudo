<?php

namespace Basico;

//Zend
use Zend\Session\Container;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\ControllerManager;
use Zend\EventManager\Event;
use Zend\ModuleManager\ModuleManager;
use Zend\Authentication\Storage\Session As SessionStorage;
use Zend\Authentication\AuthenticationService;

//Service
#use Basico\Service\Agenda As SvcAgenda;
#use Basico\Service\PessoaFisica As SvcPessoaFisica;

//Form
#use Basico\Form\Agenda As FrmAgenda;

//Auth
use Basico\Auth\Adapter As AuthAdapter;

//View
use Basico\View\Helper\LegendaDeCores;
use Basico\View\Helper\UserInfo;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getAutoloaderConfig()
    {
        return array(
                'Zend\Loader\StandardAutoloader' => array(
                        'namespaces' => array(
                                __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                        ),
                ),
        );
    }
    
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        /*
        //Diferentes layouts de acordo com módulos
        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', 'dispatch', function($e) {
            $controller      = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            $config          = $e->getApplication()->getServiceManager()->get('config');
            if (isset($config['module_layouts'][$moduleNamespace])) {
                $controller->layout($config['module_layouts'][$moduleNamespace]);
            } else {
                $controller->layout($config['module_layouts']['Basico']);
            }
        }, 100);
        */
    }       

    /**
     * Métodos e Configurações executados ao iniciar
     */
    public function init(ModuleManager $moduleManager){
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
    	
        /*
        // --------------------------------------------------
        // Verifica se o usuário está logado no sistema
        // --------------------------------------------------
        $sharedEvents->attach('Zend\Mvc\Controller\AbstractController', 'dispatch', function($e){
            $controller = $e->getTarget();
            $controllerClass = get_class($controller);
    
            $sessionStorage = new SessionStorage('Main');
            $auth = new AuthenticationService();
            $auth->setStorage($sessionStorage);
            if (!$auth->hasIdentity() && $controllerClass != 'Basico\Controller\AuthController'){
                return $controller->redirect()->toRoute('login');
            }
        }, 99);
    
        // --------------------------------------------------
        // Configurações do relatório
        // --------------------------------------------------
        $sharedEvents->attach('Zend\Mvc\Controller\AbstractController', 'dispatch', function($e){
            $controller = $e->getTarget();
            $config 	= $controller->getServiceLocator()->get('config');
            if (isset($config['jasper'])){
                $session = new Container('Report');
                foreach ($config['jasper']['params'] as $param => $value){
                    $session->offsetSet($param, $value);
                }
            }
        }, 98);
        */ 
    }            
    
    public function getViewHelperConfig(){
        return array(
                'invokables' => array(
                        'UserInfo' 				=> new View\Helper\UserInfo(),
                        'LegendaDeCores' 		=> new View\Helper\LegendaDeCores(),
                        'LabelStatus' 			=> new View\Helper\LabelStatus(),
                        'ProgressBar' 			=> new View\Helper\ProgressBar(),
                        'FormularioCampo'		=> new View\Helper\FormularioCampo(),
                        'FormularioCampoSelect'	=> new View\Helper\FormularioCampoSelect(),
                )
        );
    }
}
