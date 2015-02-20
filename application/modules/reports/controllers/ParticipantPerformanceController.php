<?php

class Reports_ParticipantPerformanceController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('index', 'html')
                    ->addActionContext('participant-performance-export', 'html')
                    ->initContext();
        $this->_helper->layout()->pageName = 'report'; 
    }

    public function indexAction()
    {
        if ($this->getRequest()->isPost()) {
            $params = $this->_getAllParams();
            $reportService = new Application_Service_Reports();
            $response=$reportService->getParticipantPerformanceReport($params);
            $this->view->response = $response;
        }
        $scheme = new Application_Service_Schemes();
        $this->view->schemes = $scheme->getAllSchemes();
    }

    public function participantPerformanceExportAction()
    {
       $reportService = new Application_Service_Reports();
        if($this->getRequest()->isPost()){
            $params = $this->_getAllParams();
            $this->view->exported=$reportService->exportParticipantPerformanceReport($params);
        }
    }

    public function chartAction()
    {
        //if ($this->getRequest()->isPost()) {
        //    $params = $this->_getAllParams();
        //    $reportService = new Application_Service_Reports();
        //    $response=$reportService->getPerformancePieChart($params);
        //    $this->view->response = $response;
        //}
    }


}



