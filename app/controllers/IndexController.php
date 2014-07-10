<?php

class IndexController extends ControllerBase
{

    public function initialize()
    {
        //Set the document title
        $this->tag->setTitle('Yönetim Paneli');
        parent::initialize();
    }
    
    public function indexAction()
    {
        
    }

}