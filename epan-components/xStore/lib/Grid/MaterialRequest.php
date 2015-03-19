<?php
namespace xStore;

class Grid_MaterialRequest extends \Grid{
	function init(){
		parent::init();
		$this->addQuickSearch(array('to_department','status'));
		$this->addPaginator($ipp=50);
		
	}
	function setModel($material_request_model,$fields=null){

		// if(!$fields){
		// 	$fields=array('created_by','from_department','name','forwarded_to');
		// }

		$m=parent::setModel($material_request_model,$fields);

		$vp = $this->add('VirtualPage')->set(function($p){
			$p->add('xStore/View_MaterialRequest',array('materialrequest'=>$p->add('xStore/Model_MaterialRequest')->load($_GET['material_request_clicked'])));
		});
		$this->js(true)->find('tr')->css('cursor','pointer');
		$this->on('click','tbody td:not(:has(button))',$this->js()->univ()->frameURL('Material Request',array($this->api->url($vp->getURL()),'material_request_clicked'=>$this->js()->_selectorThis()->closest('tr')->data('id'))));

		// $this->addOrder()->move('Details','last')->now();
		return $m;

	}
}