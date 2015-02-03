<?php

class Reports_CorrectiveActionsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('index', 'html')
                ->addActionContext('corrective-actions-export', 'html')
                    ->initContext();
        $this->_helper->layout()->pageName = 'report'; 
    }

    public function indexAction()
    {
        if ($this->getRequest()->isPost()) {
            $params = $this->_getAllParams();
            $reportService = new Application_Service_Reports();
            $response=$reportService->getCorrectiveActionReport($params);
            $this->view->response = $response;
        }
        $scheme = new Application_Service_Schemes();
        $this->view->schemes = $scheme->getAllSchemes();
    }

    public function correctiveActionsExportAction()
    {
       $reportService = new Application_Service_Reports();
        if($this->getRequest()->isPost()){
            $params = $this->_getAllParams();
            $this->view->exported=$reportService->exportCorrectiveActionsReport($params);
        }
    }


}



