<?php

class FormButton extends View_Button {

	// function setIcon($icon)
 //    {
 //        $this->icon = $icon;
 //        $this->options['icons']['primary'] = $this->icon;
 //        return $this;
 //    }

	function jsButton(){

	}

	function defaultTemplate(){
		return array('button','button_normal');
	}
}