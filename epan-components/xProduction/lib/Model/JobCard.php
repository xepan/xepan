<?php

namespace xProduction;

class Model_JobCard extends \Model_Document{
	public $table ="xproduction_jobcard";
	public $status=array('draft','submitted','approved','received','assigned','processing','processed','forwarded','completed','canceled');
	public $root_document_name = 'xProduction\JobCard';

	function init(){
		parent::init();
		// hasOne OrderItemDepartment Association id
		$this->hasOne('xShop/OrderDetails','orderitem_id');
		$this->hasOne('xHR/Department','to_department_id');
		$this->hasOne('xHR/Department','from_department_id');
		$this->hasOne('xStore/Warehouse','dispatch_to_warehouse_id');
		$this->hasOne('xShop/OrderItemDepartmentalStatus','orderitem_departmental_status_id');
		
		$this->addField('type')->enum(array('JobCard','MaterialRequest','DispatchRequest'))->defaultValue('JobCard');

		$this->addField('name')->caption('Job Number');
		$this->getElement('status')->defaultValue('submitted');
		
		$this->addExpression('outsource_party')->set(function($m,$q){
			$p = $m->add('xProduction/Model_OutSourceParty');
			$j=$p->join('xshop_orderitem_departmental_status.outsource_party_id');
			$j->addField('order_item_dept_status_id','id');
			$p->addCondition('order_item_dept_status_id',$q->getField('orderitem_departmental_status_id'));
			return $p->fieldQuery('name');
		});

		$this->hasMany('xProduction/JobCardEmployeeTeamAssociation','jobcard_id');
		$this->hasMany('xStore/Model_StockMovement','jobcard_id');


		$this->add('Controller_Validator');
		$this->is(array(
							// 'name|to_trim|required',
							)
					);

		$this->addHook('beforeInsert',$this);

		// $this->add('dynamic_model/Controller_AutoCreator');

	}

	function beforeInsert($obj){
		$this['name'] = rand(1000,9999);
	}

	function createFromOrder($order_item, $order_dept_status ){
		$new_job_card = $this;

		$new_job_card->addCondition('orderitem_departmental_status_id',$order_dept_status->id);
		$new_job_card->tryLoadAny();

		if($new_job_card->loaded())
			return false;
		
		$new_job_card['orderitem_id'] = $order_item->id;
		$new_job_card['to_department_id'] = $order_dept_status['department_id'];
		
		$sales_dept = $this->add('xHR/Model_Department')->loadBy('related_application_namespace','xShop');
		$new_job_card['from_department_id'] = $sales_dept->id;

		$new_job_card['name']=rand(1000,9999);
		$new_job_card['status']='approved';
		$new_job_card->save();

	}

	function previousDeptJobCard(){
		
		if($cf = $this->orderItem()->get('custom_fields')){
			$custom_fields = json_decode($cf,true);
		}else{
			$custom_fields = array();
		}

		$prev_dept_id = null;
		foreach ($custom_fields as $dept_id => $custom_field_values ) {
			if($this->department()->get('id') == $dept_id) break;
			$prev_dept_id = $dept_id;
		}
		if($prev_dept_id){
			$pre_dept_job_card = $this->add('xProduction/Model_JobCard');
			$pre_dept_job_card->addCondition('orderitem_id',$this['orderitem_id']);
			$pre_dept_job_card->addCondition('to_department_id',$prev_dept_id);
			$pre_dept_job_card->tryLoadAny();

			if($pre_dept_job_card->loaded()) return $pre_dept_job_card;
		}
		
		return false;
	}
	
	function fromDepartment(){
		return $this->ref('from_department_id');
	}

	function department(){
		return $this->toDepartment();
	}

	function toDepartment(){
		return $this->ref('to_department_id');
	}

	function orderItem(){
		if(!$this['orderitem_id']){
			return false;
		}
		return $this->ref('orderitem_id');
	}

	function isCreatedFromOrder(){
		return $this['orderitem_id'];
	}

	function departmentalStatus(){
		return $this->ref('orderitem_departmental_status_id');
	}

	function outSourceParty($party=null){
		$t= $this->departmentalStatus();
		return $t->outSourceParty($party);
	}

