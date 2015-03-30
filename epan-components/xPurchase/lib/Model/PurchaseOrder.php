<?php
namespace xPurchase;

class Model_PurchaseOrder extends \Model_Document{
	public $table="xpurchase_purchase_order";
	public $status=array('draft','approved','processing','submitted','completed','rejected','redesign','accepted');
	public $root_document_name='xPurchase\PurchaseOrder';
	function init(){
		parent::init();


		$this->hasOne('xPurchase/Supplier','supplier_id')->sortable(true)->display(array('form'=>'autocomplete/Plus'));
		$this->hasOne('xShop/Priority','priority_id')->group('z~6')->mandatory(true)->defaultValue($this->add('xShop/Model_Priority')->addCondition('name','Medium')->tryLoadAny()->get('id'));
		$this->addField('name')->caption('Purchase Order');
		$this->addField('order_summary')->type('text');
		$this->addField('order_date')->type('datetime')->defaultValue($this->api->now);

		$this->addField('total_amount');
		$this->addField('tax');
		$this->addField('net_amount');

		$this->hasMany('xPurchase/PurchaseOrderItem','po_id');
		$this->hasMany('xPurchase/PurchaseInvoice','po_id');

		$this->addHook('beforeDelete',$this);

		$this->addExpression('orderitem_count')->set($this->refSQL('xPurchase/PurchaseOrderItem')->count());
		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeDelete(){
		if($this['status']=='draft')
			$this->ref('xPurchase/PurchaseOrderItem')->deleteAll();
		else
			throw $this->exception("can not be delete",'Growl');
		
	}

	function itemRows(){
		return $this->add('xPurchase/Model_PurchaseOrderItem')->addCondition('po_id',$this['id']);
	}

	function submit(){		
		$this->setStatus('submitted');
	}

	function cancle(){
		$this->setStatus('canceled');
	}

	function approve_page($page){
		$page->add('View')->set('Advanced Payment');
		$form = $page->add('Form_Stacked');
		$form->addField('DropDown','payment')->setValueList(array('cheque'=>'Bank Account/Cheque','cash'=>'Cash'))->setEmptyText('Select Payment Mode');
		$form->addField('Money','amount');
		$form->addField('line','bank_account_detail');
		$form->addField('line','cheque_no');
		$form->addField('DatePicker','cheque_date');
		$form->addSubmit('Approve & Pay Advance');
		if($form->isSubmitted()){

			if($form['payment']){
				switch ($form['payment']) {
					case 'cheque':
						if(trim($form['amount']) == "" or $form['amount'] == 0)
							$form->displayError('amount','Amount Cannot be Null');

						if(trim($form['bank_account_detail']) == "")
							$form->displayError('bank_account_detail','Account Number Cannot  be Null');

						if(trim($form['cheque_no']) =="")
							$form->displayError('cheque_no','Cheque Number not valid.');
						
						if(!$form['cheque_date'])
							$form->displayError('cheque_date','Date Canot be Empty.');

					break;

					case 'cash':
						if(trim($form['amount']) == "" or $form['amount'] == 0)
							$form->displayError('amount','Amount Cannot be Null');
					break;
				}
				
				if($form['payment'] == "cash")
					$this->cashAdvance($form['amount']);
				
				if($form['payment'] == "cheque")
					$this->bankAdvance($form['amount'],$form['cheque_no'],$form['cheque_date'],$form['bank_account_detail'],$self_bank_account=null);
				
			}
				
			$this->approve();			
			return true;
		}

	}


	function approve(){
		//TODO SEND MAIL
			//COMMUNICATION LOG ENTRY
		$this['order_date']=$this->api->now;
		
		//Change PurchaseOrderItem Stautus Waiting to Processing
		$ois = $this->itemRows();
		foreach ($ois as $oi) {
			$oi->addCondition('status','waiting')->tryLoadAny();
			if($oi->loaded()){
				$oi['status'] = "processing";
				$oi->saveAndUnload();
			}
		}

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
		parent::setStatus($status);
	}

	function mark_processed_page($page){

		$page->add('H3')->set('Items for Receive');
		// $cols = $form->add('Columns');
		// $sno_cols= $cols->addColumn(1);
		// $item_cols= $cols->addColumn(5);
		// $req_qty_cols= $cols->addColumn(2);
		// $unit_cols= $cols->addColumn(1);
		// $received_qty= $cols->addColumn(2);
		// $keep_open= $cols->addColumn(1);

		// $i=1;
		// foreach($this->itemrows() as $ir){
		// 	$sno_cols->add('View')->set($i);
		// 	$item_model = $this->add('xShop/Model_Item')->load($ir['item_id']);
		// 	$item_name_with_customField = $ir['item']." </br>".$item_model->genericRedableCustomFieldAndValue($ir['custom_fields']);
		// 	$item_cols->addField('Readonly','item_'.$i,'Item')->set($item_name_with_customField);
			
		// 	$req_qty_cols->addField('Readonly','req_qty_'.$i,'Qty')->set($ir['qty']);
		// 	$unit_cols->addField('Readonly','req_uit_'.$i,'Unit')->set($ir['unit']);
		// 	$received_qty->addField('Number','received_qty_'.$i,'Received Qty')->set($ir['qty']);
		// 	// $keep_open->addField('boolean','keep_open_'.$i,'Keep open')->set(false);
		// 	$i++;
		// }
		$ois = $this->itemRows();
		$ois->addCondition('status','processing')->tryLoadAny();
		$grid = $page->add('Grid');
		$grid->setModel($ois);

		$grid->removeColumn('custom_fields');
		$grid->removeColumn('item');
		
		$form = $page->add('Form_Stacked');
		$form->addField('line','received_via');
		$form->addField('line','delivery_docket_no','Docket No / Person name / Other Reference');
		$form->addField('text','received_narration');
		$form->addField('Checkbox','generate_purchase_invoice');
		$form->addField('DropDown','include_items')->setValueList(array('Selected'=>'Selected Only','All'=>'All Ordered Items'))->setEmptyText('Select Items Included in Invoice');
		$form->addField('DropDown','payment')->setValueList(array('cheque'=>'Bank Account/Cheque','cash'=>'Cash'))->setEmptyText('Select Payment Mode');
		$form->addField('Money','amount');
		$form->addField('line','bank_account_detail');
		$form->addField('line','cheque_no');
		$form->addField('DatePicker','cheque_date');

		$include_field = $form->addField('hidden','selected_items');

		$grid->addSelectable($include_field);

		$page->add('H3')->set('Items Received');
		$grid = $page->add('Grid');
		$grid->setModel($this->itemRows()->addCondition('status','received'),array('dispatch_request','item_with_qty_fields','qty','unit','custom_fields','item'));
		// $form->addField('DropDown','to_warehouse')
		// 	->setFieldHint('TODO : Check if warehouse is outsourced make challan and receive automatically')
		// 	->setModel('xStore/Warehouse');


		$receive_btn = $form->addSubmit('Receive and Pay');

		if($form->isSubmitted()){
			if(!$form['selected_items'])
				throw $this->Exception('No Item Selected'.$form['selected_items'],'Growl');
				
			$items_selected = json_decode($form['selected_items'],true);
			// TODO : A LOT OF CHECKINGS REGARDING INVOICE ETC ...
			
			//CHECK FOR GENERATE INVOICE
			if($form['generate_purchase_invoice']){
				if($form['include_items'] == "")
					$form->displayError('include_items','Please Select');
					

				if($form['payment']){
					switch ($form['payment']) {
						case 'cheque':
							if(trim($form['amount']) == "" or $form['amount']==0)
								$form->displayError('amount','Amount Cannot be Null');

							if(trim($form['bank_account_detail']) == "")
								$form->displayError('bank_account_detail','Account Number Cannot  be Null');

							if(trim($form['cheque_no']) =="")
								$form->displayError('cheque_no','Cheque Number not valid.');

							if(!$form['cheque_date'])
								$form->displayError('cheque_date','Date Canot be Empty.');

						break;
						case 'cash':
							if(trim($form['amount']) == "" or $form['amount']==0)
								$form->displayError('amount','Amount Cannot be Null');
						break;
					}
				}

				$count = $this->itemRows()->addCondition('status','received')->count()->getOne();
				if( $count and $form['include_items'] =="All"){
					$form->displayError('include_items',$count.' item\'s already in invoice, select selected option ' );
				}

				//GENERATE INVOICE FOR SELECTED ITEMS
				$purchase_invoice = null;
				if($form['include_items'] == "Selected"){
					$purchase_invoice = $this->createInvoice($status='Approved',$purchaseLedger=null, $items_selected);
				}
				
				//GENERATE INVOOICE FOR ALL ORDERD ITEMS
				if($form['include_items'] == "All"){
					$purchase_invoice = $this->createInvoice();
				}

				if($form['payment'] == "cash")
					$purchase_invoice->payViaCash($form['amount']);
				
				if($form['payment'] == "cheque")
					$purchase_invoice->payViaCheque($form['amount'],$form['cheque_no'],$form['cheque_date'],$form['bank_account_no'],$self_bank_account);

				//WAREHOUSE ENTRY
				$to_warehouse = $this->add('xStore/Model_Warehouse')->loadPurchase();
				
				$movement_challan = $to_warehouse->newPurchaseReceive($this);
				$i=1;
				foreach ($this->itemRows() as $ir) {
					$movement_challan->addItem($ir->item(),$ir['qty'],$ir['unit'],$ir['custom_fields']);
					$i++;
				}

				$movement_challan->executePurchase($add_to_stock=true);

				//change the status of item to received
				foreach ($this->itemRows() as $ir) {
					$ir->setStatus('received');
				}

				if($form['include_items'] == "All"){
					$this->setStatus('completed');
				}
				if($form['include_items'] == 'selected'){
					if($this->itemRows()->addCondition('status','processing')->count()->getOne() == 0)
						$this->setStatus('completed');
					else	
						$this->setStatus('processing');
				}

				return true;
			}	

		}


	}

	function supplier(){
		return $this->ref('supplier_id');
	}

	function purchaseOrderItems(){
		return $this->ref('xPurchase/PurchaseOrderItem');
	}

	function createInvoice($status='draft',$purchaseLedger=null, $items_array=array()){
		try{
			$this->api->db->beginTransaction();
			$invoice = $this->add('xPurchase/Model_Invoice_Draft');

			$invoice['po_id'] = $this['id'];
			$invoice['supplier_id'] = $this->supplier()->get('id');
			$invoice['total_amount'] = $this['total_amount'];
			$invoice['tax'] = $this['tax'];
			$invoice['net_amount'] = $this['net_amount'];

			$invoice->relatedDocument($this);

			$invoice->save();
			

			$ois = $this->purchaseOrderItems();
			foreach ($ois as $oi) {
				
				if(!count($items_array) or !in_array($oi->id, $items_array) ) continue;
				
				if($oi->invoice())
					throw $this->exception('Order Item already used in Invoice','ValidityCheck');

				$invoice->addItem(
						$oi->item(),
						$oi['qty'],
						$oi['rate'],
						$oi['amount'],
						$oi['unit'],
						$oi['narration'],
						$oi['custom_fields']
					);					
			}

			if($status !== 'draft' and $status !== 'submitted'){
				$invoice->createVoucher($salesLedger);
			}
			
			$this->api->db->commit();
			return $invoice;
		}catch(\Exception $e){
			echo $e->getmessage();
			$this->api->db->rollback();
			if($this->api->getConfig('developer_mode',false))
				throw $e;
		}
	}
	

	function cashAdvance($cash_amount, $cash_account=null){

		if(!$cash_account) $cash_account = $this->add('xAccount/Model_Account')->loadDefaultCashAccount();

		$transaction = $this->add('xAccount/Model_Transaction');
		$transaction->createNewTransaction('PURCHASE ORDER ADVANCE CASH PAYMENT GIVEN', $this, $transaction_date=$this->api->now, $Narration=null);
		
		$transaction->addCreditAccount($cash_account,$cash_amount);
		$transaction->addDebitAccount($this->supplier()->account() ,$cash_amount);
		

		$transaction->execute();
	}

	function bankAdvance($amount, $cheque_no,$cheque_date,$bank_account_detail, $self_bank_account=null){
		if(!$self_bank_account) $self_bank_account = $this->add('xAccount/Model_Account')->loadDefaultBankAccount();

		$transaction = $this->add('xAccount/Model_Transaction');
		$transaction->createNewTransaction('PURCHASE ORDER ADVANCE BANK PAYMENT GIVEN', $this, $transaction_date=$this->api->now, $Narration=null);
		
		$transaction->addDebitAccount($this->supplier()->account(),$amount);
		$transaction->addCreditAccount($self_bank_account ,$amount);
		
		$transaction->execute();
	}	
}

