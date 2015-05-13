<?php

namespace xShop;


class Plugins_epanCreated extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('epan_after_created',array($this,'Plugins_epanCreated'));
	}

	function Plugins_epanCreated($obj, $epan){
		$app = $this->add('xShop/Model_Application');
		$app['name']='Default xShop Application';
		$app['type']='Shop';
		$app->save();

		$d=$this->add('xShop/Model_Configuration');
		$d->loadDefaults($app);

		$priorities=array('Low','Medium','High','Urgent');
		foreach ($priorities as $pr) {
			$this->add('xShop/Model_Priority')->set('name',$pr)->save();
		}
	}
}
