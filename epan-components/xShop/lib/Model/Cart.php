<?php

namespace xShop;

class Model_Cart extends \Model{
	
	function init(){
		parent::init();
		$this->setSource('Session');

		$this->addField('item_id');
		$this->addField('item_code');
		$this->addField('item_name');
		$this->addField('item_member_design_id');
		$this->addField('rateperitem')->type('money');
		$this->addField('qty');
		$this->addField('original_amount')->type('money');
		$this->addField('sales_amount')->type('money');
		$this->addField('shipping_charge')->defaultValue(0);
		$this->addField('tax')->defaultValue(0);
		$this->addField('tax_percentage')->defaultValue(0);
		$this->addField('total_amount')->type('money')->defaultValue(0);
		$this->addField('file_upload_id');

		$this->addField('custom_fields')->type('text');
		
	}

	function addToCart($item_id,$qty,$item_member_design_id, $custom_fields=null,$other_fields=null,$file_upload_id=null){
		$this->unload();

		if(!is_numeric($qty)) $qty=1;

		$item = $this->add('xShop/Model_Item')->load($item_id);
		$prices = $item->getPrice($custom_fields,$qty,'retailer');
		
		$amount = $item->getAmount($custom_fields,$qty,'retailer');

		$t = $item->applyTaxs()->setLimit(1);
		foreach ($t as $ts) {
			$tax_percentag = $ts['name'];
		}
		
		$tax = round( ( $amount['sale_amount']* $tax_percentag)/100 , 2);

		$total = round( ($amount['sale_amount'] + $tax),2);
		// $total = $total + $this['shipping_charge'];
		
		$this['item_id'] = $item->id;
		$this['item_code'] = $item['sku'];
		$this['item_name'] = $item['name'];
		$this['rateperitem'] = $prices['sale_price'];
		$this['qty'] = $qty;
		$this['original_amount'] = $amount['original_amount'];
		$this['sales_amount'] = $total;
		$this['custom_fields'] = $custom_fields;
		$this['item_member_design_id'] = $item_member_design_id;
		$this['shipping_charge'] = $amount['shipping_charge'];
		$this['total_amount'] = $total;
		$this['file_upload_id'] = $file_upload_id;
		$this['tax'] = $tax;
		$this['tax_percentage'] = $tax_percentag;
		// $this['shipping_charge'] = "todo";
		$this->save();
	}

	function getItemCount(){
		return $this->count()?:0;
	}

	//Return 
	function getItemQtyCount(){
		
		$item_count=0;
		foreach ($this as $junk) {
			$item_count += $junk['qty'];
		}

		return $item_count;
	}

	function getTotalAmount() { 
		$total_amount=0;
		$cart=$this->add('xShop/Model_Cart');
		$sum = 100;
		foreach ($cart as $junk) {

			$total_amount = (float)$total_amount + (float)$junk['total_amount']+(float)$junk['shipping_charge'];

		}
		
		// echo $total_amount." == ".$sum;
		// exit;
		return $total_amount;
	}

	function getTotalShippingCharge(){
		$total_shipping_charge=0;

		$cart=$this->add('xShop/Model_Cart');
		$sum = 100;
		foreach ($cart as $junk) {

			$total_shipping_charge = (float)$total_shipping_charge + (float)$junk['shipping_charge'];

		}
		
		return $total_shipping_charge;

	}

	function getTotalDiscount($percentage=false){
		$discount = 0;
		$total_amount=0;
		$original_total_amount = 0;
		$cart=$this->add('xShop/Model_Cart');
		// $carts = "";
		foreach ($cart as $junk) {
			if($junk['original_amount']){
				$total_amount += $junk['total_amount'];
				$original_total_amount += ($junk['original_amount'] + $this['shipping_charge'] + $this['tax']);
			}
		}

		return 0;//$total_amount - $original_total_amount;

	}

	function emptyCart(){
		 foreach ($this as $junk) {
			$this->delete();
		 }
	}

	function updateCart($id, $qty){
		
		if(!$this->loaded())
			throw new \Exception("Cart Model Not Loaded at update cart".$this['item_name']);
		
		if(!is_numeric($qty)) $qty=1;

		$item = $this->add('xShop/Model_Item')->load($this['item_id']);
		$prices = $item->getPrice($this['custom_fields'],$qty,'retailer');
		
		$amount = $item->getAmount($this['custom_fields'],$qty,'retailer');

		$t = $item->applyTaxs()->setLimit(1);
		foreach ($t as $ts) {
			$tax_percentag = $ts['name'];
		}
		
		$tax = round( ( $amount['sale_amount']* $tax_percentag)/100 , 2);

		$total = round( ($amount['sale_amount'] + $tax),2);
		
		// $this['item_id'] = $item->id;
		// $this['item_code'] = $item['sku'];
		// $this['item_name'] = $item['name'];
		$this['rateperitem'] = $prices['sale_price'];
		$this['qty'] = $qty;
		$this['original_amount'] = $amount['original_amount'];
		$this['sales_amount'] = $total;
		// $this['custom_fields'] = $custom_fields;
		// $this['item_member_design_id'] = $item_member_design_id;
		$this['total_amount'] = $total;
		// $this['file_upload_id'] = $file_upload_id;
		$this['tax'] = $tax;		
		$this['tax_percentage'] = $tax_percentag;
		// $this['shipping_charge'] = "todo";
		$this->save();
	}

	function remove($cartitem_id){
		$this->load($cartitem_id);
		$this->delete();		
	}
	
}