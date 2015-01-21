<?php

class page_image extends Page{

	function init(){
		parent::init();

		$image_url = 'templates/images/logo.png';
		$anotate = '';
		$width=0;
		$height=0;

		if($_GET['image']){
			$image_url = $_GET['image'];
			$image_url = trim($image_url,'/');
		}



		if(file_exists($path=getcwd().'/../'.$image_url)){
		}elseif(file_exists($path=getcwd().'/'.$image_url)){
		}else{
			$image_url = 'templates/images/logo.png';
			$anotate = 'Image Not Found '. $path;
		}

		if($_GET['width'])
			$width = $_GET['width'];

		if($_GET['height'])
			$height = $_GET['height'];
		
		$image = new Imagick($path);


		if($width == $height AND $width == 0){
			$d = $image->getImageGeometry();
			$width = $d['width'];
			$height = $d['height']; 
		}

		$image->scaleImage($width,$height);

		header('Content-type: image/jpeg');
		echo $image;
		exit;
	}

}