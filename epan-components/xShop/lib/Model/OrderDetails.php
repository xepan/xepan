<?php

namespace xShop;

class Model_OrderDetails extends \Model_Document{
	public $table='xshop_orderdetails';

	public $status=array();
	public $root_document_name = 'xShop\OrderDetails';
	public $actions=array(
			//'can_view'=>array('caption'=>'Whose created Quotation(draft) this post can see'),
			'allow_edit'=>array('caption'=>'Whose created Quotation this post can edit'),
			'allow_add'=>array('caption'=>'Can this post create new Quotation'),
			'allow_del'=>array('caption'=>'Whose Created Quotation this post can delete'),
			'forceDelete'=>array(),
		);

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		$this->hasOne('xShop/Order','order_id');
		$this->hasOne('xShop/Item_Saleable','item_id')->display(array('form'=>'autocomplete/Basic'));//->group('a~6~Item Select');
		$this->hasOne('xShop/Invoice','invoice_id')->display(array('form'=>'autocomplete/Basic'));//->group('a~6~Item Select');
		$this->hasOne('xShop/Tax','tax_id');

		$this->addField('rate')->type('money')->group('b~3');
		$this->addField('qty')->group('b~3~Order Details')->mandatory(true);
		// $this->addField('unit')->group('b~3');
		$this->addField('amount')->type('money')->group('b~3');
		$this->addField('narration')->type('text')->system(false);
		$this->addField('custom_fields')->type('text')->system(false);
		$this->addField('apply_tax')->type('boolean')->defaultValue(true);

		$this->addExpression('name')->set(function($m,$q){
			return $m->refSQL('item_id')->fieldQuery('name');
		});

		$this->addExpression('tax_per_sum')->set(function($m,$q){
			$tax_assos = $m->add('xShop/Model_ItemTaxAssociation');
			$tax_assos->addCondition('item_id',$q->getField('item_id'));
			if($q->getField('tax_id'))
				$tax_assos->addCondition('tax_id',$q->getField('tax_id'));
			$tax = $tax_assos->sum('name');

				return "IF(".$q->getField('apply_tax').">0,(".$tax->render()."),'0')";
		})->type('money')->caption('Total Tax %');

		$this->addExpression('tax_amount')->set(function($m,$q){
			$tpa = $m->add('xShop/Model_OrderDetails',array('table_alias'=>'tps'));
			$tpa->addCondition('id',$q->getField('id'));

			return "((".$q->getField('amount').") * ( IFNULL((". $tpa->_dsql()->del('fields')->field('tax_per_sum')->render()."),0) ) / 100)";
		})->type('money');

		$this->addExpression('texted_amount')->set(function($m,$q){
			$tpa = $m->add('xShop/Model_OrderDetails',array('table_alias'=>'txdamt'));
			$tpa->addCondition('id',$q->getField('id'));

			return "((".$q->getField('amount').") + ( IFNULL((". $tpa->_dsql()->del('fields')->field('tax_amount')->render()."),0) ))";
		})->type('money');


		$this->addExpression('created_by_id')->set(function($m,$q){
			return $m->refSQL('order_id')->fieldQuery('created_by_id');
		});

		$this->addExpression('unit')->set(function($m,$q){
			return $m->refSQL('item_id')->fieldQuery('qty_unit');
		});

		$this->addExpression('item_with_qty_fields','custom_fields');

		$this->hasMany('xShop/OrderItemDepartmentalStatus','orderitem_id');
		$this->hasMany('xShop/SalesOrderDetailAttachment','related_document_id',null,'Attachements');
		$this->hasMany('xProduction/Jobcard','orderitem_id');
		$this->hasMany('xStore/MaterialRequest','orderitem_id');

