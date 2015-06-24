<?php
namespace xAccount;
class View_Lister_AccountStatement extends \CompleteLister{
	public $sno=1;
	public $account_id = 0;
	public $from_date = 0;
	function setModel($model){
		parent::setModel($model);

		if($this->account_id and $this->from_date){
			$opening_balance = $this->add('xAccount/Model_Account')->load($this->account_id)->getOpeningBalance($this->from_date);
			$this->template->set('opening_balance_narration','Opening Balance');			
			$this->template->set('opening_balance',$opening_balance['cr']);			
		}else
			$this->template->tryDel('opening_balance_section');

	}

	function formatRow(){
		$amount  = $this->model['amountDr'] - $this->model['amountCr'];
		if($amount > 0)
			$balance = $amount." DR";
		else
			$balance = abs($amount)." CR";

		$this->current_row['s_no'] = $this->sno++;
		$this->current_row['created_date'] = date('Y-m-d', strtotime($this->model->get('created_at')));
		$this->current_row['balance'] = $balance;
		parent::formatRow();
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

		return array('view/acstatement');
	}
}