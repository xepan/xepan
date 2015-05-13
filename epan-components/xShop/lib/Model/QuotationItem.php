<?php

namespace xShop;
class Model_QuotationItem extends \Model_Document{
	
	public $table="xshop_quotation_item";
	public $status=array();
	public $root_document_name="xShop\QuotationItem";

	public $actions=array(
			'allow_edit'=>array('caption'=>'Whose created Jobcard this post can edit'),
			'allow_add'=>array('caption'=>'Can this post create new Jobcard'),
			'allow_del'=>array('caption'=>'Whose Created Jobcard this post can delete'),
		);

	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		
		$this->hasOne('xShop/Quotation','quotation_id')->sortable(true);
		$this->hasOne('xShop/Item_Saleable','item_id')->display(array('form'=>'xShop/Item'))->sortable(true);
		
		$this->addField('qty')->sortable(true)->group('a~4');
		$this->addField('rate')->type('money')->sortable(true)->group('a~4');
		$this->addField('amount')->type('money')->sortable(true)->group('a~4');
		$this->addField('narration')->type('text');
		$this->addField('custom_fields')->type('text')->system(false);
		$this->addField('apply_tax')->type('boolean')->defaultValue(true);

		$this->addExpression('name')->set(function($m,$q){
			return $m->refSQL('item_id')->fieldQuery('name');
		});


		$this->addExpression('tax_per_sum')->set(function($m,$q){
			$tax_assos = $m->add('xShop/Model_ItemTaxAssociation');
			$tax_assos->addCondition('item_id',$q->getField('item_id'));
			$tax = $tax_assos->sum('name');
				return "IF(".$q->getField('apply_tax').">0,(".$tax->render()."),'0')";
		})->type('money')->caption('Total Tax %');

		$this->addExpression('tax_amount')->set(function($m,$q){
			$tpa = $m->add('xShop/Model_QuotationItem',array('table_alias'=>'tps'));
			$tpa->addCondition('id',$q->getField('id'));

			return "((".$q->getField('amount').") * ( IFNULL((". $tpa->_dsql()->del('fields')->field('tax_per_sum')->render()."),0) ) / 100)";
		})->type('money');

		$this->addExpression('texted_amount')->set(function($m,$q){
			$tpa = $m->add('xShop/Model_QuotationItem',array('table_alias'=>'txdamt'));
			$tpa->addCondition('id',$q->getField('id'));

			return "((".$q->getField('amount').") + ( IFNULL((". $tpa->_dsql()->del('fields')->field('tax_amount')->render()."),0) ))";
		})->type('money');


		$this->addExpression('created_by_id')->set(function($m,$q){
			return $m->refSQL('quotation_id')->fieldQuery('created_by_id');
		});

		$this->addHook('afterSave',$this);
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function afterSave(){
		$this->quotation()->updateAmounts();
	}

	function item(){
		return $this->ref('item_id');
	}
	
	function quotation(){
		return $this->ref('quotation_id');	
	}

	function setItemEmpty(){
		if(!$this->loaded()) return;

		$this['item_id'] = null;
		$this->save();
	}
}