		$this->addHook('beforeSave',$this);
		$this->addHook('afterSave',$this);
		$this->addHook('afterInsert',$this);
		$this->addHook('beforeDelete',$this);
		// $this->addHook('afterLoad',$this);

		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeSave(){
		//Check for the apply tax
				
		if( $this->dirty['apply_tax'] or $this->dirty['tax_id']){
			if($this['apply_tax'] and ($tax_asso = $this->item()->applyTaxs())){

				$tax_asso->addCondition('tax_id',$this['tax_id']);
				if(!$tax_asso->count()->getOne())
					throw $this->exception('Tax Not Applied','ValidityCheck')->setField('tax_id');
			}

		}

		$forwarded_jobcard = false;
		if($this->dirty['invoice_id'] and $this['invoice_id'])
			return;
		
		//CHECK FOR THE ORDER IS UNDER PROCESSING/COMPLETE
		if(in_array($this->order()->get('status'), array('draft','submitted','redesign')))
			return ;

		if($this->loaded() AND $this->dirty['custom_fields']){
			//CHECK FOR NEW/UPDATE DEPARTMENT YES
			if(count($new_department = $this->getNewDepartment())){
				//$ND = GET NEW DEPARTMENT ID AND LEVEL
				//$LC_J = GET LAST JOBCARD COMPLETED IN DEPARTMENT LEVEL
				$jbs = $this->jobCards();
				foreach ($jbs as $jb) {
					if($jb['status']=="completed" or $jb['status'] == "forwarded"){
						if($jb['status'] == "forwarded")
							$forwarded_jobcard = $jb->toDepartment();

						$dept_jobcard_complete = $this->add('xHR/Model_Department')->tryLoad($jb['to_department_id']);
						if($dept_jobcard_complete->loaded()){
							foreach ($new_department as $dept) {
								if($dept_jobcard_complete['production_level'] > $dept[1])
									throw new \Exception("Cannot Add New Previous Department, First Delete it's JobCard");
							}
						}

					}
				}
			}
			
			//remove not completed jobcard
			$this->removeUncompletedJobcard();
			$this->reDepartmentAssociation($forwarded_jobcard);
		}
	}

	function removeUncompletedJobcard(){
		$dept_status_all = $this->deptartmentalStatus();

		foreach ($dept_status_all as $dept_status) {
			$dept_status_dept=$dept_status->department();
			$jc = $this->add($dept_status_dept->defaultDocument());
			$jc->addCondition('orderitem_id',$this['id']);
			$jc->addCondition('to_department_id',$dept_status_dept->id);
			$jc->tryLoadAny();
			if($jc->loaded() and !in_array($jc['status'], array("completed","forwarded")) ){
				$jc->delete();
				$dept_status['status'] = 'Waiting';
				$dept_status->save();
			}

		}
	}

	function isDepartmentCustomValueUpdate(){
		if($this->dirty['custom_fields']){

			return true;
		}
		
		return false;
	}
	
	function isDepartmentJobcardComplete($department_id){
		if(!$department_id) return false;

	}

	function getNewDepartment(){//RETURN NEW DEPARTMENT ARRAY
		$old_model = $this->add('xShop/Model_OrderDetails')->load($this->id);
		$old_cfs = json_decode($old_model['custom_fields'],true);
		$old_department = "";
		foreach ($old_cfs as $department_id=>$cfs) {
			if($department_id != "stockeffectcustomfield")
				$old_department[$department_id] =$department_id;
		}

		
		$new_departments = array();
		if($this->dirty['custom_fields']){
			$dirty_cfs = json_decode($this['custom_fields'],true);
			foreach ($dirty_cfs as $department=>$dcfs) {
				if($department != "stockeffectcustomfield" and !in_array($department, $old_department)){
					$dept_model = $this->add('xHR/Model_Department')->load($department);
					$new_departments[] = array($department,$dept_model['production_level']);
				}
			}
			return $new_departments;
		}

		return $new_departments;
	}
	
	function reDepartmentAssociation($create_jobcard_after_dept = false){
		$this->createDepartmentalAssociations();
		if($department_association = $this->nextDeptStatus($create_jobcard_after_dept)){
			$department_association->createJobCardFromOrder();
			
		}
	}

	function afterSave(){
		$order = $this->order();
		$order->updateAmounts();
	}

	function beforeDelete(){
		$jc = $this->ref('xProduction/Jobcard')->count()->getOne();
		if($jc)
			throw $this->exception('Cannot Delete, First Delete Jobcrads');
		
		$this->ref('xShop/OrderItemDepartmentalStatus')->each(function($m){
			$m->forceDelete();
		});
	}

