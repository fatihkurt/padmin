<?php

use Phalcon\Mvc\Model\Resultset;

class CategoryController extends ControllerBase
{

    public function initialize()
    {
        //Set the document title
        $this->tag->setTitle('Kategori Yönetimi');
        
        parent::initialize();
        
        array_push($this->breadjumps, array(
            'link' => 'category',
            'name' => 'Kategori'
        ));
    }
    
    
    public function indexAction () {
        
    }
    

    public function assignUnrelatedCategoriesAction()
    {

        array_push($this->breadjumps, array(
            'link' => 'category/assignUnrelatedCategories',
            'name' => 'Kategori İlişkilendirme'
        ));


        $this->assets->collection('footer')->addJs('assets/js/modules/category/assign_category.js');

        
        $missingProducts = product\Product::find(array(
            'columns'   => 'id,category_id,offer_id,category_id1,COUNT(category_id) AS say',
            'conditions'=> 'r_category=0 AND category_id>0',
            'group'     => 'category_id',
            'order'     => 'say DESC',
            'limit'     => 20,
        ));

        $missingProducts->setHydrateMode(Resultset::HYDRATE_OBJECTS);

        $this->view->setVars(array(
            'missingProducts' => $missingProducts,
        ));
    }
    
    
    
    public function merchantListAction() {
        
        $category = category\Merchant::find(array(
            "conditions" => "parent_id=0"
        ));
        
        $category->setHydrateMode(Resultset::HYDRATE_RECORDS);
        
        $this->view->setVars(array(
            'categories' => $category,
        ));
    }
    
}