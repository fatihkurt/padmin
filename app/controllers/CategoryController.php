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