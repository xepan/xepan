<?php

namespace xShop;

class Model_OrderDetails extends \Model_Document{
	public $table='xshop_orderDetails';

	public $status=array();
	public $root_document_name = 'xShop\OrderDetails';
	public $actions=array(
			//'can_view'=>array('caption'=>'Whose created Quotation(draft) this post can see'),
			'allow_edit'=>array('caption'=>'Whose created Quotation this post can edit'),
			'allow_add'=>array('caption'=>'Can this post create new Quotation'),
			'allow_del'=>array('caption'=>'Whose Created Quotation this post can delete'),
		);

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		$this->hasOne('xShop/Order','order_id');
		$this->hasOne('xShop/Item_Saleable','item_id')->display(array('form'=>'autocomplete/Basic'));//->group('a~6~Item Select');
		$this->hasOne('xShop/Invoice','invoice_id')->display(array('form'=>'autocomplete/Basic'));//->group('a~6~Item Select');

		$this->addField('rate')->type('money')->group('b~3');
		$this->addField('qty')->group('b~3~Order Details')->mandatory(true);
		// $this->addField('unit')->group('b~3');
		$this->addField('amount')->type('money')->group('b~3');
		$this->addField('narration')->type('text')->system(false)->group('c~12~ Narration');
		$this->addField('custom_fields')->type('text')->system(false);

		$this->addExpression('name')->set(function($m,$q){
			return $m->refSQL('item_id')->fieldQuery('name');
		});


		$this->addExpression('tax_per_sum')->set(function($m,$q){
			$tax_assos = $m->add('xShop/Model_ItemTaxAssociation');
			$tax_assos->addCondition('item_id',$q->getField('item_id'));
			return $tax_assos->sum('name'); // tax in percentage save in name ;)
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

		$this->addExpression('item_with_qty_fields','custom_fields');

		$this->hasMany('xShop/OrderItemDepartmentalStatus','orderitem_id');
		$this->hasMany('xShop/SalesOrderDetailAttachment','related_document_id',null,'Attachements');
		$this->hasMany('xShop/Jobcard','orderitem_id');

		$this->addHook('beforeSave',$this);
		$this->addHook('afterSave',$this);
		$this->addHook('afterInsert',$this);
		$this->addHook('beforeDelete',$this);
		// $this->addHook('afterLoad',$this);

		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	// function afterLoad(){
	// 	if($this['custom_fields']){
	// 		$cf_array=json_decode($this['custom_fields'],true);
	// 		$qty_json = json_encode(array('stockeffectcustomfield'=>$cf_array['stockeffectcustomfield']));
	// 		$this['item_with_qty_fields'] = $this['item'] .' [' .$this->item()->genericRedableCustomFieldAndValue($qty_json) .']';
	// 	}
	// }

	function beforeSave(){

		// validate custom field entries
		// if($this['custom_fields']==''){
		// 	$phases_ids = $this->ref('item_id')->getAssociatedDepartment();
		// 	$cust_field_array = array();
		// }else{
		// 	$cust_field_array = json_decode($this['custom_fields'],true);
		// 	$phases_ids = array_keys($cust_field_array);
		// }

		// foreach ($phases_ids as $phase_id) {
		// 	$custom_fields_assos_ids = $this->ref('item_id')->getAssociatedCustomFields($phase_id);
		// 	foreach ($custom_fields_assos_ids as $cf_id) {
		// 		if(!isset($cust_field_array[$phase_id][$cf_id]) or $cust_field_array[$phase_id][$cf_id] == ''){
		// 			throw $this->exception('Custom Field Values not proper','Growl');
		// 		}
		// 	}
		// }
		
	}

	function afterSave(){
		$this->order()->updateAmounts();
	}

	function beforeDelete(){

		$dnis = $this->deliveryNoteItems();
		foreach ($dnis as $dni) {
			$dni->delete();
		}

		$dris = $this->dispatchRequestItems();
		foreach ($dris as $dri) {
			$dri->delete();
		}

		$jcs = $this->Jobcards();
		foreach ($jcs as $jc) {
			//ALL JOBCARD DELETE
			$jc->delete();
		}

	}

	function deliveryNoteItems(){
		return $this->add('xDispatch/Model_DeliveryNoteItem')->addCondition('orderitem_id',$this->id)->tryLoadAny();

	}

	function dispatchRequestItems(){
		return $this->add('xDispatch/Model_DispatchRequestItem')->addCondition('orderitem_id',$this->id)->tryLoadAny();
	}

	function jobCards($item_id=null){
		if($this->loaded())
			$item_id = $this->id;
		$jobCards = $this->add('xProduction/Model_JobCard')->addCondition('orderitem_id',$item_id)->tryLoadAny();
		return $jobCards;
	}


	function afterInsert($obj,$new_id){
		// For online orders that are already approved and create their departmental associations
		$new_order_details = $this->add('xShop/Model_OrderDetails')->load($new_id);
		if($new_order_details->order()->isFromOnline()){
			$new_order_details->createDepartmentalAssociations();
		}

		if($department_association = $new_order_details->nextDeptStatus()){
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
					$return_array[] = array('department_id'=>$dept_id,'department'=>$this->add('xHR/Model_Department')->load($dept_id)->get('name'),'status'=>$m['status']);
				}
			}
			return $return_array;
		}else{
			$m = $this->add('xShop/Model_OrderItemDepartmentalStatus');
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
	function redableDeptartmentalStatus($with_custom_fields=false,$show_status=true,$department_hightlight=false){
		if(!$this->loaded())
			return false;

		$d = $this->deptartmentalStatus($department=false,$from_custom_fields=true);
		
		$str = "";
		foreach ($d as $department_asso) {
			// throw new \Exception($department_asso[''], 1);	
			//Hightlight the PassDepartment mostly used in Jobcard
			if($department_hightlight and $department_hightlight instanceof \xHR\Model_Department){
				if($department_hightlight['id'] == $department_asso['department_id'])
					$str .= "<b class='atk-swatch-green'>".$department_asso['department']."</b>";
				else
					$str .= '<b>' .$department_asso['department']."</b>";
			}else{
				if($department_asso['department'] == 'stockeffectcustomfield')
					$str .= '<b class="label label-primary">' .$department_asso['department']."</b>";
				else		
					$str .= '<b>' .$department_asso['department']."</b>";
			}
			
			if($show_status and $department_asso['department'] != 'stockeffectcustomfield')//Show Department Status and check for the department is stockeffect
				$str .=" ( ".($department_asso['status']?:'Waiting')." )";

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

}