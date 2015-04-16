<?php

class View_Notification extends View {

	function init(){
		parent::init();

		if($_GET[$this->name]=='true'){

			$lookup_array=array(
					"xShop\\\\Order_Draft"=>array('xshop_orders','draft','xShop\Model_Order'),
					"xShop\\\\Order_Submitted"=>array('xshop_orders','submitted','xShop\Model_Order'),
					"xShop\\\\Order_Approved"=>array('xshop_orders','approved','xShop\Model_Order'),
				);

			$current_lastseen = $this->add('xCRM\Model_Activity');

			$current_lastseen->addExpression('count')->set(function($m,$q){
				return $m->add('Model_MyLastSeen')
					->addCondition('related_root_document_name',$q->getField('related_root_document_name'))
					->addCondition('seen_till','<=',$q->getField('created_at'))
					->count();

				// $query = "(";
				// $query .="CASE ". $q->getField('related_document_name');
				// foreach ($lookup_array as $doc_name => $table_n_status_n_model) {
				// 	$query .= " WHEN '$doc_name' THEN (SELECT count(*) from ". $table_n_status_n_model[0] ."  WHERE `status` ='".$table_n_status_n_model[1]."' AND updated_at > ".$q->getField('seen_till').")"; 
				// }
				// $query .= " END )";
				// return $query;

			});

			$current_lastseen->_dsql()->group('related_document_name');
			$current_lastseen->_dsql()->having('count','>',0);

			echo json_encode($current_lastseen->getRows());
			exit;
		}
	}

	function render(){
		if($_GET[$this->name]!='true'){
			$this->js(true)->_load('xnotifier')->xnotifier(array('url'=>$this->api->url(null)));
		}
		parent::render();
	}
}