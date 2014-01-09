<?php

namespace Application;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use	Zend\Mvc\ModuleRouteListener;
use	Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
    	$application = $e->getApplication();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach( $application->getEventManager() );
        
        $em = $application->getEventManager();
        $em->attach(\Zend\Mvc\MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'handleError'));
        $em->attach(\Zend\Mvc\MvcEvent::EVENT_RENDER_ERROR, array($this, 'handleError'));
    }
    
    /**
     * TODO: handle errors exceptions and controller not found
     * @param MvcEvent $e
     */
    public function handleError(MvcEvent $e)
    {
    	$exception = $e->getParam('exception');
    	/* $e->getParam('controller');
    	if ( $e->getParam('error') ) {
    		header("Location: /");
    		exit;
    	}
    	*/
    	// var_dump( $e->getParam('router') );
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }
    
    public function getServiceConfig()
    {
    	return array( 'factories' => array() );
    }
}
