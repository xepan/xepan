<?php

namespace xShop;

class Controller_RenderImage extends \AbstractController {
	public $options =array();
	public $phpimage;
	function init(){
		parent::init();

		$this->phpimage = $p = new \PHPImage($this->options['url']);
		if($this->options['width']==0 and $this->options['height']==0){
			if($p->getWidth() > $p->getHeight()){
				$this->options['width'] = $this->options['max_width'];
				$this->options['height'] = $this->options['width'] * ($p->getHeight() / $p->getWidth());
			}else{
				$this->options['height'] = $this->options['max_height'];
				$this->options['width'] = $this->options['height'] * ($p->getWidth() / $p->getHeight());
			}
		}elseif($this->options['crop']){
			$p->crop($this->options['crop_x'],$this->options['crop_y'],$this->options['crop_width'],$this->options['crop_height']);
		}

		$p->resize($this->options['width'],$this->options['height'],false,false,false);
		
		if($this->options['mask_added'] && $this->options['apply_mask']){
			$this->phpimage->mask($this->options['mask']);
		}

		// if($this->options['rotation_angle']){
		// 	$p->rotate($this->options['rotation_angle']);
		// }
	}

	function show($type='png',$quality=3, $base64_encode=true, $return_data=false){
		$this->phpimage->setOutput('png',3);
		return $this->phpimage->show($base64_encode=false,$return_data);
	}
}