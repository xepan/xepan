<?php

namespace xShop;

class Controller_RenderText extends \AbstractController {
	public $options = array();
	public $phpimage;

	function init(){
		parent::init();
		$options = $this->options;
		
		$p = new \PHPImage($options['desired_width'],10);
		$this->phpimage = $p;
		
		$box = new \GDText\Box($this->phpimage);
		
		//GET Font Path
		if($options['bold'] and !$options['italic']){
			if(file_exists(getcwd().'/epan-components/xShop/templates/fonts/'.$options['font'].'-Bold.ttf'))
				$options['font'] = $options['font'].'-Bold';
			// else
				// $draw->setFontWeight(700);
		}

		if($options['italic'] and !$options['bold']){
			if(file_exists(getcwd().'/epan-components/xShop/templates/fonts/'.$options['font'].'-Italic.ttf'))
				$options['font'] = $options['font'].'-Italic';
			else
				$options['font'] = $options['font'].'-Regular';
		}

		if($options['italic'] and $options['bold']){
			if(file_exists(getcwd().'/epan-components/xShop/templates/fonts/'.$options['font'].'-BoldItalic.ttf'))
				$options['font'] = $options['font'].'-BoldItalic';
			else
				$options['font'] = $options['font'].'-Regular';
		}
		if(!$options['bold'] and !$options['italic'])
			$options['font'] = $options['font'] .'-Regular';

		$font_path = getcwd().'/epan-components/xShop/templates/fonts/'.$options['font'].'.ttf';

		$box->setFontFace($font_path);
		$box->setFontColor(new \GDText\Color(255, 75, 140));
		$box->setTextShadow(new \GDText\Color(0, 0, 0, 50), 2, 2);
		$box->setFontSize(8);
		$box->setLineHeight(1.5);
		$box->enableDebug();
		$box->setBox(20, 20, 460, 460);
		$box->setTextAlign('left', 'top');
		$box->draw(
		    "    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eleifend congue auctor. Nullam eget blandit magna. Fusce posuere lacus at orci blandit auctor. Aliquam erat volutpat. Cras pharetra aliquet leo. Cras tristique tellus sit amet vestibulum ullamcorper. Aenean quam erat, ullamcorper quis blandit id, sollicitudin lobortis orci. In non varius metus. Aenean varius porttitor augue, sit amet suscipit est posuere a. In mi leo, fermentum nec diam ut, lacinia laoreet enim. Fusce augue justo, tristique at elit ultricies, tincidunt bibendum erat.\n\n    Aenean feugiat dignissim dui non scelerisque. Cras vitae rhoncus sapien. Suspendisse sed ante elit. Duis id dolor metus. Vivamus congue metus nunc, ut consequat arcu dapibus vel. Ut sed ipsum sollicitudin, rutrum quam ac, fringilla risus. Phasellus non tincidunt leo, sodales venenatis nisl. Duis lorem odio, porta quis laoreet ut, tristique a justo. Morbi dictum dictum est ut facilisis. Duis suscipit sem ligula, at commodo risus pulvinar vehicula. Sed quis quam ac quam scelerisque dapibus id non justo. Sed mollis enim id neque tempus, a congue nulla blandit. Aliquam congue convallis lacinia. Aliquam commodo eleifend nisl a consectetur.\n\n    Maecenas sem nisl, adipiscing nec ante sed, sodales facilisis lectus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut bibendum malesuada ipsum eget vestibulum. Pellentesque interdum tempor libero eu sagittis. Suspendisse luctus nisi ante, eget tempus erat tristique sed. Duis nec pretium velit. Praesent ornare, tortor non sagittis sollicitudin, dolor quam scelerisque risus, eu consequat magna tellus id diam. Fusce auctor ultricies arcu, vel ullamcorper dui condimentum nec. Maecenas tempus, odio non ullamcorper dignissim, tellus eros elementum turpis, quis luctus ante libero et nisi.\n\n    Phasellus sed mauris vel lorem tristique tempor. Pellentesque ornare purus quis ullamcorper fermentum. Curabitur tortor mauris, semper ut erat vitae, venenatis congue eros. Ut imperdiet arcu risus, id dapibus lacus bibendum posuere. Etiam ac volutpat lectus. Vivamus in magna accumsan, dictum erat in, vehicula sem. Donec elementum lacinia fringilla. Vivamus luctus felis quis sollicitudin eleifend. Sed elementum, mi et interdum facilisis, nunc eros suscipit leo, eget convallis arcu nunc eget lectus. Quisque bibendum urna sit amet varius aliquam. In mollis ante sit amet luctus tincidunt."
		);
		

	}


	function init_old(){
		parent::init();
		$options = $this->options;
		// print_r($options);
		// exit;
		if($options['bold'] and !$options['italic']){
			if(file_exists(getcwd().'/epan-components/xShop/templates/fonts/'.$options['font'].'-Bold.ttf'))
				$options['font'] = $options['font'].'-Bold';
			// else
				// $draw->setFontWeight(700);
		}

		if($options['italic'] and !$options['bold']){
			if(file_exists(getcwd().'/epan-components/xShop/templates/fonts/'.$options['font'].'-Italic.ttf'))
				$options['font'] = $options['font'].'-Italic';
			else
				$options['font'] = $options['font'].'-Regular';
		}

		if($options['italic'] and $options['bold']){
			if(file_exists(getcwd().'/epan-components/xShop/templates/fonts/'.$options['font'].'-BoldItalic.ttf'))
				$options['font'] = $options['font'].'-BoldItalic';
			else
				$options['font'] = $options['font'].'-Regular';
		}
		if(!$options['bold'] and !$options['italic'])
			$options['font'] = $options['font'] .'-Regular';

		$font_path = getcwd().'/epan-components/xShop/templates/fonts/'.$options['font'].'.ttf';
		// echo $font_path;
		$p = new \PHPImage($options['desired_width'],10);
		$p->setFont($font_path);
		$p->setFontSize($options['font_size']);
	    $p->textBox($options['text'], array('width' => $options['desired_width'], 'x' => 0, 'y' => 0));
	    $size = $p->getTextBoxSize($options['font_size'], 0, $font_path, $p->last_text);

		$new_width = abs($size[0]) + abs($size[2]); // distance from left to right
		$new_height = abs($size[1]) + abs($size[5]); // distance from top to bottom

	    $p1 = new \PHPImage($options['desired_width'] , $new_height); 
	    $p1->setFont($font_path);
		$p1->setFontSize($options['font_size']);
	    $p1->setTextColor($p1->hex2rgb($options['text_color']));
	    // $p1->setAlignHorizontal('right');
	    $p1->textBox($options['text'], array('width' => $new_width, 'x' => 0, 'y' => 0));

		if($this->options['rotation_angle']){
			$p1->xRotate($this->options['rotation_angle']);
			// $p1->rotate($this->options['rotation_angle']);
		}
	    $this->phpimage = $p1;
	    $this->new_height = $new_height;

	}

	function show($type='png',$quality=3, $base64_encode=true, $return_data=false){
		$this->phpimage->setOutput('png',3);
		return $this->phpimage->show($base64_encode,$return_data);
	}
}