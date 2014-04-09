<?php
namespace Basico\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Cria o html do campo do formulário.
 * 
 * @author Jonathan Fernando <jonathan@softwar.com.br>
 * @since 2014-02-13
 */
class FormularioCampo extends AbstractHelper {

    protected $_objForm;
    protected $_objFormCampo;
    protected $_objFormCampoFunctionName;
    protected $_campoNome;
    protected $_campoTipo;
    protected $_tamanhoLinha;
    protected $_idTagDiv;
    protected $_idTagP;
    protected $_idTagLabel;
    protected $_strHtml;
    
    public function __invoke($form, $campoNome, $tamanho, $idTagDiv = '', $idTagP = '', $idTagLabel = ''){        
        $this->_objForm = $form;
        
        $this->_idTagDiv 	= $idTagDiv;
        $this->_idTagP 		= $idTagP;
        $this->_idTagLabel 	= $idTagLabel;
        
        if (!empty($campoNome)){
        	$this->_objFormCampo = $this->_objForm->get($campoNome);
        	if (empty($this->_objFormCampo)){
        	    throw new \Exception("Falha ao recupar o campo {$campoNome}. Campo não encontrado no formulário.");
        	}
        	$this->_campoNome	 = $campoNome;
        	$this->_campoTipo 	 = $this->_objFormCampo->getAttribute('type');
        } else {
            $this->_campoNome	 = '';
            $this->_campoTipo    = 'empty';
        }
        $this->_tamanhoLinha = $tamanho;
        
        switch ($this->_campoTipo){
            case 'text':
                $this->_objFormCampoFunctionName = 'formInput';                
                break;
			case 'textarea':
            	$this->_objFormCampoFunctionName = 'formTextArea';
                break;
        	case 'hidden':
        	    $this->_objFormCampoFunctionName = 'formHidden';
        	    break;
        	case 'select':
        		$this->_objFormCampoFunctionName = 'formSelect';
        	    break;
			case 'checkbox':
        		$this->_objFormCampoFunctionName = 'formCheckbox';
        	    break;
			case 'radio':
        		$this->_objFormCampoFunctionName = 'formRadio';
        	    break;
        	case 'empty':
        	    break;
        	default:
        	    return "O tipo {$this->_campoTipo} não possui uma regra de renderização.";
        	    break;        	    
        }
        
        return $this->render();
    }
    
    protected function render(){
        $this->_strHtml	= '';
        $functionName 	= $this->_objFormCampoFunctionName;                
        
        if ($this->_campoTipo == 'hidden'){            
            $this->_strHtml.= '	'.$this->view->$functionName($this->_objFormCampo);
        }
        else {
            $this->_strHtml.= '<div class="_'.$this->_tamanhoLinha.'" id="'.$this->_idTagDiv.'">';
            $this->_strHtml.= '	<p id="'.$this->_idTagP.'">';
            
            if (!empty($this->_campoNome)){
                $this->_strHtml.= '	<label id="'.$this->_idTagLabel.'">'.$this->_objFormCampo->getLabel().'</label>';
                $this->_strHtml.= '	'.$this->view->$functionName($this->_objFormCampo);
            } else {
                $this->_strHtml.= '	<label id="'.$this->_idTagLabel.'">&nbsp;</label>';
            }
            
            $this->_strHtml.= '	</p>';
            $this->_strHtml.= '</div>';
        } 
                    
        return $this->_strHtml;
    }        
}

?>