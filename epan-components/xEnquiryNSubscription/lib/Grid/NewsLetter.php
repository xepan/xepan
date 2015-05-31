<?php

namespace xEnquiryNSubscription;
class Grid_NewsLetter extends \Grid{
	public $preview_vp;
	function init(){
		parent::init();

		$this->preview_vp = $this->add('VirtualPage');
		$this->preview_vp->set(function($p){
			$m=$p->add('xEnquiryNSubscription/Model_NewsLetter')->load($_GET['newsletter_id']);
			$p->add('View')->set('Created '. $p->add('xDate')->diff(\Carbon::now(),$m['created_at']) .', Last Modified '. $p->add('xDate')->diff(\Carbon::now(),$m['updated_at']) )->addClass('atk-size-micro pull-right')->setStyle('color','#555');
			$p->add('HR');
			$p->add('View')->setHTML($m['matter']);
		});
	}

	function format_preview($f){
		$this->current_row_html[$f]='<a href="javascript:void(0)" onclick="'. $this->js()->univ()->frameURL($this->model['email_subject'],$this->api->url($this->preview_vp->getURL(),array('newsletter_id'=>$this->model->id))) .'">'.$this->current_row[$f].'</a>';
	}
	function setModel($model,$fields=null){
		$m= parent::setModel($model,$fields);
		$this->addQuickSearch(array('name','category'),null,'xEnquiryNSubscription/Filter_NewsLetter');
		$this->addPaginator($ipp=50);
		$this->add_sno();
			
			if($this->hasColumn('email_subject')) $this->removeColumn('email_subject');
			$this->addFormatter('name','preview');

			$this->addColumn('Expander','send');	
		return $m;
	}


	function formatRow(){
		// $this->current_row_html['name']=$this->model['post']."klfgkhj ". $this->model['department_id'];
		parent::formatRow();
	}

	function recursiveRender(){
		$cat_btn= $this->addButton("NewsLetter Category Management");
		if($cat_btn->isClicked()){
			$this->js()->univ()->frameURL('NewsLetter Category',$this->api->url('xMarketingCampaign_page_owner_newsletterscat'))->execute();
		}

		$temp_btn= $this->addButton("Templates Management");
		if($temp_btn->isClicked()){
			$this->js()->univ()->frameURL('NewsLetter Category',$this->api->url('xMarketingCampaign_page_owner_newsletterstemplates'))->execute();
		}
		$config_model=$this->add('xEnquiryNSubscription/Model_Config')->tryLoadAny();
		if(!$config_model['show_all_newsletters']){
			$this->model->addCondition('created_by_app','xMarketingCampaign');
		}
		if(!$config_model['show_all_newsletters']){
				$this->removeColumn('created_by_app');
			}

		$filter_btn=$this->addButton($config_model['show_all_newsletters']?"All Apps NewsLetters":"This App NewsLetters");
		if($filter_btn->isClicked()){
			$config_model['show_all_newsletters'] = $config_model['show_all_newsletters']?0:1;
			$config_model->save();
			$this->js()->reload()->execute();
			}
		parent::recursiveRender();
	}

}