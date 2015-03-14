<?php
class page_xShop_page_owner_order_approved extends page_xShop_page_owner_main{
	function init(){
		parent::init();

		$this->add('PageHelp',array('page'=>'order_approve'))->set('These Orders are approved, items JOBCARDS CREATED, waiting for their respective FIRST Departments to receive. On Any on of item received the status of Order will be "Processing"');
		$approved_order = $this->add('xShop/Model_Order_Approved');

		$dept_status = $this->add('xShop/Model_OrderItemDepartmentalStatus',array('table_alias'=>'ds'));
		$dept_status->join('xshop_orderDetails','orderitem_id')
					->join('xshop_orders','order_id');
		$dept_status->_dsql()->del('fields')
				->field($dept_status->dsql()->concat(
						$dept_status->getElement('status'),
						' in/from ',
						$dept_status->getElement('department')
					)
			);

		$dept_status->_dsql()->limit(1)->order($dept_status->getElement('id'),'desc');


		$approved_order->addExpression('last_action')->set($dept_status->_dsql())->caption('Last OrderItem Action');

		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Order'));
		$crud->setModel($approved_order);
		$crud->add('xHR/Controller_Acl');
	}
}		