<?php

namespace category;

class Category extends \Phalcon\Mvc\Model
{
    
    public function initialize()
    {
        $this->setSource('_product_categories');
    }

}