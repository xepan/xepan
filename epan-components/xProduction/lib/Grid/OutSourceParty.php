<?php
namespace xProduction;

class Grid_OutSourceParty extends \Grid{
	function setModel($model){
		$m = parent::setModel($model);
		
		if($this->hasColumn('code'))$this->removeColumn('code');
		if($this->hasColumn('contact_person'))$this->removeColumn('contact_person');
		if($this->hasColumn('contact_no'))$this->removeColumn('contact_no');
		if($this->hasColumn('email_id'))$this->removeColumn('email_id');
		$this->addColumn('contact');
		$this->addFormatter('name','wrap');
		$this->addFormatter('contact','wrap');
		$this->addFormatter('address','wrap');
		$this->addFormatter('bank_detail','wrap');

		$this->addQuickSearch(array('name','code'));
		$this->addPaginator($ipp=50);
		$this->add_sno();
		return $m;
	}

	function formatRow(){
		$this->current_row_html['name']=$this->model['name']."  [ ".$this->model['code']." ] ";
		
		$contact_no="";
		if($this->model['contact_no'])
			$contact_no="<i class='glyphicon glyphicon-earphone atk-effect-success'></i>"	;
		$email="";
		if($this->model['email_id'])
			$email="<i class ='glyphicon glyphicon-envelope  atk-effect-success'></i>"	;	
		 $this->current_row_html['contact']=$this->model['contact_person']."<br/> ".$contact_no." ".$this->model['contact_no']."<br/>".$email." ".$this->model['email_id']."</i>";
		
		parent::formatRow();
	}

	function recursiveRender(){
		$this->addOrder()->move('contact','after','name')->now();
		parent::recursiveRender();
	}
}