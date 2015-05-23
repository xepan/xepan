<?php
namespace xProduction;

class View_Task extends \View{
	public $task;
	public $sno=1;
	public $task_vp;

	function init(){
		parent::init();
	}

	function setModel($model){
		$this->template->trySetHtml('created_at',$this->add('xDate')->diff(\Carbon::now(),$model['created_at']));

		$icon_html = "";
		switch ($model['Priority']) {
			case 'low':
				$icon_html = '<i class="atk-effect-warning>'.$model['Priority'].'</i>';
				break;

			case 'Medium':
				$icon_html = '<i class="">'.$model['Priority'].'</i>';
				break;
			case 'High':
				$icon_html = '<i class="atk-effect-info">'.$model['Priority'].'</i>';
				break;

			case 'Urgent':
				$icon_html = '<i class="atk-effect-danger">'.$model['Priority'].'</i>';
				break;
		}		
		$this->template->trySetHtml('priority',$icon_html);	

		$this->template->trySetHtml('task_subject','<a href="javascript:void(0)" onclick="'.$this->js()->univ()->frameURL($model['subject'],$this->api->url($this->task_vp->getURL(),array('task_id'=>$model->id))).'">'.substr(strip_tags($model['subject']),0,40).'</a>');
		parent::setModel($model);
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

		return array('view/task');
	}
}	