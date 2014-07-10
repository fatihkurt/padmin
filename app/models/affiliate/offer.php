<?php

namespace affiliate;

class Offer extends \Phalcon\Mvc\Model
{
    
    public function initialize()
    {
        $this->setSource('affiliate_offers');
    }

}