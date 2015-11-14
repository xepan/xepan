<?php


namespace xShop;

class View_FontUpload extends \View{
	function init() {
		parent::init();

			$target_dir = getcwd().DS.'epan-components'.DS.'xShop'.DS.'templates'.DS.'fonts'.DS;
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$fontFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
				$font_format= explode('-', $target_file);

				if(! in_array($font_format[2], array('Regular.ttf','Bold.ttf','Italic.ttf','BoldItalic.ttf'))){
					$this->api->js(true,$this->js()->reload())->univ()->errorMessage('Wrong Font name ');
					$uploadOk=0;
					echo $font_format[2];
				}
				if (file_exists($target_file)) {
				    $this->api->js(true)->univ()->errorMessage('File Already Exist');
				    $uploadOk = 0;
				}
				if($fontFileType != "ttf") {
				    $this->api->js(true)->univ()->errorMessage('Only ttf file is upload');
				    $uploadOk = 0;
				}
				if ($uploadOk == 1) {
			    	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				    	$this->api->js(true,$this->js()->reload())->univ()->successMessage('Font File '.basename( $_FILES["fileToUpload"]["name"]." has been uploded"));
						
						/*TTF File To Convert & create TCPDF Font file*/	
						$pdf = new \TCPDF_TCPDF('l', 'pt', '', true, 'UTF-8', false);
					    $fontname = \TCPDF_FONTS::addTTFfont($target_file, 'TrueTypeUnicode', '',32);
					    $pdf->AddFont($fontname, '', 14, '', false);

			    	} else {
					    $this->api->js(true)->univ()->errorMessage('Sorry, there was an error uploading your file');
			    	} 
				}
			}
	}
	function defaultTemplate() {

		$this->app->pathfinder->base_location->addRelativeLocation(
		    'epan-addons/'.__NAMESPACE__, array(
		        'php'=>'lib',
		        'template'=>'templates',
		        'css'=>'css',
		        'js'=>'js',
		    )
		);

		return array( 'view/fontupload' );
	}
}			