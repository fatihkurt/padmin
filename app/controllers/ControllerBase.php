<?php

class ControllerBase extends Phalcon\Mvc\Controller
{

    protected $breadjumps = array();


    protected function initialize()
    {
        $this->tag->prependTitle('Popsbuy | ');

        array_push($this->breadjumps, array(
            'link' => '',
            'name' => 'Anasayfa'
        ));
        
        $this->assets
            ->collection('footer')
            ->addJs('themes/metronic/assets/global/plugins/select2/select2.min.js')
            ->addJs('themes/metronic/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')
            ->addJs('themes/metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')
            ->addJs('themes/metronic/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')
            ->addJs('themes/metronic/assets/global/scripts/metronic.js')
            ->addJs('themes/metronic/assets/admin/layout/scripts/layout.js')
            ->addJs('themes/metronic/assets/admin/layout/scripts/quick-sidebar.js');
        
        $this->assets
            ->addCss('themes/metronic/assets/global/plugins/select2/select2.css')
            ->addCss('themes/metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css');
    }
    



    public function notFoundAction()
    {
        // Send a HTTP 404 response header
        $this->response->setStatusCode(404, "Not Found");
    }
    
    public function afterExecuteRoute($dispatcher)
    {
        
        $this->view->breadjumps = $this->breadjumps;
    }
    
}