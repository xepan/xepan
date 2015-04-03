<?php
class page_xPurchase_page_owner_supplier extends page_xPurchase_page_owner_main {
	function init(){
		parent::init();

		$this->vp = $this->add('VirtualPage')->set(function($p){
			$this->api->StickyGET('supplier_id');
			$grid = $p->add('xPurchase/Grid_PurchaseOrder');
			$po = $p->add('xPurchase/Model_PurchaseOrder')->addCondition('supplier_id',$_GET['supplier_id']);
			$grid->setModel($po,array('name','order_date'));
		});


		$this->app->title=$this->api->current_department['name'] .': Supplier';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Supplier Manager <small> Manage your supplier </small>');

		$crud=$this->add('CRUD');
		$crud->setModel('xPurchase/Model_Supplier',array('name','owner_name','city','contact_person_name',
														'accounts_person_name','code','address','state',
														'pin_code','fax_number','contact_no','email','tin_no','pan_no','is_active'
														),array('name','owner_name','city','email','contact_no','is_active'));
		
		$crud->grid->addQuickSearch(array('name','code','city','state','pin_code','email','contact_no','created_at'));
		$crud->grid->addPaginator($ipp=50);
		$crud->add('xHR/Controller_Acl');
		$crud->grid->add_sno();
		// $purchase_order = $this->add('xPurchase/Model_PurchaseOrder');
		if(!$crud->isEditing()){
			$g=$crud->grid;	
			$g->addColumn('total_purchase_order');
			$g->addMethod('format_total_purchase_order',function($g,$f){
				$g->current_row_html[$f] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Purchase Order List ', $this->api->url($this->vp->getURL(),array('supplier_id'=>$g->model['id']))).'">'. $g->model->ref('xPurchase/PurchaseOrder')->count()->getOne()."</a>";
			});
			$g->addFormatter('total_purchase_order','total_purchase_order');
		}

	}
}