<?php
namespace xProduction;

class Grid_OutSourceParty extends \Grid{
	public $jobcard_vp;
	function init(){
		parent::init();
		$self=$this;
		$this->jobcard_vp = $this->add('VirtualPage')->set(function($p)use($self){
			$this->api->StickyGET('out_source_party_id');
			$out_model=$p->add('xProduction/Model_OutSourceParty');
				$out_model->load($_GET['out_source_party_id']);
			
			$grid = $p->add('xProduction/Grid_JobCard');
			$jc = $p->add('xProduction/Model_JobCard');
			$jc->addCondition('outsource_party',$out_model['name']);
			$grid->setModel($jc);
		});

		$this->addColumn('total_jobcard');
	}
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
		
		$this->addFormatter('total_jobcard','preview');

		$this->addQuickSearch(array('name','code'));
		$this->addPaginator($ipp=50);
		$this->add_sno();
		return $m;
	}
	function format_preview($f){
		$this->current_row_html[$f] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('JobCard ( '.$this->model['name'].' ) JobCard List ', $this->api->url($this->jobcard_vp->getURL(),array('out_source_party_id'=>$this->model['id']))).'">'. $this->add('xProduction/Model_JobCard')->addCondition('outsource_party',$this->model['name'])->count()->getOne()."</a>";
	}


	function formatRow(){
		$this->current_row_html['name']=$this->model['name']."  [ ".$this->model['code']." ] ";
		
		$contact_no="";
		if($this->model['contact_no'])
			$contact_no="<i class='glyphicon glyphicon-earphone atk-effect-success '></i>"	;
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