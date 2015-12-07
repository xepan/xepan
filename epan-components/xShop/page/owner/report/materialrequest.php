<?PHP

class page_xShop_page_owner_report_materialrequest extends page_xShop_page_owner_main{
	function init(){
		parent::init();

		$form=$this->add('Form');
		$form->addField('DatePicker','from_date');
		$form->addField('DatePicker','to_date');
		$form->addSubmit('Get Report');
		
	}
}