<?PHP

class page_xShop_page_owner_report_invoice extends page_xShop_page_owner_main{
	function init(){
		parent::init();

		$form = $this->add('Form');
		$form->addField('autocomplete/Basic','order');
		$form->addField('autocomplete/Basic','customer');
		$form->addField('Dropdown','status');
        $form->addField('DatePicker','from_date');
        $form->addField('DatePicker','to_date');
        $form->addSubmit('Get Report');

		
	}
}