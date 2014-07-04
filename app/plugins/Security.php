<?php

use Phalcon\Events\Event,
        Phalcon\Mvc\User\Plugin,
        Phalcon\Mvc\Dispatcher,
        Phalcon\Acl;

class Security extends Plugin
{

    public function getAcl() {
        
        //Create the ACL
        $acl = new Phalcon\Acl\Adapter\Memory();

        //The default action is DENY access
        $acl->setDefaultAction(Phalcon\Acl::DENY);

        //Register two roles, Users is registered users
        //and guests are users without a defined identity
        $roles = array(
            'users' => new Phalcon\Acl\Role('Users'),
            'guests' => new Phalcon\Acl\Role('Guests')
        );
        foreach ($roles as $role) {
            $acl->addRole($role);
        }

        //Private area resources (backend)
        $privateResources = array(
          'companies' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
          'products' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
          'producttypes' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
          'invoices' => array('index', 'profile')
        );
        foreach ($privateResources as $resource => $actions) {
            $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
        }

        //Public area resources (frontend)
        $publicResources = array(
          'index' => array('index'),
          'about' => array('index'),
          'session' => array('index', 'register', 'start', 'end'),
          'contact' => array('index', 'send')
        );
        foreach ($publicResources as $resource => $actions) {
            $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
        }

        //Grant access to public areas to both users and guests
        foreach ($roles as $role) {
            foreach ($publicResources as $resource => $actions) {
                $acl->allow($role->getName(), $resource, '*');
            }
        }

        //Grant access to private area only to role Users
        foreach ($privateResources as $resource => $actions) {
            foreach ($actions as $action) {
                $acl->allow('Users', $resource, $action);
            }
        }
        
        return $acl;
    }

    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {

        //Check whether the "auth" variable exists in session to define the active role
        $auth = $this->session->get('auth');
        if (!$auth) {
            $role = 'Guests';
        } else {
            $role = 'Users';
        }

        //Take the active controller/action from the dispatcher
        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        //Obtain the ACL list
        $acl = $this->getAcl();

        //Check if the Role have access to the controller (resource)
        $allowed = $acl->isAllowed($role, $controller, $action);
        if ($allowed != Acl::ALLOW) {

            //If he doesn't have access forward him to the index controller
            $this->flash->error("You don't have access to this module");
            $dispatcher->forward(
                array(
                    'controller' => 'index',
                    'action' => 'index'
                )
            );

            //Returning "false" we tell to the dispatcher to stop the current operation
            return false;
        }

    }

}