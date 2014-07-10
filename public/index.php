<?php

try {
    
    define('APPPATH', __DIR__ . '/../app');
    
    
    $config = new Phalcon\Config\Adapter\Ini(APPPATH .'/config/config.ini');

    //Register an autoloader
    $loader = new \Phalcon\Loader();

    $loader->registerDirs(array(
        APPPATH . '/controllers/',
        APPPATH . '/models/',
        //APPPATH . '/models/category/',
        APPPATH . '/plugins/',
        APPPATH . '/library/',
    ))->register();

    //Create a DI
    $di = new Phalcon\DI\FactoryDefault();
    
    
//    $di->set('dispatcher', function() use ($di) {
//
//        //Obtain the standard eventsManager from the DI
//        $eventsManager = $di->getShared('eventsManager');
//
//        //Instantiate the Security plugin
//        $security = new Security($di);
//
//        //Listen for events produced in the dispatcher using the Security plugin
//        $eventsManager->attach('dispatch', $security);
//
//        $dispatcher = new Phalcon\Mvc\Dispatcher();
//
//        //Bind the EventsManager to the Dispatcher
//        $dispatcher->setEventsManager($eventsManager);
//
//        return $dispatcher;
//    });

    //Setup the view component
    $di->set('view', function(){
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../app/views/');
        return $view;
    });
    
    //Setup the database service
    $di->set('db', function() use ($config) {
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            'host'      => $config->db->host,
            'username'  => $config->db->user,
            'password'  => $config->db->pass,
            'dbname'    => $config->db->name,
            'charset'   =>'utf8',
            'options'   => array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            )
        ));
    });
    
    //Start the session the first time a component requests the session service
    $di->set('session', function() {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

    //Setup a base URI so that all generated URIs include the "tutorial" folder
    $di->set('url', function(){
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri('/');
        return $url;
    });
    
    //Register an user component
    $di->set('elements', function(){
        return new Elements();
    });

    //Handle the request
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} 
catch(\Phalcon\Exception $e) {
     
    echo "PhalconException: ", $e->getMessage();
}