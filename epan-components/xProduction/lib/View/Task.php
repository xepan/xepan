<?php
namespace xProduction;

class View_Task extends \View{
	public $task=null;
	public $sno=1;
	public $task_vp;

	function init(){
		parent::init();

		if($this->task)
			$this->setModel($this->task);
	}

	function setModel($model){
		$this->template->trySetHtml('created_at',$this->add('xDate')->diff(\Carbon::now(),$model['created_at']));

		$icon_html = "";
		switch ($model['priority']) {
			case 'low':
				$icon_html = '<i class="atk-effect-warning>'.$model['priority'].'</i>';
				break;

			case 'Medium':
				$icon_html = '<i class="">'.$model['priority'].'</i>';
				break;
			case 'High':
				$icon_html = '<i class="atk-effect-info">'.$model['priority'].'</i>';
				break;

			case 'Urgent':
				$icon_html = '<i class="atk-effect-danger">'.$model['priority'].'</i>';
				break;
		}
				
		$this->template->trySetHtml('priority_icon',$icon_html);

		// $this->template->trySetHtml('task_subject',$model['subject']);
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