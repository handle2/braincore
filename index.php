<?php

error_reporting(E_ALL);


function dd($data,$die = true){
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    if($die){
        die();
    }
}



try {

    /**
     * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
     */
    $di = new \Phalcon\DI\FactoryDefault();

    /**
     * Registering a router
     */
    $di['router'] = function () {

        $router = new \Phalcon\Mvc\Router(false);
        include 'apps/frontend/config/routes.php';
        include 'modules/Admin/config/routes.php';
        
        return $router;

    };

    /**
     * The URL component is used to generate all kind of urls in the application
     */
    $di->set('url', function () {
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri('http://braincore2/');
        return $url;
    });

    /**
     * Start the session the first time some component request the session service
     */
    $di->set('session', function () {
        $session = new \Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });
    $di->set('cookies', function () {
        $cookies = new Phalcon\Http\Response\Cookies();
        $cookies->useEncryption(false);
        return $cookies;
    });


    require "modules/predis/autoload.php";
    Predis\Autoloader::register();



    $client = new Predis\Client();

    $di->set('redis',$client);

    $di->set('resolutions',function (){
        return include 'apps/frontend/config/application.php';
    });


    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application();

    $application->setDI($di);

    /**
     * Register application modules
     */
    $application->registerModules(array(
        'frontend' => array(
            'className' => 'Modules\Frontend\Module',
            'path' => 'apps/frontend/Module.php'
        ),
        'admin' => array(
            'className' => 'Modules\Admin\Module',
            'path' => 'modules/Admin/Module.php'
        )
    ));

    echo $application->handle()->getContent();
} catch (Phalcon\Exception $e) {
    echo $e->getMessage();
} catch (PDOException $e) {
    echo $e->getMessage();
}