	function deliveryNoteItems(){
		return $this->add('xDispatch/Model_DeliveryNoteItem')->addCondition('orderitem_id',$this->id)->tryLoadAny();

	}

	function dispatchRequestItems(){
		return $this->add('xDispatch/Model_DispatchRequestItem')->addCondition('orderitem_id',$this->id)->tryLoadAny();
	}

	function jobCards($department_id=null){
		$job_cards=array();
		$dept_status_all = $this->deptartmentalStatus();						
		if($department_id)
			$dept_status_all->addCondition('department_id',$department_id);

		foreach ($dept_status_all as $dept_status) {
			if($dept_status->jobCardNotCreated()) continue;
			$dept_status_dept=$dept_status->department();
			$jc = $this->add($dept_status_dept->defaultDocument());
			$jc->addCondition('orderitem_id',$this['id']);
			$jc->addCondition('to_department_id',$dept_status_dept->id);
			$jc->tryLoadAny();
			if($jc->loaded())
				$job_cards[] = $jc;
		}

		if($department_id){
			if(isset($jc))			
				return $jc;
			else
				return new \Dummy();
		}

		return $job_cards;


		// if($this->loaded())
		// 	$item_id = $this->id;
		// $jobCards = $this->add('xProduction/Model_JobCard')->addCondition('orderitem_id',$item_id);
		// if($department_id)
		// 	$jobCards->addCondition('to_department_id',$department_id);
		
		// $jobCards->tryLoadAny();
		// return $jobCards;
	}


	function afterInsert($obj,$new_id){

		//Add Item At Middle of Order Processing
		$new_order_item = $this->add('xShop/Model_OrderDetails')->load($new_id);
		$order = $new_order_item->order();
		if(in_array($order->get('status'), array('approved','processing','processed','redesign')) ){
			$new_order_item->createDepartmentalAssociations();
			if($department_association = $new_order_item->nextDeptStatus()){
				$department_association->createJobCardFromOrder();
			}			
		}

		if($order['status'] == "processed"){
			$order->setStatus('processing','Due to New OrdreItem ( '.$new_order_item['name']." ) Add");
		}
		//End of Jobcrad Creation at Middle======================================================

		// For online orders that are already approved and create their departmental associations
		if($new_order_item->order()->isFromOnline()){
			$new_order_item->createDepartmentalAssociations();
		}

		if($department_association = $new_order_item->nextDeptStatus()){
				$department_association->createJobCardFromOrder();
		}
		// else .. form_orderItem is doing for offline orders
	}

	function createDepartmentalAssociations(){
		$depts = $this->add('xHR/Model_Department');
			
		if($this['custom_fields']==''){
			$assos_depts = $this->item()->getAssociatedDepartment();
			foreach ($assos_depts as $dp) {
				$custome_fields_array[$dp]=array();
			}
		}else{
			$custome_fields_array  = json_decode($this['custom_fields'],true);
		}

		foreach ($depts as $dept) {
			if(isset($custome_fields_array[$dept->id])){
				// associate with department
				$this->addToDepartment($dept);
			}else{
				// remove association with department
				if($this->getCurrentStatus($dept) != 'Waiting')
					$this->removeFromDepartment($dept);
				// else
					// throw $this->exception('Job Has Been forwarded to department '. $dept['name'].' and cannot be removed');
			}
		}
	}

	function associatedWithDepartment($department){
		$relation = $this->ref('xShop/OrderItemDepartmentalStatus')->addCondition('department_id',$department->id);
		if($relation->tryLoadAny()->loaded())
			return $relation;
		else
			return false;		
	}

	function addToDepartment($department){
		$relation = $this->ref('xShop/OrderItemDepartmentalStatus')->addCondition('department_id',$department->id);
		$relation->tryLoadAny()->save();
	}

	function removeFromDepartment($department){
		$relation = $this->ref('xShop/OrderItemDepartmentalStatus')->addCondition('department_id',$department->id);
		if($relation->tryLoadAny()->loaded())
			$relation->delete();
	}

	function item(){
		return $this->ref('item_id');
	}

	function order(){
		return $this->ref('order_id');
	}

	function invoice($invoice=null){
		if($invoice){
			$this['invoice_id'] = $invoice->id;
			$this->save();
			return $invoice;
		}else{
			if(!$this['invoice_id']) return false;
			return $this->ref('invoice_id');
		}
	}

