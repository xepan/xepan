<?php

namespace xShop;

class Controller_DesignTemplate extends \AbstractController{

	public $item;
	public $design;
	public $page_name;
	public $layout;

	function init(){
		parent::init();
		// print_r($this->design);

		if(!is_array($this->design)) $this->design = json_decode($this->design,true);
		$this->px_width = $this->design['px_width'] ;
		
		$design=$this->design['design'];

		$this->specification = $this->fetchDimensions($this->item);

		if(!$_GET['width'] AND !$_GET['height']){
			$width = $this->px_width;
			$height = $this->specification['height'] * $width/$this->specification['width'];
		}elseif($_GET['width'] and !$_GET['height']){
			$width = $_GET['width'];
			$height = $this->specification['height'] * $width/$this->specification['width'];
		}elseif(!$_GET['width'] and $_GET['height']){
			$height = $_GET['height'];
			$width = $this->specification['width'] * $height / $this->specification['height'];
		}else{
			$width=$_GET['width'];
			$height=$_GET['height'];
		}

		$this->print_ratio = $width/$this->px_width;

		$this->phpimage = $img = new \PHPImage($width,$height);

		$content = $design[$this->page_name][$this->layout];

		$background_options = json_decode($content['background'],true);

		$this->addImage($background_options,$img);

		// components
		foreach ($content['components'] as $comp) {
			$options = json_decode($comp,true);
			if($options['type']=='Image'){
				$this->addImage($options,$img);
			}
			if($options['type'] == 'Text'){
				$this->addText($options,$img);
			}
		}
	}

	function show($type='png',$quality=3, $base64_encode=true, $return_data=false){
		$this->phpimage->setOutput('png',3);
		return $this->phpimage->show($base64_encode,$return_data);
	}

	function putWaterMark($img){
		$pdf->SetAlpha(0.8);
		$pdf->SetFont('Arial','B',30);
	    $pdf->SetTextColor(255,192,203);
	    $pdf->Rotate(45,0,0);
	    $pdf->Text(0,$this->specification['height'],'printonclick.com');
	    $pdf->Rotate(0);
		$pdf->SetAlpha(1);
	    // $this->RotatedText(35,190,'W a t e r m a r k   d e m o',45);
	}

	function addImage($options, $img){
		if($options['url']){
			$options['url'] = getcwd().$options['url'];
			$options['width'] = $options['width'] * $this->print_ratio;
			$options['height'] = $options['height'] * $this->print_ratio;
			$options['x'] = $options['x'] * $this->print_ratio;
			$options['y'] = $options['y'] * $this->print_ratio;

			$cont = $this->add('xShop/Controller_RenderImage',array('options'=>$options));
			$data = $cont->show('png',1,false,true);
			$img->addImage($data, $this->pixcelToUnit($options['x']), $this->pixcelToUnit($options['y']), $this->pixcelToUnit($options['width']), $this->pixcelToUnit($options['height']));
		}
	}


	function addText($options, $img){
		if($options['text']){
			$options['desired_width'] = $options['width'] * $this->print_ratio;
			$options['x'] = $options['x'] * $this->print_ratio;
			$options['y'] = $options['y'] * $this->print_ratio;
			$options['font_size'] = $options['font_size'] * ($this->print_ratio / 1.328352013);
			$options['text_color'] = $options['color_formatted'];
			
			$cont = $this->add('xShop/Controller_RenderText',array('options'=>$options));
			$options['height'] = $cont->new_height /  $this->print_ratio;

			$data = $cont->show('png',1,false,true);
			// $pdf->MemImage($data, 0, 0, 100, 20);
			$img->addImage($data, $this->pixcelToUnit($options['x']), $this->pixcelToUnit($options['y']), $this->pixcelToUnit($options['desired_width']), $this->pixcelToUnit($options['height'] * $this->print_ratio));
		}
	}

	function fetchDimensions($item){
		$this->specification=array();
		preg_match_all("/^([0-9]+)\s*([a-zA-Z]+)\s*$/", $item->specification('width'),$temp);
		$this->specification['width']= $temp[1][0];
		preg_match_all("/^([0-9]+)\s*([a-zA-Z]+)\s*$/", $item->specification('height'),$temp);
		$this->specification['height']= $temp[1][0];
		$this->specification['unit']=$temp[2][0];

		preg_match_all("/^([0-9]+)\s*([a-zA-Z]+)\s*$/", $item->specification('trim'),$temp);
		$this->specification['trim']= $temp[1][0];

		return $this->specification;
	}

	function getOrientation($specification){
		if($specification['width'] > $specification['height'])
			return 'l';
		else
			return 'p';
	}

	function pixcelToUnit($pixels){
		return $pixels;
		return $this->print_ratio * $pixels;
	}

}