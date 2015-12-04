<?php

namespace xCRM;

class View_Ticket extends \View{
	public $model;

	function init(){
		parent::init();

		if(!$this->model){
			$this->add('View_Warning')->set('Must Pass Model');
		}

		$this->setModel($this->model);
		$this->js(true)->_selector('.xcrm-ticket')->xtooltip();
	}

	function recursiveRender(){
		$m = $this->model;
		// $this->template->trySet();
		$date = 'Created '.
						$this->add('xDate')->diff(\Carbon::now(),$m['created_at']).
				'<br/>Last Modified '.
						$this->add('xDate')->diff(\Carbon::now(),$m['updated_at']);	
		$this->template->trySetHtml('human_date',$date);
		$this->template->setHtml('ticket_message',$this->model['message']);
		$this->template->setHtml('ticket_priority',$this->priority());
		
		$attachment_html = "";
		foreach($this->model->attachment() as $attachment){
			$attachment_html .= '<br/><a target="_blank" href="'.$attachment['attachment_url'].'">'.$attachment->ref('attachment_url_id')->get('original_filename').'</a>'; 
		}

		$this->template->setHTML('attachment',$attachment_html);
		parent::recursiveRender();
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
		return array('view/xcrm-ticket');
	}

	function priority(){		
		switch ($this->model['priority']) {
			case 'Low':
			 $class = 'atk-label atk-swatch-ink';
			break;
			case 'Medium':
			 $class = 'atk-label atk-swatch-blue';
			break;
			case 'High':
			 $class = 'atk-label atk-swatch-yellow';
			break;
			case 'Urgent':
			 $class = 'icon-flash atk-label atk-swatch-red';
			break;
		}

		return '<div class=" '.$class.'">'.$this->model['priority'].'</div>';
	}
}