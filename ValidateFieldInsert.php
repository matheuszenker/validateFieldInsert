<?php
class ValidateFieldInsert {
	private $jsonReturn = array('status' => true);
	private $arrInsertUpdate = array();

	public function results() {
		if(!empty($this->jsonReturn['field'])) {
			$this->jsonReturn['field'] = array_unique($this->jsonReturn['field']);
		}

		if($this->jsonReturn['status']) {
			$this->jsonReturn['insert'] = $this->arrInsertUpdate;	
		}
		
		return $this->jsonReturn;
	}

	public function addInsert($value, $dbfield) {
		$this->arrInsertUpdate[$dbfield] = $value;
	}
    
    public function exist($value, $field, $dbfield, $insert = true) {
        if(empty($value)) {
            $this->jsonReturn['status'] = false;
            $this->jsonReturn['field'][] = $field;
            return false;
        }

        if($insert) {
            $this->arrInsertUpdate[$dbfield] = $value;
        }
    }
    
	public function mail($value, $field, $dbfield) {
		if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
			$this->jsonReturn['status'] = false;
			$this->jsonReturn['field'][] = $field;
			return false;
		} 

		$this->arrInsertUpdate[$dbfield] = $value;
	}

	public function equals($value, $value2, $field) {
		if($value != $value2 || !$value || !$value2) {
			$this->jsonReturn['status'] = false;
			$this->jsonReturn['field'][] = $field;
		}
	}

	public function lenght($value, $size, $field, $dbfield) {
		if(strlen($value) < $size) {
			$this->jsonReturn['status'] = false;
			$this->jsonReturn['field'][] = $field;
			return false;
		} 

		$this->arrInsertUpdate[$dbfield] = $value;
	}

	public function inRange($value, $min, $max, $field, $dbfield) {
		if($value < $min || $value > $max) {
			$this->jsonReturn['status'] = false;
			$this->jsonReturn['field'][] = $field;
			return false;
		} 

		$this->arrInsertUpdate[$dbfield] = $value;
	}

	public function phone($value, $field, $dbfield) {
		$exp = '/^(\([0-9]{2}\))\s([0-9]{1})?([0-9]{4})-([0-9]{4})$/';
		if(!preg_match($exp, $value)) {
			$this->jsonReturn['status'] = false;
			$this->jsonReturn['field'][] = $field;
			return false;
		} 

		$this->arrInsertUpdate[$dbfield] = $value;
	}

	public function number($value, $field, $dbfield) {
		if(!is_numeric($value)) {
			$this->jsonReturn['status'] = false;
			$this->jsonReturn['field'][] = $field;
			return false;
		} 

		$this->arrInsertUpdate[$dbfield] = $value;
	}

	public function integer($value, $field, $dbfield) {
		if(!is_integer($value)) {
			$this->jsonReturn['status'] = false;
			$this->jsonReturn['field'][] = $field;
			return false;
		} 

		$this->arrInsertUpdate[$dbfield] = $value;
	}

	public function dateUs($value, $field, $dbfield) {
		$exp = '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/';
		if(!preg_match($exp, $value)) {
			$this->jsonReturn['status'] = false;
			$this->jsonReturn['field'][] = $field;
			return false;
		} 

		$this->arrInsertUpdate[$dbfield] = $value;
	}

	public function dateBr($value, $field, $dbfield) {
		$exp = '/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}$/';
		if(!preg_match($exp, $value)) {
			$this->jsonReturn['status'] = false;
			$this->jsonReturn['field'][] = $field;
			return false;
		} 

		$this->arrInsertUpdate[$dbfield] = $value;
	}

	public function cep($value, $field, $dbfield) {
		$exp = '/^[0-9]{5}-[0-9]{3}$/';
		if(!preg_match($exp, $value)) {
			$this->jsonReturn['status'] = false;
			$this->jsonReturn['field'][] = $field;
			return false;
		} 

		$this->arrInsertUpdate[$dbfield] = $value;
	}

	public function cpf($value, $field, $dbfield) {
	    if(empty($value)) {
	        $this->jsonReturn['status'] = false;
			$this->jsonReturn['field'][] = $field;
			
			return false;
	    }

        $originalValue = $value;
	 	
	    $value = preg_replace('/[^0-9]/', '', $value);
	    $value = str_pad($value, 11, '0', STR_PAD_LEFT);
	    
	    if (strlen($value) != 11) {
	        $this->jsonReturn['status'] = false;
			$this->jsonReturn['field'][] = $field;
			return false;
	    } else if ($value == '00000000000' || 
	        $value == '11111111111' || 
	        $value == '22222222222' || 
	        $value == '33333333333' || 
	        $value == '44444444444' || 
	        $value == '55555555555' || 
	        $value == '66666666666' || 
	        $value == '77777777777' || 
	        $value == '88888888888' || 
	        $value == '99999999999') {

	        $this->jsonReturn['status'] = false;
			$this->jsonReturn['field'][] = $field;

			return false;
	     } else {   
	        for ($t = 9; $t < 11; $t++) {
	             
	            for ($d = 0, $c = 0; $c < $t; $c++) {
	                $d += $value{$c} * (($t + 1) - $c);
	            }
	            $d = ((10 * $d) % 11) % 10;
	            if ($value{$c} != $d) {
	                $this->jsonReturn['status'] = false;
					$this->jsonReturn['field'][] = $field;

					return false;
	            }
	        }
	 
	        $this->arrInsertUpdate[$dbfield] = $originalValue;
	    }
	}

    public function cnpj($value, $field, $dbfield) {
        $cnpj = $value;

        if (strlen($cnpj) <> 18) {
            $this->jsonReturn['status'] = false;
            $this->jsonReturn['field'][] = $field;

            return false;
        }

        $soma1 = ($cnpj[0] * 5) + ($cnpj[1] * 4) + ($cnpj[3] * 3)
          + ($cnpj[4] * 2) + ($cnpj[5] * 9) + ($cnpj[7] * 8)
          + ($cnpj[8] * 7) + ($cnpj[9] * 6) +  ($cnpj[11] * 5)
          + ($cnpj[12] * 4)
          + ($cnpj[13] * 3) + ($cnpj[14] * 2);

        $resto = $soma1 % 11;

        $digito1 = $resto < 2 ? 0 : 11 - $resto;

        $soma2 = ($cnpj[0] * 6) + ($cnpj[1] * 5) + ($cnpj[3] * 4)
          + ($cnpj[4] * 3) + ($cnpj[5] * 2) + ($cnpj[7] * 9)
          + ($cnpj[8] * 8) + ($cnpj[9] * 7) + ($cnpj[11] * 6)
          + ($cnpj[12] * 5) + ($cnpj[13] * 4) + ($cnpj[14] * 3)
          + ($cnpj[16] * 2);

        $resto = $soma2 % 11;

        $digito2 = $resto < 2 ? 0 : 11 - $resto;

        $result = (($cnpj[16] == $digito1) && ($cnpj[17] == $digito2));
        
        if(!$result) {
            $this->jsonReturn['status'] = false;
            $this->jsonReturn['field'][] = $field;

            return false;
        }

        $this->arrInsertUpdate[$dbfield] = $value;
    }
}