<?php

class Grid_User extends Grid{
	function init(){
		parent::init();
	}

	function setModel($model){
		
		$m=parent::setModel($model,array('name','username','is_active','user_management','general_settings','application_management','website_designing','last_login_date'));

		$this->removeColumn('is_active');
		$this->removeColumn('user_management');
		$this->removeColumn('general_settings');
		$this->removeColumn('application_management');
		$this->removeColumn('website_designing');
		
		$this->addFormatter('username','wrap');

		$this->fooHideAll('s_no');

		return $m;

	}

	function formatRow(){

		if(!$this->model['is_active']){
			$this->setTDParam('name','style/color','red');
		}else{
			$this->setTDParam('name','style/color','');
		}
		
		$user_color= $this->model['user_management']?'success':'danger';
		$setting_color= $this->model['general_settings']?'success':'danger';
		$app_color= $this->model['application_management']?'success':'danger';
		$web_color= $this->model['website_designing']?'success':'danger';
		
		$this->current_row_html['username']=$this->model['username'].'<div class="pull-right">'.
								
								'<span class="atk-effect-'. $user_color.'"><i class="glyphicon glyphicon-user" title="User Managment"></i></span>&nbsp&nbsp'.
								'<span class="atk-effect-'. $setting_color.'"><i class="glyphicon glyphicon-cog" title="General Settings"></i></span>&nbsp&nbsp'.
								'<span class="atk-effect-'. $app_color.'"><i class="icon-doc-inv" title="Application Management"></i></span>&nbsp&nbsp'.
								'<span class="atk-effect-'. $web_color.'"><i class="glyphicon glyphicon-globe" title="Website Designing"></i></span>&nbsp&nbsp'.
								'</div>';
		parent::formatRow();		
	}

}