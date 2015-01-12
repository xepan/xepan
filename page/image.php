<?php

class page_image extends Page{

	function init(){
		parent::init();

		$image_url = 'templates/images/logo.png';
		$anotate = '';
		$width=0;
		$height=0;

		if($_GET['image'])
			$image_url = $_GET['image'];

		if(!file_exists(getcwd().'/'.$image_url)){
			$image_url = 'templates/images/logo.png';
			$anotate = 'Image Not Found';
		}

		if($_GET['width'])
			$width = $_GET['width'];

		if($_GET['height'])
			$height = $_GET['height'];

		$image = new Imagick(getcwd().'/'.$image_url);

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