<?php

class Button extends View_Button {
	function setLabel($label)
    {
        return $this->setHTML($this->api->_($label));
    }
}