	function getCurrentStatus($department=false){
		$last_ds = $this->deptartmentalStatus()->addCondition('status','<>','Waiting');
		$last_ds->_dsql()->order('id','desc');
		if($department){
			$last_ds->addCondition('department_id',$department->id);
		}
		$last_ds->tryLoadAny();

		if($last_ds->loaded())
			return $last_ds['status'];

		return "Waiting";
	}

	function deptartmentalStatus($department=false,$from_custom_fields=false){
		if($from_custom_fields){
			$return_array=array();
			$cf = json_decode($this['custom_fields'],true);
			if(!$cf) return $return_array;
			foreach ($cf as $dept_id => $cfvalues_array) {
				if($dept_id == 'stockeffectcustomfield'){//check for the stockeffect customfields
					$return_array[] = array('department_id'=>$dept_id,'department'=>'stockeffectcustomfield','status'=>'');
				}else{
					$m = $this->add('xShop/Model_OrderItemDepartmentalStatus');
					$m->addCondition('orderitem_id',$this->id);
					$m->addCondition('department_id',$dept_id);
					$m->tryLoadAny();
					$name = "";
					if($m['outsource_party_id'])
						$name = $m->ref('outsource_party_id')->get('name');
					$return_array[] = array('department_id'=>$dept_id,'department'=>$this->add('xHR/Model_Department')->load($dept_id)->get('name'),'status'=>$m['status'],'outsource_party_id'=>$m['outsource_party_id'],'outsource_party'=>$name);
				}
			}
			return $return_array;
		}else{
			$m = $this->add('xShop/Model_OrderItemDepartmentalStatus');
			$m->join('xhr_departments','department_id')->addField('production_level');
			$m->setOrder('production_level');
			
			$m->addCondition('orderitem_id',$this->id);
			if($department){
				$m->addCondition('department_id',$department->id);
				$m->tryLoadAny();
				if(!$m->loaded()) return false;
			}

			// Now add qty effected custom fields manually from json
			// $cf = json_decode($this['custom_fields'],true);
			// $m[] = array('department_id'=>null,'department'=>'stockeffectcustomfield','status'=>'');

			return $m;
		}
	}

	function nextDeptStatus($after_department=false){
		foreach ($dept_status=$this->deptartmentalStatus() as $ds) {
			if($after_department){
				if($ds->department()->get('id') == $after_department->id) $after_department=false;
			}else{
				if($ds['status'] == 'Waiting'){
					return $ds;
				}
			}
		}
		return false;
	}

	function prevDeptStatus($before_department=false){
		$dept_status=$this->deptartmentalStatus()->setOrder('id','desc');
		
		foreach ($dept_status as $ds) {
			if($before_department){
				if($ds->department()->get('id') == $before_department->id) $before_department=false;
			}else{
				if($ds['status'] != 'Waiting') return $ds;
			}
		}
		return false;
	}

	function getCustomFieldSrting(){
		$cf=$this['custom_fields'];
		$cf =json_decode($cf,true);

		$cf = print_r($cf,true);
		 return $cf;
		
	}


