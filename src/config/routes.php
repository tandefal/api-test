<?php

use App\controllers\SiteController;
use App\controllers\UserController;
use App\controllers\UserGroupController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add('index',  new Route('/',['class' => SiteController::class]));

$routes->add('create',  new Route('/user/create',[
    'class' => UserController::class,
    '_method' => 'POST'
]));

$routes->add('remove',  new Route('/user/remove',[
    'class' => UserController::class,
    '_method' => 'DELETE'
]));

$routes->add('all',  new Route('/user/all',[
    'class' => UserController::class,
]));

$routes->add('addUserToGroup',  new Route('/user/group/add',[
    'class' => UserGroupController::class,
    '_method' => 'POST'
]));

$routes->add('removeUserFromGroup',  new Route('/user/group/remove',[
    'class' => UserGroupController::class,
    '_method' => 'DELETE'
]));

$routes->add('listGroups',  new Route('/user/group/list',[
    'class' => UserGroupController::class,
]));

$routes->add('userPermissions',  new Route('/user/permissions',[
    'class' => UserGroupController::class,
    '_method' => 'POST'
]));

$routes->add('blockPermission',  new Route('/user/block/permissions',[
    'class' => UserGroupController::class,
    '_method' => 'POST'
]));

$routes->add('unblockPermission',  new Route('/user/unblock/permissions',[
    'class' => UserGroupController::class,
    '_method' => 'POST'
]));


return $routes;