<?php

namespace Basico\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class TesteController extends CrudController
{
    public function indexAction()
    {
        $registros = array();
        try {
            $repository = $this->getEm()->getRepository('Basico\Entity\Categoria');
            $registros	= $repository->fetchPairs();            
        } catch (\Exception $e) {
            $this->addMessageError($e->getMessage());
        }
        
        return new ViewModel(array(
                'mensagem'	=> $this->getMessages(),
                'registros'	=> $registros,
		));
    }
    
	public function getTabelaHtml ($where = array())
    {
        throw new \Exception('Método não implementado.');
    }
}
