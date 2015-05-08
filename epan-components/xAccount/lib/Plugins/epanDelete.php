<?php

namespace xAccount;


class Plugins_epanDelete extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('epan_before_delete',array($this,'Plugins_epanDelete'));
	}

	function Plugins_epanDelete($obj, $epan){
		$models=array(
					'Model_Group',
					'Model_BalanceSheet',
					'Model_Transaction',
					'Model_Account',
					'Model_TransactionType'
				);

		foreach ($models as $m) {
			$this->add("xAccount\\".$m)->each(function($model){
				$model->forceDelete();
			});
		}
	}
}
