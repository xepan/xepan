<?php // vim:ts=4:sw=4:et:fdm=marker
/*
 * Undocumented
 *
 * @link http://agiletoolkit.org/
*//*
==ATK4===================================================
   This file is part of Agile Toolkit 4
    http://agiletoolkit.org/

   (c) 2008-2013 Agile Toolkit Limited <info@agiletoolkit.org>
   Distributed under Affero General Public License v3 and
   commercial license.

   See LICENSE or LICENSE_COM for more information
 =====================================================ATK4=*/
class Form_Field_Select2 extends Form_Field_ValueList {

    public $select_menu_options = array();

    function getInput($attr=array()){
        $this->select_menu_options['change']=$this->js()->trigger('change')->_enclose();
        $multi = isset($this->attr['multiple']);
        $output=$this->getTag('select',array_merge(array(
                        'name'=>$this->name . ($multi?'[]':''),
                        'data-shortname'=>$this->short_name,
                        'id'=>$this->name,
                        ),
                    $attr,
                    $this->attr)
                );

        foreach($this->getValueList() as $value=>$descr){
            // Check if a separator is not needed identified with _separator<
            $output.=
                $this->getOption($value)
                .$this->api->encodeHtmlChars($descr)
                .$this->getTag('/option');
        }
        $output.=$this->getTag('/select');
        return $output;
    }
    function getOption($value){
        $selected = false;
        if($this->value===null || $this->value===''){
            $selected = $value==='';
        } else {
            $multi = isset($this->attr['multiple']);
            if($multi)
                $selected = in_array($value , explode(",", $this->value));
            else
                $selected = $value===$this->value;
        }
        return $this->getTag('option',array(
                    'value'=>$value,
                    'selected'=>$selected
        ));
    }

    function render(){
        $this->js(true)->_load('select2.full')->_css('select2.min')->select2($this->select_menu_options);
        parent::render();
    }
}
