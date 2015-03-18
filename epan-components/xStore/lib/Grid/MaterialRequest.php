<?php
namespace xStore;

class Grid_MaterialRequest extends \Grid{

	function setModel($material_request_model,$fields=null){

		// if(!$fields){
		// 	$fields=array('created_by','from_department','name','forwarded_to');
		// }

		$m=parent::setModel($material_request_model,$fields);

		$this->add('VirtualPage')->addColumn('Details','Details','Details',$this)->set(function($p){
			$p->add('xStore/View_MaterialRequest',array('materialrequest'=>$this->add('xStore/Model_MaterialRequest')->load($p->id)));
		});

		$this->addOrder()->move('Details','last')->now();
		return $m;
	}
}