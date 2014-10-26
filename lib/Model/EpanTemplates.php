<?php

class Model_EpanTemplates extends Model_Table {
	var $table= "epan_templates";
	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		$this->addField('body_attributes')->type('text');
		$this->addField('name')->defaultValue('Default');
		$this->addField('content')->type('text')->defaultValue('<div component_namespace="baseElements" component_type="TemplateContentRegion" class="epan-sortable-component epan-component  ui-sortable" style="" contenteditable="false">{{Content}}</div>');
		$this->addField('css')->type('text');
		$this->addField('is_current')->type('boolean')->defaultValue(false);
		$this->hasMany('EpanPage','template_id');
		

		// $this->addCondition('epan_id',$this->api->current_website->id);


		// $this->add('dynamic_model/Controller_AutoCreator');
	}
}