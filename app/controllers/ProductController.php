<?php

use Phalcon\Mvc\Model\Resultset;

class ProductController extends ControllerBase
{


    
    
    public function indexAction () {
        
    }
    
    
    public function ajax_productsAction() {
        
        $request = new \Phalcon\Http\Request();
        
        if ($request->isPost() == true) {

            if ($request->isAjax() == true) {
                
                $response = new \Phalcon\Http\Response();

                $response->setContentType('application/json', 'UTF-8');
                
                
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

                $products->setHydrateMode(Resultset::HYDRATE_ARRAYS);

                $response->setContent(json_encode($products));

                return $response;
            }
        }
    }
    
}