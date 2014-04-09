<?php

namespace Jlib\Util;

class FormatValue {

	//Currency
	public $_currencySymbol 		= 'R$';
	public $_currencyNumDecimals 	= 2;
	public $_currencySeparatorDec	= ',';
	public $_currencySeparatorMil	= '.';

	//Date	
	public $_dateFormatToView		= 'd/m/Y';
	public $_dateFormatToSave		= 'Y-m-d';
	
	//Hour
	public $_hourFormatToView		= 'H:i';
	public $_hourFormatToSave		= 'H:i:s';

	//DateTime	
	public $_dateTimeFormatToView	= 'd/m/Y H:i:s';
	public $_dateTimeFormatToSave	= 'Y-m-d H:i:s';	

	public function formatCurrencyToView($value){
	    if (empty($value))
	        $value = 0;
	    
	    return $this->_currencySymbol .' '
	    		. number_format($value,
					            $this->_currencyNumDecimals,
					            $this->_currencySeparatorDec,
					            $this->_currencySeparatorMil);
	}
	
	public function formatCurrencyToSave($value){
		if (empty($value)){
			return $value;
		} else {
			$value = str_replace($this->_currencySymbol, '', $value);
			$value = str_replace('.', '', $value);
			$value = str_replace(',', '.', $value);
			return $value;
		}				
	}

	public function formatDateToView($value){
		if (empty($value)){
			return '00/00/0000';
		} else {
			if ($value instanceof \DateTime){
				return $value->format($this->_dateFormatToView);
			} else {
				throw new \Exception('A data informada precisa ser um objeto do tipo DateTime.');
			}
		}
	}
	
	/**
	 * Converte a data de d/m/y para DateTime
	 * 
	 * @param $value
	 * @return DateTime
	 */
	public function formatDateToSave($value){		
		$date = substr($value,6,4);
		$date.= '-'.substr($value,3,2);
		$date.= '-'.substr($value,0,2);
		return new \DateTime($date);
	}
	
	/**
	 * Converte uma string d/m/Y H:i:s para Datetime
	 * 
	 * @param string $value d/m/Y H:i:s
	 * @return DateTime 
	 */
	public function formatDateTimeToSave($value){
	    if (!empty($value)){
		    $date = substr($value,6,4);
			$date.= '-'.substr($value,3,2);
			$date.= '-'.substr($value,0,2);
			$date.= ' '.substr($value,11,8);
			return new \DateTime($date);
	    } else {
	        return $value;
	    } 
	}
	
	/**
	 * Converte um objeto datetime para o formato de visualização d/m/Y H:i:s
	 * 
	 * @param Datetime $value
	 * @throws \Exception
	 */
	public function formatDateTimeToView($value){
	    if (empty($value)){
	        return '00/00/0000';
	    } else {
	        if ($value instanceof \DateTime){
	            return $value->format($this->_dateTimeFormatToView);
	        } else {
	            throw new \Exception('A data informada precisa ser um objeto do tipo DateTime.');
	        }
	    }
	}
	
	/**
	 * Formata a data para o formato de saída informado.
	 * Formatos de entrada suportados (d/m/Y, Y-m-d)
	 * 
	 * @param string $date
	 * @param string $inputFormat
	 * @param string $outputFormat
	 */
	public function formatDate($date,$inputFormat,$outputFormat){
	    if ($inputFormat == 'd/m/Y'){
	        $dataObj = $this->formatDateToSave($date);
	        return $dataObj->format($outputFormat);
	    }
	    elseif ($inputFormat == 'Y-m-d'){
	        $dataY = substr($date,0,4);
	        $dataM = substr($date,5,2);
	        $dataD = substr($date,8,2);
	        
	        $dataObj = new \DateTime($dataY.'-'.$dataM.'-'.$dataD);
	        return $dataObj->format($outputFormat);
	    } else {
	        throw new \Exception('Formato de entrada não suportado.');
	    }
	}
	
	/**
	 * Retorna uma data no formato de hora.
	 *  
	 * @param DateTime $date
	 * @param boolean $showSeconds default false
	 * @throws Exception
	 */
	public function formatHourToView($date, $showSeconds = false){
	    if (empty($date)){
	        return '00:00';
	    } else {
	        if ($date instanceof \DateTime){
	            if ($showSeconds)
	            	return $date->format($this->_hourFormatToView);
	            else
	                return $date->format($this->_hourFormatToSave);
	        } else {
	            throw new \Exception('A data informada precisa ser um objeto do tipo DateTime.');
	        }
	    }
	}
	
	/**
	 * Remove os caracteres do campo.
	 * Caracteres removidos: . - / \ ( )
	 * 
	 * @param string $field
	 * @param array $characters (opcional) Array com os caracteres adicionais que precisam ser removidos 
	 * @return string
	 */
	public function cleanField($field, array $characters = array()){
	    $search = array('.','-','/','\\','(',')');
	    
	    if (count($characters)){
	        foreach ($characters as $character){
	            $search[] = $character;
	        }
	    }
	    
	    $field = str_replace($search, '', $field);
	    return $field;
	}
	
	/**
	 * Retorna o campo em formato decimal.
	 * 
	 * @param decimal $value Valor a ser formatado
	 * @param int $numDec Numero de casas decimais
	 * @param char $sepDec Separador de decimal
	 * @param char $sepMil Separador de milhar
	 */
	public function formatDecimal($value, $numDec, $sepDec, $sepMil){
	    return number_format($value, $numDec, $sepDec, $sepMil);
	}
}