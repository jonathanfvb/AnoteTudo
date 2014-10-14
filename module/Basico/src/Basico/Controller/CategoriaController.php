<?php

namespace Basico\Controller;

use Zend\View\Model\ViewModel;

class CategoriaController extends CrudController
{
    public function indexAction() {
        return new ViewModel();
    }
    
    public function newAction() {
        $viewModel = new ViewModel();
        //desabilita o layout devido a requisicao via ajax
        $viewModel->setTerminal(true);
        
        #$this->layout('layout/modal');
        
        return $viewModel;
    }
    
	public function getTabelaHtml ($where = array())
    {
        throw new \Exception('Método não implementado.');
    }
}
