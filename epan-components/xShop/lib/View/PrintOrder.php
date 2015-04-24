<?php

namespace xShop;

class View_PrintOrder extends \View{
	function init(){
		parent::init();

	}  

	function setModel($model){
		
		$user_model = $this->add('xShop/Model_MemberDetails');
		$user_model->getAllDetail($model['member_id']);
		
		$config_model = $this->add('xShop/Model_Configuration');
		$config_model->tryLoadAny();
		$order_template=$config_model['order_detail_email_body'];
		
		$tnc=$model->termAndCondition();

		$print_order = $model->add('xShop/View_OrderDetail',array('show_department'=>false,'show_price'=>true,'show_customfield'=>true));
		$print_order->setModel($model->itemrows());
		$order_detail_html = $print_order->getHTML(false);

		$customer = $model->customer();
		$customer_email=$customer->get('customer_email');
		
		//REPLACING VALUE INTO ORDER DETAIL TEMPLATES
		$order_template = str_replace("{{customer_name}}", $customer['customer_name']?"<b>".$customer['customer_name']."</b><br>":" ", $order_template);
		$order_template = str_replace("{{order_billing_address}}",$customer['billing_address']?$customer['billing_address']:" ", $order_template);
		$order_template = str_replace("{{mobile_number}}", $customer['mobile_number']?$customer['mobile_number']:" ", $order_template);
		$order_template = str_replace("{{customer_email}}", $customer['customer_email']?$customer['customer_email']:" ", $order_template);
		$order_template = str_replace("{{order_shipping_address}}",$customer['shipping_address']?$customer['shipping_address']:" ", $order_template);
		$order_template = str_replace("{{customer_tin_no}}", $customer['tin_no'], $order_template);
		$order_template = str_replace("{{customer_pan_no}}", $customer['pan_no'], $order_template);
		$order_template = str_replace("{{order_no}}", $model['name'], $order_template);
		$order_template = str_replace("{{order_date}}", $model['created_date'], $order_template);
		$order_template = str_replace("{{sale_order_details}}", $order_detail_html, $order_template);
		$order_template = str_replace("{{terms_and_conditions}}", $tnc['terms_and_condition']?$tnc['terms_and_condition']:" ", $order_template);

		$this->template->SetHtml('order_address',$order_template);
		parent::setModel($model);

	}

	function defaultTemplate(){
		$this->app->pathfinder->base_location->addRelativeLocation(
		    'epan-components/'.__NAMESPACE__, array(
		        'php'=>'lib',
		        'template'=>'templates',
		        'css'=>'templates/css',
		        'js'=>'templates/js',
		    )
		);
		return array('view/xShop-PrintOrder');
	}
	
}