	function removeOutSourceParty(){
		$t = $this->departmentalStatus();
		$t['outsource_party_id'] = 0;
		$t->save();
	}

	function create($from_department, $to_department, $related_document=false, $order_item=false, $items_array=array(), $dispatch_to_warehouse=false, $status=false){
		$this['from_department_id'] = $from_department->id;
		$this['to_department_id'] = $to_department->id;

		if($related_document){
			$this->relatedDocument($related_document);
		}

		if($order_item){
			$this['orderitem_id'] = $order_item->id;
			$this['orderitem_departmental_status_id'] = $order_item->deptartmentalStatus($to_department)->get('id');
		}

		if($dispatch_to_warehouse){
			$this['dispatch_to_warehouse_id'] = $dispatch_to_warehouse->id;
		}else{
			$this['dispatch_to_warehouse_id'] = $from_department->warehouse()->get('id');
		}

		if($status)
			$this['status'] = $status;

		$this->save();

		foreach ($items_array as $item) {
			$this->addItem($this->add('xShop/Model_Item')->load($item['id']),$item['qty'],$item['unit']);
		}
		return $this;
	}

	function submit(){
		$this->setStatus('submitted');
	}

	function receive_page($page){

		$form = $page->add('Form_Stacked');

		if($this->department()->getAssociatedOutsourceParty() !== array(0)){

			$field = $form->addField('DropDown','select_outsource_party');
			$field->setModel($this->department()->associatedOutsourceParties());
			
			if($this->department()->isOutSourced()){
				$field->setEmptyText('Please Select Out Source Party');
				$field->validateNotNull("This is completely outsource department. Out source Party is must");
			}else{
				$field->setEmptyText('In House Development');
			}
		}

		$gmr = $form->addField('Checkbox','generate_material_request');

		$cols = $form->add('Columns');
		$l_c= $cols->addColumn(6);
		$r_c= $cols->addColumn(6);

		$request_type = $l_c->addField('DropDown','request_type')->setValueList(array('purchase'=>'Purchase','transfer'=>'Transfer'));
		$request_to = $r_c->addField('DropDown','request_to')->setEmptyText('Not Applicable (Only select if Request Type is Transfer)');
		$request_to->setModel('xStore/Warehouse');


		$ti=$form->add('CRUD'); //Temp_items
		$tm = $form->add('xStore/Model_TempItems');
		$ti->setModel($tm);

		$dtpw = $form->addField('Checkbox','dispatch_directly','Dispatch Direclty (If Purchase Request)');
		
		// $gmr->js(true)->univ()->bindConditionalShow(array(
		// 		''=>array(),
		// 		'*'=>array('dispatch_to_party_wherehouse','request_type','transfer_from',$ti)
		// 	),'div.atk-form-row');

		$form->add('HR');
		$form->addSubmit('Receive');

		if($form->isSubmitted()){

			// A bunch of validations TODO 

			if($form->hasElement('select_outsource_party') AND $form['select_outsource_party']){
				$this->outSourceParty($this->add('xProduction/Model_OutSourceParty')->load($form['select_outsource_party']));
			}

			if($form['generate_material_request']){
				$items_array=array();
				foreach ($tm as $id => $item) {
					$items_array[] = array('id'=>$item['item_id'],'qty'=>$item['qty'],'unit'=>$item['unit']);
				}

				$to_department = $this->add('xHR/Model_Department');
				if($form['request_type']=='purchase')
					$to_department->loadPurchase();
				else{
					$to_warehouse = $this->add('xStore/Model_Warehouse')->load($form['request_to']);
					$to_department->load($to_warehouse['department_id']);
				}

				if($form['request_type']=='purchase'){
					$dispatch_to = $this->department()->warehouse();
					if($form['dispatch_directly']){
						if($form->hasElement('select_outsource_party') AND $form['select_outsource_party']){
							$dispatch_to = $this->add('xProduction/Model_OutSourceParty')->load($form['select_outsource_party'])->warehouse();
						}
					}
				}else{
					$dispatch_to=false;
				}

				$mr_m = $this->add('xStore/Model_MaterialRequest');
				$mr_m->create($this->department(),$to_department,$items_array,array(),$this->orderItem(),$dispatch_to);

			}

			$this->receive();
			return true;
		}
	}

