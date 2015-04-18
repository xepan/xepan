<?php
namespace xShop;

class Model_InvoiceItem extends \Model_Document{
	public $table="xshop_invoice_item";
	public $status  = array('draft','submitted','approved','canceled','completed');
	public $root_document_name = 'xShop\InvoiceItem';
	public $actions=array(
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
			'can_view'=>array(),
		);
	function init(){
		parent::init();

		$this->hasOne('xShop/Invoice','invoice_id');
		$this->hasOne('xShop/OrderDetails','orderitem_id');
		
		$this->hasOne('xShop/Item','item_id')->display(array('form'=>'xShop/Item'));
		
		$this->addField('rate')->type('money')->group('b~3');
		$this->addField('qty')->group('b~3~Order Details')->mandatory(true);
		// $this->addField('unit');
		$this->addField('amount')->type('money')->group('b~3');
		$this->addField('narration')->type('text')->system(false);
		$this->addField('custom_fields')->type('text')->system(false);
		$this->addField('apply_tax')->type('boolean')->defaultValue(true);

		$this->addExpression('tax_per_sum')->set(function($m,$q){
			$tax_assos = $m->add('xShop/Model_ItemTaxAssociation');
			$tax_assos->addCondition('item_id',$q->getField('item_id'));
			$tax = $tax_assos->sum('name');
				return "IF(".$q->getField('apply_tax').">0,(".$tax->render()."),'0')";
		})->type('money')->caption('Total Tax %');

		$this->addExpression('tax_amount')->set(function($m,$q){
			$tpa = $m->add('xShop/Model_InvoiceItem',array('table_alias'=>'tps'));
			$tpa->addCondition('id',$q->getField('id'));

			return "((".$q->getField('amount').") * ( IFNULL((". $tpa->_dsql()->del('fields')->field('tax_per_sum')->render()."),0) ) / 100)";
		})->type('money');

		$this->addExpression('texted_amount')->set(function($m,$q){
			$tpa = $m->add('xShop/Model_InvoiceItem',array('table_alias'=>'txdamt'));
			$tpa->addCondition('id',$q->getField('id'));

			return "((".$q->getField('amount').") + ( IFNULL((". $tpa->_dsql()->del('fields')->field('tax_amount')->render()."),0) ))";
		})->type('money');

		$this->addHook('afterSave',$this);

		// $this->add('dynamic_model/Controller_AutoCreator');

	}

	function item(){
		return $this->ref('item_id');
	}

	function invoice(){
		return $this->ref('invoice_id');
	}

	function afterSave(){		
		
		$this['amount'] = $this['qty'] * $this['rate'];
		$this->save();
		$this->invoice()->updateAmounts();
	}


	function redableDeptartmentalStatus($with_custom_fields=false){
		if(!$this->loaded())
			return false;

		$str = "";
		$array = json_decode($this['custom_fields'],true);
		if(!$array) return false;
		
		foreach ($array as $department_id => $cf) {
			$d = $this->add('xHR/Model_Department')->load($department_id);
			$str .= $d['name'];
			if($with_custom_fields){
				if(!empty($cf)){
					$ar[$department_id] = $cf;
					$str .= "<br>[".$this->ref('item_id')->genericRedableCustomFieldAndValue(json_encode($ar))." ]<br>";
					unset($ar[$department_id]);							
				}else{
					$str.="<br>";
				}
			}
		}
			
		return $str;
	}

	
	}
	
