<?php

namespace xShop;

class Model_DiscountVoucherUsed extends \Model_Table{
	public $table='xshop_discount_vouchers_used';

	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);	
		
		$this->hasOne('xShop/DiscountVoucher','discountvoucher_id');
		$this->hasOne('xShop/MemberDetails','member_id');	

		// //$this->add('dynamic_model/Controller_AutoCreator');
	}

	function setMemberEmpty(){
		if(!$this->loaded()) return false;

		$this['member_id'] = null;
		$this->save();
	}
}

