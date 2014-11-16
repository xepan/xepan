<?php


class Controller_FormBeautifier extends AbstractController{
	public $param=array();
	public $form=false;

	function init(){
		parent::init();

		if(!($this->owner instanceof CRUD) and !($this->owner instanceof Form)){
			throw $this->exception('Must be added on CRUD or Form')->addMoreInfo('Current Owner',$this->owner);
		}

		if($this->owner instanceof CRUD and $this->owner->form){
			$this->form = $this->owner->form;
		}

		if($this->owner instanceof Form){
			$this->form = $this->owner;
		}

		if(!$this->form) return;
		$model_fields = $this->form->getModel();
		
		$last_group="";
		$last_form_field=null;
		$running_column=null;
		$running_cell=null;
		$order = $this->form->add('Order');

		foreach ($model_fields->elements as $position => $fld) {
			// if fld->group is same as last group and last group is not ""
			if(isset($fld->group))
				$group_details = explode("/", $fld->group);
			else
				$group_details = array();

			if(count($group_details) < 2 or !($elm=$this->form->hasElement($fld->short_name))){
				if($elm=$this->form->hasElement($fld->short_name)){
					$last_form_field=$elm;
					$elm->addClass('form-control');
				}
				continue;
			}

			// beautify field by adding bootstrap classes
			$elm->addClass('form-control');

			if($group_details[0]!= $last_group){
				$running_column = $this->form->add('Columns');
				if(!$last_form_field){
					$order->move($running_column,'first');
				}else{
					$order->move($running_column,'after',$elm->short_name);
				}
			}

			if(!isset($group_details[2])){
				$running_cell = $running_column->addColumn($group_details[1]);
				$running_cell->add($elm);
			}
			else{
				if($group_details[2] !== '0'){
					$running_cell = $running_column->addColumn($group_details[1]);
					$running_cell->addClass('panel panel-default');
					// $fieldset = $running_cell->add('View');//->setElement('fieldset');
					$running_cell->add('H4')->set($group_details[2])->addClass('panel-heading');
					$running_cell = $running_cell->add('View')->addClass('panel-body');
					$running_cell->add($elm);
				}else{
					$running_cell->add($elm);
				}
			}

			$last_group = $group_details[0];
			$last_form_field = $elm;

			// create a new columns object
			// if same as last group
			// add Column to column object and move object into it
		}

		$order->now();
		$this->form->addClass('stacked');
	}

}