	//Return OrderItem DepartmentalStatus
	//$with_custom_Fields = true; means also return departmnet associated CustomFields of OrderItem in Human Redable
	//Show Department Status
	//departmemt_object if passed return with the highlited string
		// Highlight the Passes Department
	function redableDeptartmentalStatus($with_custom_fields=false,$show_status=true,$department_hightlight=false,$with_jobcard=false){
		if(!$this->loaded())
			return false;

		$d = $this->deptartmentalStatus($department=false,$from_custom_fields=true);
		
		$str = "";
		foreach ($d as $department_asso) {
			// throw new \Exception($department_asso[''], 1);	
			//Hightlight the PassDepartment mostly used in Jobcard
			if($department_hightlight and $department_hightlight instanceof \xHR\Model_Department){
				if($department_hightlight['id'] == $department_asso['department_id'])
					$str .= "&nbsp;<b class='atk-swatch-green'>".$department_asso['department']."&nbsp;</b>";
				else
					$str .= '<b>' .$department_asso['department']."</b>";

			}else{
				if($department_asso['department'] == 'stockeffectcustomfield')
					$str .= '<b class="label label-primary">' .$department_asso['department']."</b>";
				else		
					$str .= '<b>' .$department_asso['department']."</b>";

			}
			

			if($show_status and $department_asso['department'] != 'stockeffectcustomfield'){//Show Department Status and check for the department is stockeffect
				$str .=" ( ".($department_asso['status']?:'Waiting')." )";
				if($with_jobcard){
					$jobcard_no = $this->jobCards($department_asso['department_id'])->get('name');
					if($jobcard_no == '##Dummy Object')
						$jobcard_no = 'Not Created';
					$str.= "[ Jobcard : ".$jobcard_no." ]";
				}
			}
			
			if($department_asso['outsource_party'])
				$str .= '&nbsp;<span class="atk-swatch-blue"> Out Source ( '.$department_asso['outsource_party'].' )&nbsp;</span>';

			if($with_custom_fields){
				$array = json_decode($this['custom_fields'],true);
				foreach ($array as $id => $cf ) {
					// $str.=$this['custom_fields'];
					if($department_asso['department_id'] == $id){
						if(!empty($cf)){
							$ar[$id] = $cf;
							$str .= "<br>[".$this->ref('item_id')->genericRedableCustomFieldAndValue(json_encode($ar))." ]<br>";
							unset($ar[$id]);							
						}else{
							$str.="<br>";
						}
					}
				}
			}

		}

		return $str;
	}

	// Return Department wise custom field
	function departmentRedableCustomFiled($department_id){
		$str =""; 
		$array = json_decode($this['custom_fields'],true);
		foreach ($array as $id => $cf ) {
			// $str.=$this['custom_fields'];
			if($department_id == $id){
				if(!empty($cf)){
					$ar[$id] = $cf;
					$str .= "[".$this->ref('item_id')->genericRedableCustomFieldAndValue(json_encode($ar))." ]<br>";
					unset($ar[$id]);							
				}else{
					$str.="<br>";
				}
			}
		}

		return $str;
	}

	function attachments(){
		if(!$this->loaded())
			return false;
		$atts = $this->add('xShop/Model_SalesOrderDetailAttachment');
		$atts->addCondition('related_root_document_name','xShop\OrderDetail');
		$atts->addCondition('related_document_id',$this->id);
		$atts->tryLoadAny();
		if($atts->loaded())
			return $atts;
		return false;
	}

	function forceDelete_page($page){
		$page->add('View_Warning')->set('All Jobcrads will be delete');
		$str = "";
		$jcs = $this->jobCards();
		foreach ($jcs as $jc) {
			$str.= "JobCard No. ".$jc['name']." Department ".$jc['to_department']." :: ". $jc['status']."<br>";
		}

		$form = $page->add('Form_Stacked');
		$form->addField('Readonly','Jobcards')->set($str);
		$form->addSubmit();
		if($form->isSubmitted()){
			$this->forceDelete();
			return true;
		}
	}

	function forceDelete(){
		$dnis = $this->deliveryNoteItems();
		foreach ($dnis as $dni) {
			$dni->forceDelete();
		}

		$dris = $this->dispatchRequestItems();
		foreach ($dris as $dri) {
			$dri->forceDelete();
		}

		$jcs = $this->Jobcards();
		foreach ($jcs as $jc) {
			//ALL JOBCARD DELETE
			$jc->forceDelete();
		}


		

		$this->delete();
	}

	function setItemEmpty(){
		if(!$this->loaded()) return;

		$this['item_id'] = null;
		$this->save();
	}

	function itemMemberDesignId(){

		if(!$this->loaded())
			throw new \Exception("Order Detail Model Not loaded");
					
		$member_design = $this->add('xShop/Model_ItemMemberDesign');
		$member_design->addCondition('item_id',$this->item()->id);
		$member_design->addCondition('member_id',$this->order()->get('member_id'));
		$member_design->tryLoadAny();		
		if($member_design->loaded())
			return $member_design->id;
		
		return 0;
	}

	function tax(){
		if(!$this->loaded())
			return "Tax Not Found";
			
		return $this->ref('tax_id');
	}

}