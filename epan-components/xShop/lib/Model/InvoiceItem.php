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
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->hasOne('xShop/Invoice','invoice_id');
		$this->hasOne('xShop/OrderDetails','orderitem_id');
		
		$this->hasOne('xShop/Item','item_id')->display(array('form'=>'xShop/Item'));
		$this->hasOne('xShop/Tax','tax_id');

		$this->addField('rate')->type('money')->group('b~3');
		$this->addField('qty')->group('b~3~Order Details')->mandatory(true);
		// $this->addField('unit');
		$this->addField('amount')->type('money')->group('b~3');
		$this->addField('narration')->type('text')->system(false);
		$this->addField('custom_fields')->type('text')->system(false);
		$this->addField('apply_tax')->type('boolean');//->defaultValue(true);
		$this->addField('shipping_charge')->type('money')->defaultValue(0);

		$this->addExpression('tax_per_sum')->set(function($m,$q){
			$tax_assos = $m->add('xShop/Model_Tax');
			// $tax_assos->addCondition('item_id',$q->getField('item_id'));
			if($q->getField('tax_id'))
				$tax_assos->addCondition('id',$q->getField('tax_id'));

			$tax = $tax_assos->sum('value');
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

		$this->addExpression('unit')->set(function($m,$q){
			return $m->refSQL('item_id')->fieldQuery('qty_unit');
		});

		$this->addHook('afterSave',$this);
		$this->addHook('beforeSave',$this);

		// $this->add('dynamic_model/Controller_AutoCreator');

	}

	function beforeSave(){
			//Check for the apply tax
		// if( !(($this->dirty['apply_tax'] and $this['apply_tax'] ) and ($this->dirty['tax_id'] and $this['tax_id']) ))
		// 	return;

		// if($this['apply_tax'] and ($tax_asso = $this->item()->applyTaxs())){
		// 	$tax_asso->addCondition('tax_id',$this['tax_id']);
		// 	if(!$tax_asso->count()->getOne())
		// 		throw $this->exception('Tax Not Applied','ValidityCheck')->setField('tax_id');
		// }
	}

	function item(){
		return $this->ref('item_id');
	}

	function invoice(){
		if($this['invoice_id'])
			return $this->ref('invoice_id');
		else
			return false;
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

	function setItemEmpty(){
		if(!$this->loaded()) return;

		$this['item_id'] = null;
		$this->save();
	}

	function tax(){
		if(!$this->loaded())
			throw new \Exception('Invoice Item Model Must be Loaded');
		
		return $this->ref('tax_id');
	}
	
	}
	
