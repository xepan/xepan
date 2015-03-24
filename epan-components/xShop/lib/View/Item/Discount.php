<?php

namespace xShop;

class View_Item_Discount extends \View{
	public $item_model;
	
	function init(){
		parent::init();
		
		if(!is_numeric($this->item_model['original_price']) and $this->item_model['original_price'] <= 0) return;

		$discount = $this->item_model['original_price'] - $this->item_model['sale_price'];
		if($this->item_model['original_price']==0){
			$discount_per=0;	
		}else{
			$discount_per = $discount / $this->item_model['original_price'] * 100;
		}
		$this->set($discount_per.'%');
	}
}