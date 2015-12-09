<?PHP

class page_xShop_page_owner_report_evoucher extends page_xShop_page_owner_main{
	function init(){
		parent::init();
		$voucher=$this->add('xShop/Model_DiscountVoucher');
		$member=$this->add('xShop/Model_MemberDetails');
		$form=$this->add('Form');
		$form->addField('autocomplete/Basic','member')->setModel($member);
		$form->addField('DatePicker','from_date');
		$form->addField('DatePicker','to_date');
		$form->addSubmit('Get Report');

		$grid=$this->add('xShop/Grid_DiscountVoucher');

		$this->app->stickyGET('filter');
		$this->app->stickyGET('member');
		$this->app->stickyGET('from_date');
		$this->app->stickyGET('to_date');

		if($_GET['filter']){
			if($_GET['from_date']){
				$voucher->addCondition('created_at','>',$_GET['from_date']);
			}

			if($_GET['to_date']){
				$voucher->addCondition('created_at','<=',$this->api->nextDate($_GET['to_date']));
			}
			if($_GET['member']){
				$used_voucher_j=$voucher->join('xshop_discount_vouchers_used.discountvoucher_id');
				$used_voucher_j->addField('member_id');
				$voucher->addCondition('member_id',$_GET['member']);
			}
		
		}else{
			// $voucher->addCondition('id',-1);
		}
		$grid->setModel($voucher);

		$grid->addPaginator(100);
		$grid->addSno();
	
		if($form->isSubmitted()){
			$grid->js()->reload(array('member'=>$form['member'],
									  'from_date'=>$form['from_date']?:0,
									  'to_date'=>$form['to_date']?:0,
									  'filter'=>1)
								)->execute();
		}
	}
}