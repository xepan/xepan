<?php

namespace xShop;

class Model_Specification extends \Model_Table{
	public $table='xshop_specifications';

	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		$this->hasOne('xShop/Application','application_id');

		$f = $this->addField('name')->mandatory(true)->group('a~6~<i class=\'fa fa-cog\'> Item Custom Fields</i>')->mandatory(true);
		$f->icon = 'fa fa-circle~blue';
		$this->addField('order')->type('Number')->group('a~6')->hint('show in asceding order');
			
		$this->hasMany('xShop/ItemSpecificationAssociation','specification_id');
		
		$this->addField('is_filterable')->type('boolean');
	
		$this->addHook('beforeDelete',$this);
		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeDelete($m){
		if($m->ref('xShop/ItemSpecificationAssociation')->count()->getOne())
			throw $this->exception('Cannot Delete, First Delete Item Specification Value');

	}

	function forceDelete(){
		$this->ref('xShop/ItemSpecificationAssociation')->each(function($m){
			$m->forceDelete();
		});

		$this->delete();
	}


}

