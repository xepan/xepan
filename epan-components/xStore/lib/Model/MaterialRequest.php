<?php
namespace xStore;

class Model_MaterialRequest extends \Model_Document {
	
	public $table = 'xstore_material_request';

	public $root_document_name='xStore\MaterialRequest';
	public $status = array('draft','submitted','approved','processing','processed','shipping',
							'complete','cancel','return');

	function init(){
		parent::init();

		$this->addField('related_document_id');
		$this->addField('related_root_document_name');
		$this->addField('related_document_name');

		$this->hasOne('xHR/Department','from_department_id');
		$this->hasOne('xShop/Order','order_id');

		$this->getElement('status')->defaultValue('submitted');

		$this->hasMany('xStore/MaterialRequestItem','material_request_id');
		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function createFromOrder($order_item, $order_dept_status ){
		$new_request = $this->add('xStore/Model_MaterialRequest');
		$new_request->addCondition('order_id',$order_item['order_id']);
		$new_request->tryLoadAny();

		$sales_dept = $this->add('xHR/Model_Department')->loadBy('related_application_namespace','xShop');
		$new_request['from_department_id'] = $sales_dept->id;
		$new_request['name']=rand(1000,9999);

		$order= $order_item->ref('order_id');

		$new_request['related_document_id'] = $order_item['order_id'];
		$new_request['related_root_document_name'] = $order->root_document_name;
		$new_request['related_document_name'] = $order->document_name;


		if(!$new_request->loaded()) $new_request->save();

		$new_request->addItem($order_item->ref('item_id'),$order_item['qty']);

	}

	function addItem($item,$qty){
		$mr_item = $this->ref('xStore/MaterialRequestItem');
		$mr_item['item_id'] = $item->id;
		$mr_item['qty'] = $qty;
		$mr_item->save();
	}

	
}		
