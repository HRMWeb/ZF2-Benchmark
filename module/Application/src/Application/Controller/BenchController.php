<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BenchController extends AbstractActionController
{
    protected $benchTable;

    public function plainAction()
    {
        $result = new ViewModel();
        $result->setTerminal(true);
        return $result;
    }

    public function modelAction()
    {
        for ($i = 0; $i < 100; $i++) {
            foreach ($this->getBenchTable()->fetchAll() as $b) {
                error_log($b->title);
            }           
        }
        for ($i = 0; $i < 10; $i++) {
            $b = new \Application\Model\Bench();
            $b->title = 'Test title';
            $id = $this->getBenchTable()->saveBench($b);
            $this->getBenchTable()->deleteBench($id);
        }
        $result = new ViewModel();
        $result->setTerminal(true);
        return $result;     
    }

    public function getBenchTable()
    {
        if (!$this->benchTable) {
            $sm = $this->getServiceLocator();
            $this->benchTable = $sm->get('Application\Model\BenchTable');
        }
        return $this->benchTable;
    }
}
