<?php
namespace Jlib\Log;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class LogException extends AbstractPlugin {

    CONST LOG_DIR = '/public/log/exception/';
    
    /**
     * Caminho fisico do diretorio do arquivo
     * @var string
     */
    protected $_dirFileOnDisc;
    
    /**
     * Caminho virtual do arquivo
     * @var string
     */
    protected $_dirFileVirtual;
    
    protected $_exception;
    
    protected $_fileName;
    protected $_fileNameFull;
    protected $_mensagem;
    protected $_downloadLink;
    
    
    public function __construct(\Exception $e){
        $this->_exception = $e;
        $this->grava();
    }
    
    /**
     * Grava a mensagem no arquivo.
     * 
     * @param \Exception $e
     * @return boolean
     */
    protected function grava(){
        //verifica se já existe o diretorio para o arquivo
        $this->_dirFileVirtual 	= self::LOG_DIR;												//caminho virtual do diretório
        $this->_dirFileOnDisc 	= getcwd() . str_replace('/', '\\', $this->_dirFileVirtual); 	//caminho fisico do diretório
        
        $erro = false;
        if (!is_dir($this->_dirFileOnDisc)){
            if (!mkdir($this->_dirFileOnDisc, 0777, true)){
                throw new \Exception('Erro ao gerar arquivo de log. Falha ao criar o diretório.');
            }
        }
        
        $date 					= new \DateTime();
        $this->_fileName 		= $date->format('Ymd_His').'_'.rand(111,999);
        $this->_fileNameFull	= $this->_fileName.'.txt';
        $handle 				= fopen($this->_dirFileOnDisc.$this->_fileNameFull, "w");
        
        $mensagem = "MENSAGEM: ".$this->_exception->getMessage()."\n";
        $mensagem.= "ARQUIVO: ".$this->_exception->getFile()." - LINHA: ".$this->_exception->getLine()."\n";
        $mensagem.= "TRACE: ".$this->_exception->getTraceAsString()."\n";
        
        fwrite($handle, $mensagem);
        fclose($handle);
        
        $this->_mensagem 		= $mensagem;
        $this->_downloadLink	= str_replace('/public', '', $this->_dirFileVirtual).$this->_fileNameFull;
    }
    
    public function getFileName(){
        return $this->_fileNameFull;
    }
    
    public function getMessage(){
        return $this->_exception->getMessage().'.<br><b><a href="'.$this->_downloadLink.'"> Clique aqui</a> para baixar o arquivo de log.</b>';
    }
}

?>