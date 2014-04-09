<?php

namespace Jlib\View\Html\Message;

use Jlib\View\Html\HtmlAbstract;

class Alert extends HtmlAbstract {
	
	public $_type;
	
	public $_msgTitle;
	
	public $_msg;
	
	public $_closeButton;
	
	CONST ERROR_MSG 	= 'alert-danger';
	CONST SUCCESS_MSG 	= 'success';
	CONST INFO_MSG 		= 'info';
	CONST WARNING_MSG 	= 'warning';
	
	public function __construct($tipo, $msgTitle, $msg, $cssArray = null){
		$this->_type 		= $tipo;
		$this->_msgTitle 	= $msgTitle;
		$this->_msg 		= $msg;
		$this->_closeButton	= true;
	
		if (!empty($cssArray)){
			$this->_cssStyleArray = array_merge($this->_cssStyleArray, $cssArray);
		}	
	}

	public function __toString(){
		return $this->render();
	}
	
	public function render(){
		$html = '';
		$html.= '<div id="'. $this->_htmlId .'" class="alert '. $this->_type .'" style="'. $this->cssToString() .'">';
		$html.= '	<span class="icon"></span>';
		if ($this->_closeButton)
			$html.= '	<span class="hide">x</span>';
		$html.= '	<strong>' . $this->_msgTitle . '</strong> - ';
		$html.=		$this->_msg;
		$html.= '</div>';
	
		return $html;
	}
}