	function receive(){
		// mark complete previous dept jobcard
		if($pre_dept_job_card = $this->previousDeptJobCard()){
			$pre_dept_job_card->complete();
		}

		$this['created_by_id']=$this->api->current_employee->id;
		// self status received
		if($this->department()->isOutSourced()){
			if(!$this->outSourceParty())
				throw $this->exception('Define OutSource Party First');
			else{
				$this->setStatus('processing');
			}
		}else{
			$this->setStatus('received');
		}

	}

	function complete(){
		$this->setStatus('completed');
	}

	function approve(){
		$rt = $this->relatedTask();
		if($rt->loaded())
			$rt->set('status','complete')->save();

		$this->setStatus('approved');
		
	}

	function forward(){
		if($next = $this->orderItem()->nextDeptStatus()){
			if($next->department()->isDispatch()){
				$oi=$this->orderItem();
				$items_array=array(array('id'=>$oi->item()->get('id'),$oi['qty'],$oi['unit']));

				$this->add('xStore/Model_MaterialRequest')
					->create(
						$from_department=$this->add('xHR/Model_Department')->loadDispatch(),
						$to_department=$this->department(), 
						$related_document=$this, 
						$order_item=$this->orderItem(), 
						$items_array, 
						$dispatch_to_warehouse=false,
						'approved'
						);

			}
			$next->createJobCardFromOrder();
			$this->setStatus('forwarded');
		}else{
			$this->setStatus('completed');
		}
	}

	function start_processing(){
		$this->setStatus('processing');
	}

	function mark_processed_page($p){
		$oi= $this->orderItem();
		
		if($oi){
			$p->add('View_Info')->set('Mark Consuption If Required First');

			$item = $oi->item();
			$with_this_dept = $item->departmentalAssociations($this->department());

			$m = $this->add('xStore/Model_StockMovement_Draft');
			$m->addCondition('type','ProductionConsume');
			$m->addCondition('jobcard_id',$this->id);

			if($osp=$this->outSourceParty()){
				if($osp->warehouse())
					$from_warehouse_id = $osp->warehouse()->get('id');
			}
			else{
				$from_warehouse_id = $this->department()->warehouse()->get('id');
			}

			$m->addCondition('from_warehouse_id',$from_warehouse_id);
			$m->tryLoadAny();
			if(!$m->loaded()){
				$m->save();
				foreach ($c=$item->composition($this->department()) as $comp) {
					$m->addItem($comp->item(),$comp['qty'],$comp['unit']);
				}
			}
			
			$movement_items = $m->ref('xStore/StockMovementItem');

			$crud_permissions=array('allow_add'=>false,'allow_edit'=>false,'allow_del'=>false);

			if($with_this_dept->canRedefineItems()){
				$crud_permissions['allow_add']=true;
				$crud_permissions['allow_del']=true;
			}else{
				$movement_items->getElement('item_id')->display(array('form'=>'Readonly'));
			}

			if($with_this_dept->canRedefineQty()){
				$crud_permissions['allow_edit']=true;
			}

			$crud = $p->add('CRUD',$crud_permissions);
			$crud->setModel($movement_items);
			
			if(!$crud->isEditing() and $crud->add_button)
				$crud->add_button->set('Add Consuption Item');

			$p->add('HR');

			$form = $p->add('Form');
			$form->addSubmit('Consume Stock & Mark Processed');

			if($form->isSubmitted()){
				$m->executeConsume();
				$this->setStatus('processed');
				return true;
			}	
		}else{
				$this->setStatus('processed');
				return true;
		}
	}

	function setStatus($status){
		if($this['orderitem_id']){
			$ds = $this->orderItem()->deptartmentalStatus($this->department());
			$ds->setStatus(ucwords($status) .' in ' . $this->department()->get('name'));
			$this->orderItem()->order()->setStatus('processing');
		}
		$this['status']=$status;
		$this->saveAs($this->getRootClass());
	}

}	