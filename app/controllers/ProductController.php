<?php

use Phalcon\Mvc\Model\Resultset;

class ProductController extends ControllerBase
{


    
    
    public function indexAction () {
        
    }
    
    
    
    public function ajax_missingProductsAction() {
        
        $products = product\Product::find(
            array(
                'columns'   => 'category_id,offer_id,category_id1,COUNT(category_id) AS say',
                'conditions'=> 'r_category=0 AND category_id>0',
                'group'     => 'category_id',
                'order'     => 'say DESC',
                'limit'     => 20,
            )
        )->toArray();

        $affiliateOffers = array();
        $merchants = array();
        $checkArr = array();
        foreach ($products as & $product) {
            
            $merchant = category\Merchant::findFirst($product['category_id'])->toArray();
            
            $product['cat_name'] = $merchant['category_name'];
            
            $merchants[] = $merchant;
            
            if (! isset($checkArr[$product['offer_id']])) {
                    
                $affiliateOffers[] = affiliate\Offer::findFirst('af_offer_id=' . $product['offer_id'])->toArray();
                
                $checkArr[$product['offer_id']] = true;
            }
        }

        
        parent::jsonCostumOutput(
            array(
                'products'  => $products,
                'merchants' => $merchants,
                'offers'    => $affiliateOffers,
            )
        );
    }
    
    public function ajax_productsAction() {

        $query = '';

        if ($request->getPost('category_id1') > 0) {
            $query = ' AND category_id1=' . $request->getPost('category_id1');
        }
        else
        if ($request->getPost('category_id') > 0) {
            $query = ' AND category_id=' . $request->getPost('category_id');
        }

        if ($request->getPost('sex') > 0) {
            $query .= ' AND sex=' . $request->getPost('sex');
        }

        if ($request->getPost('offer_id') > 0) {
            $query .= ' AND offer_id=' . $request->getPost('offer_id');
        }

        $products = product\Product::find(array(
            'columns'   => 'id,image',
            'conditions'=> 'r_category=0 AND category_id>0' . $query,
            'order'     => 'RAND()',
            'limit'     => 5,
        ));

        parent::jsonOutput($products->toArray());
    }
    
}