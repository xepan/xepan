<?php
class Form_Field_Email extends Form_Field_Line {
    public $min = null;
    public $max = null;

    function setRange($min,$max){
        $this->min = $min;
        $this->max = $max;
        return $this;
    }
    
    function validate(){
        // empty value is allowed
        if($this->value!=''){
            if( ! filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
                $this->displayFieldError('Must Be Valid Email');
            }
        }
        return parent::validate();
    }
}
