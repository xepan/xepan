<?php
class page_xAccount_page_owner_ledgers extends page_xAccount_page_owner_main{
	
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Ledgers/Groups';

		$group = $this->add('xAccount/Model_Account');
		$crud = $this->add('CRUD');
		$crud->setModel($group,array('name','group_id','OpeningBalanceCr','OpeningBalanceDr'),array('name','group','CurrentBalanceCr','CurrentBalanceDr','OpeningBalanceCr','OpeningBalanceDr'));

		if(!$crud->isEditing()){
			$crud->grid->addMethod('format_balance',function($g,$f){
				$m=$g->model;

				$fig = ($m['OpeningBalanceDr'] + $m['CurrentBalanceDr'])-($m['OpeningBalanceCr'] + $m['CurrentBalanceCr']);
				
				if($fig < 0)
					$g->current_row_html[$f] = '<div class="pull-left">'.abs($fig) . '</div><div class="pull-right">Dr</div>';
				else
					$g->current_row_html[$f] = '<div class="pull-left">'.abs($fig) . '</div><div class="pull-right">Cr</div>';
			});

			$crud->grid->addColumn('balance','balance');
			$crud->grid->add_sno();
			$crud->grid->removeColumn('CurrentBalanceDr');
			$crud->grid->removeColumn('CurrentBalanceCr');
			$crud->grid->removeColumn('OpeningBalanceCr');
			$crud->grid->removeColumn('OpeningBalanceDr');
		}
	}
}