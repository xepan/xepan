<?php

namespace xShop;

class Model_DiscountVoucher extends \Model_Document{
	public $table='xshop_discount_vouchers';
	public $status=array();
	public $root_document_name="DiscountVoucher";
	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
		);
	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$f = $this->addField('name')->caption('Voucher Number')->mandatory(true)->group('a~6')->sortable(true);
		$f->icon = "fa fa-circle~red";
		$f = $this->addField('no_person')->caption('No of Person')->defaultValue(1)->mandatory(true)->hint('Only Numeric Number')->group('a~3')->sortable(true);
		$f->icon = "fa fa-user~red";	
		$f = $this->addField('discount_amount')->type('money')->caption('Discount Amount %')->type('int')->mandatory(true)->hint('discount Amount in %')->group('a~3')->sortable(true);
		$f->icon = "fa fa-money~red";	
		$f = $this->addField('from')->caption('Strating Date')->type('date')->defaultValue(date('Y-m-d'))->mandatory(true)->group('b~6')->sortable(true);
		$f->icon = "fa fa-calendar~red";	
		$f = $this->addField('to')->caption('Expire Date')->type('date')->group('b~6')->sortable(true);
		$f->icon = "fa fa-calendar~blue";
			
		$this->hasMany('xShop/DiscountVoucherUsed','discountvoucher_id');
		$this->addHook('beforeDelete',$this);
		//$this->add('dynamic_model/Controller_AutoCreator');
	}
  	
  	function beforeDelete($m){	
		if($m->ref('xShop/DiscountVoucherUsed')->count()->getOne())
			throw $this->exception('Cannot Delete, First Delete its Transaction/Orders','Growl');
  	}

  	function forceDelete(){
  		$this->ref('xShop/DiscountVoucherUsed')->each(function($voucher_used){
  			$voucher_used->forceDelete();
  		});
 		
 		$this->delete();
  	}


	function isExpire(){

		$current_date=date('Y-m-d');
		if( strtotime($current_date) > strtotime($this['to']))
			return true;
		else
			return false;
	}

	function processDiscountVoucherUsed($discount_voucher){

		$this->addCondition('name',$discount_voucher);
		$this->tryLoadAny();
		$discountvoucherused=$this->add('xShop/Model_DiscountVoucherUsed');
		$discountvoucherused['member_id']=$this->api->auth->model->id;
		$discountvoucherused['discountvoucher_id']=$this['id'];
		$discountvoucherused->save();
	}


	function isUsable($voucher_no){

		$voucher=$this->add('xShop/Model_DiscountVoucher');
		$voucher->addCondition('name',$voucher_no);
		$voucher->tryLoadAny();
		if(!$voucher->loaded()){
			return false;
		}
			
		// if voucher expire he to error message
		if($voucher->isExpire()){
			return false;
		}
		// if voucher is not expire to get karo kitne person or use kar sakte he
		else{
			$person_used=$voucher->ref('xShop/DiscountVoucherUsed')->count()->getOne();					
			if($voucher['no_person'] > $person_used){
				return $voucher['discount_amount'];
				// calulate discount amount 
			}
			// if no of person already consumed to error message 
			else{
				return false;
				// throw new \Exception("this Voucher exceed it's limit");
			}
							
		}

	}

}

