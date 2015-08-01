<?php

namespace xShop;
class View_Lister_ItemImages extends \CompleteLister{

	function setModel($model){
		parent::setModel($model);
		
		// cloneing the model and set first images
		$one_image = clone $model;
		$one_image->tryLoadAny();
		// $link ='index.php/?page=image&image=';
		
		$first_image = 'epan-components/xShop/templates/images/item_no_image.png';
		if($one_image['item_image']){
			$first_image = $one_image['item_image'];
			$first_large_image = $one_image['item_image'];
		}
		
		$this->template->trySet('zoom3_image_url',$first_image);
		$this->template->trySet('zoom3_large_image_url',$first_image);
	}
	
	function formatRow(){
		$this->current_row['thumb_image_url'] = $this->model['item_image'];
		$this->current_row['image_url'] = $this->model['item_image'];
		$this->current_row['img_alt'] = $this->model['alt'];
		$this->current_row['img_title'] = $this->model['title'];
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
		return array('view/xShop-ItemImage');
	}
}