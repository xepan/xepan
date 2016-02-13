<?php
namespace xProduction;

class View_Lister_JobcardOrder extends \CompleteLister{
	function init(){
		parent::init();

		$member_id=$this->api->stickyGET('customer');

        $order=$this->add('xShop/Model_Order');            
		$order->addCondition('member_id',$member_id);
		$order->tryLoadAny();
		// $this->add('View_Info')->set('JobcardOrder'.rand(1,999).' member ID '.$member_id.' Order ID '.$order['id']);
  //       // $this->template->trySet('order_item',$jobcard_item->getHTML());
	}

	function defaultTemplate(){
		return array('view/jobcardOrder1');
	}
}