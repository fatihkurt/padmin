<?php

namespace category;

class Merchant extends \Phalcon\Mvc\Model
{


    public function initialize()
    {
        $this->hasMany("id", "Merchant", "parent_id");
    }
    
    public function getSource()
    {
        return "_merchant_category";
    }
    
    public function getChild($parent_id) {
        return Merchant::find(array(
            'conditions' => "parent_id = $parent_id",
        ));
    }
    
    
    public function getMerchants($catId) {
        
        return Merchant::find(array(
            'conditions' => "parent_id = $catId"
        ));
    }
    
    public function getMerchant($catId) {
        
        return Merchant::findFirst($catId);
    }

}