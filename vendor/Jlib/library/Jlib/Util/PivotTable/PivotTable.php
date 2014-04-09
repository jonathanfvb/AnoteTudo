<?php

namespace Jlib\Util\PivotTable;

class PivotTable {

    private $_fixedColumn;
    private $_fixedColumnName;
    private $_topColumns;

    private $_arrayFixedColumns;
    private $_arrayTopColumns;

    private $_data;
    private $_dataReturn;
    private $_dataRepeated;
    private $_dataCount;


    public function __construct(array $data = array()){
        if (count($data) == 0)
            die('Array inválido.');
        $this->_data = $data;
    }

    public function setFixedColumn($columnIndex,$columnName = null){
        $this->_fixedColumn = $columnIndex;
        $this->_fixedColumnName = $columnName;        
        $this->setArrayFixedColumns($columnIndex);
    }

    public function setTopColumns($columnIndex){
        $this->_topColumns = $columnIndex;
        $this->setArrayTopColumns($columnIndex);
    }

    public function getFixedColumn(){
        return $this->_arrayFixedColumns;
    }

    public function getTopColumns(){
        return $this->_arrayTopColumns;
    }
	
    private function setArrayFixedColumns($columnName){
        $fixedColumns = array();
        foreach ($this->_data as $row){
            if (!in_array($row[$columnName], $fixedColumns))
                $fixedColumns[] = $row[$columnName];
        }

        $this->_arrayFixedColumns = $fixedColumns;
    }

    private function setArrayTopColumns($columnName){
        $topColumns = array();
        foreach ($this->_data as $row){
            if (!in_array($row[$columnName], $topColumns))
                $topColumns[] = $row[$columnName];
        }

        $this->_arrayTopColumns = $topColumns;
    }

    private  function prepare(){
        if (null === $this->_arrayTopColumns)
            die('Coluna do top não definida.');
        if (null === $this->_arrayFixedColumns)
            die('Coluna fixa não definida.');
    }

    public function pivot(){
        $this->prepare();
         
        foreach ($this->_data as $data){
            $fixedColumn 	= $data[$this->_fixedColumn];
            $topColumn		= $data[$this->_topColumns];
            if (isset($this->_dataReturn[$fixedColumn][$topColumn])){
                $this->_dataRepeated[$fixedColumn][$topColumn][] = $data;
            } else {
                $this->_dataReturn[$fixedColumn][$topColumn] = $data;
            }
        }

        return $this->_dataReturn;
    }


    /**
     * Conta a ocorrência dos agrupamentos
     */
    public function dataCount(){
        $this->prepare();
         
        foreach ($this->_data as $data){
            $fixedColumn 	= $data[$this->_fixedColumn];
            $topColumn		= $data[$this->_topColumns];
            if (isset($this->_dataCount[$fixedColumn][$topColumn])){
                $this->_dataCount[$fixedColumn][$topColumn] += 1;
            } else {
                $this->_dataCount[$fixedColumn][$topColumn] = 1;
            }
        }
         
        return $this->_dataCount;
    }
    
    public function getDataRepeated(){
        return $this->_dataRepeated;
    }
    
    public function getTableHeaderHtml(){
        $topColumns = $this->getTopColumns();
        $thead = '<thead>';
        $thead.= '	<tr>';
        $thead.= '	<th>'.(empty($this->_fixedColumnName) ? ' ' : $this->_fixedColumnName).'</th>';
        foreach ($topColumns as $cellHead){
            $thead.= '<th>'.$cellHead.'</th>';
        }
        $thead.= '	</tr>';
        $thead.= '</thead>';
        
        return $thead; 
    }
    
    public function getDistinctDataFromColumn($columnIndex){
        $dataReturn = array();
        foreach ($this->_data as $data){
            if (isset($data[$columnIndex])){
            	if (!in_array($data[$columnIndex], $dataReturn)){
            		$dataReturn[] = $data[$columnIndex];
            	}
            }
        }
        
        return $dataReturn;
    } 
}
