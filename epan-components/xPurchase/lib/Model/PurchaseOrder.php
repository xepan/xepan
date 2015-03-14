<?php
namespace xPurchase;

class Model_PurchaseOrder extends \Model_Document{
	public $table="xpurchase_purchase_order";
	public $status=array('draft','approved','processing','submitted','completed','reject','redesign','accepted');
	public $root_document_name='xPurchase\PurchaseOrder';
	function init(){
		parent::init();


		$this->hasOne('xPurchase/Supplier','xpurchase_supplier_id');

		$this->addField('created_at')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));		

		$this->hasMany('xPurchase/PurchaseOrderItem','po_id');

		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function itemrows(){
		return $this->ref('xPurchase/PurchaseOrderItem');
	}

	function submit(){
		$this->setStatus('submitted');
	}

	function approve(){
		//TODO SEND MAIL
			//COMMUNICATION LOG ENTRY 
		
		$this->setStatus('approved');
	}

	function reject(){
		$this->setStatus('rejected');
	}

	function redesign(){
		$this->setStatus('redesign');
	}

	function accept(){
		$this->setStatus('accepted');
	}

	function start_processing(){
		$this->setStatus('processing');
		//TODO
	}

	function setStatus($status){
		$this['status']=$status;
		$this->saveAs($this->getRootClass());
	}

	function mark_processed_page($page){

		$form = $page->add('Form_Stacked');

		// $form->addField('DropDown','to_warehouse')
		// 	->setFieldHint('TODO : Check if warehouse is outsourced make challan and receive automatically')
		// 	->setModel('xStore/Warehouse');

		$cols = $form->add('Columns');
		$sno_cols= $cols->addColumn(1);
		$item_cols= $cols->addColumn(6);
		$req_qty_cols= $cols->addColumn(2);
		$unit_cols= $cols->addColumn(1);
		$received_qty= $cols->addColumn(2);

		$i=1;
		foreach($this->itemrows() as $ir){
			$sno_cols->add('View')->set($i);
			$item_cols->addField('Readonly','item_'.$i,'Item')->set($ir['item']);
			$req_qty_cols->addField('Readonly','req_qty_'.$i,'Qty')->set($ir['qty']);
			$unit_cols->addField('Readonly','req_uit_'.$i,'Unit')->set($ir['unit']);
			$received_qty->addField('Number','received_qty_'.$i,'Received Qty')->set($ir['qty']);
			$i++;
		}

		$receive_btn = $form->addSubmit('Receive');

		if($form->isSubmitted()){
			if($form->isClicked($receive_btn)){
				
				$to_warehouse = $this->add('xStore/Model_Warehouse')->loadPurchase();
				
				try{
					$this->api->db->beginTransaction();
					$movement_challan = $to_warehouse->newPurchaseReceive($this);
					$i=1;
					foreach ($this->itemrows() as $ir) {
						$movement_challan->addItem($ir->item(),$form['received_qty_'.$i]);
						$i++;
					}

					$movement_challan->executePurchase($add_to_stock=true);

					$this->api->db->commit();
				}catch(\Exception $e){
					$this->api->db->rollback();
					// rollback
					if($e instanceof \Exception_ValidityCheck)
						$form->displayError($e->getField(), $e->getMessage());

					throw $e;
				}
			}
		}


	}
	

}		

