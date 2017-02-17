<?php
use Phalcon\Mvc\Router\Group;

$frontend = new Group(array(
    'namespace' => 'Modules\Frontend\Controllers',
    'module' => 'frontend',
));

$frontend->addGet('/', array(
        'controller'    => 'index',
        'action'        => 'index'
    )
);

$frontend->addGet('/:controller/:action/:params', array(
        'controller'    => 1,
        'action'        => 2,
        'params'        =>3
    )
);

$frontend->addGet('/:controller/:action', array(
        'controller'    => 'index',
        'action'        => 'index',
    )
);

$frontend->addPost('/:controller/:action/:params', array(
        'controller'    => 1,
        'action'        => 2,
        'params'        =>3
    )
);

$router->mount($frontend);