<?php


class page_test extends Page {

	function page_index(){
		$this->add('Button')->set('clickme')->js('click')->univ()->successMessage("SDSDS");
	}

	function page_cst_organization_name_update(){

		$cst = $this->add('xShop/Model_Customer')->each(function($obj){
			if(!$obj['organization_name']){
				$obj['organization_name'] = $obj['customer_name'];
				$obj->save();
			}

		});

	}

	function page_defdocwrite(){
		$filename = getcwd().'/epan-components/xHR/default-documents.xepan';
		$d= $this->add('xHR/Model_Document');
		$arr = $d->getRows();
		file_put_contents($filename, json_encode($arr));

	}
	

	function page_setepanid(){
		$tables = $this->api->db->dsql()->expr('SHOW TABLES');
		foreach ($tables as $table) {
			$fields = $this->api->db->dsql()->describe($table['Tables_in_'.$this->api->db->dbname]);
			foreach ($fields as $field) {
				$key = isset($field['name']) ? $field['name'] : $field['Field'];
				if($key=='epan_id'){
					// echo "doing in ". $table['Tables_in_nebula'] .'<br/>';
					$this->api->db->dsql()->table($table['Tables_in_'.$this->api->db->dbname])->set('epan_id',1)->update();
					continue;
				}
			}
		}
	}

	function page_toword(){
		// $d = $this->add('xShop/Model_Order');
		// echo $d->convert_number_to_words(200);
		require('System.php');
		var_dump(class_exists('System', false));

		// require('Numbers/Words.php');
		// $nw = new Numbers_Words();
		// echo $nw->toWords(200);
	}

	// function page_invremove(){
	// 	$this->add('xShop/Model_SalesInvoice')->each(function ($obj){
	// 		echo $obj['name'];
	// 		$obj->forceDelete();
	// 	});

	// 	$i=0;
	// 	$this->add('xAccount/Model_Transaction')->each(function ($obj)use(&$i){
	// 		echo $obj['name']."<br>";
	// 		$obj->forceDelete();
	// 		$i++;
	// 	});

	// 	echo $i;


	// }
	

	function page_leadcatasso(){

		$leads = $this->add('xEnquiryNSubscription/Model_Subscription')->addCondition('from_app','Customer');
		foreach ($leads as $l) {
			$asso = $this->add('xEnquiryNSubscription/Model_SubscriptionCategoryAssociation');
			$asso['subscriber_id'] = $l->id;
			$asso['subscribed_on'] = $l['created_at'];
			$asso['send_news_letters'] = true;
			$asso['category_id'] = 4;
			$asso->save();

		}
	}

	function page_cssicons(){
		// $contents = ".abc {def}";
		//Grab contents of css file
		$contents = file_get_contents('templates/css/compact.css');

		preg_match_all( "/\icon-[aA-zZ]*/", $contents , $match1);
		preg_match_all( "/\icon-[aA-zZ]*-[aA-zZ]*/", $contents , $match2);
		preg_match_all( "/\icon-[aA-zZ]*-[aA-zZ]*-[aA-zZ][0-9]*/", $contents , $match3);
		// echo "<pre>";
		// print_r( $match);
		// echo "</pre>";
		$match = array_merge($match1,$match2,$match3);

		foreach ($match as $array => $value) {
			foreach ($value as $c) {
				$s = '<div class="atk-box pull-left"><i class="'.$c.' atk-size-mega"> '.$c.'</i></div>';
				$this->add('View')->setHTML($s);
				// $str = '<i class="'.$c.'" ></i>'; 
				// $this->addText()
			}
		}
	}


	function page_createImageFromDesign(){

		$items = $this->add('xShop/Model_Item');
		$items->addCondition('duplicate_from_item_id','>',0);
		
		foreach ($items as $item){
			$item->updateFirstImageFromDesign();
		}

	}
function page_owner_layout(){

		$this->js(true)->_load('jquery.sparkline.min')->_selector('.sparklines')->sparkline('html',['enableTagOptions'=>true]);

		if($_GET['name']){
			$this->template->loadTemplate($_GET['name']);
		}

		if($_GET['title'])
			$this->app->layout->template->trySetHTML('page_title',"<i class='".$_GET['icon']."'></i> " . $_GET['title']);
	}

	function page_layout(){
		if($_GET['name']){
			$this->template->loadTemplate($_GET['name']);
		}
	}

	function page_mask(){
		// Set image path

		// Create new objects from png's
		// $path = '/home/adam/Pictures/';
		// $dude = new Imagick($path . 'U0R4F.png');
		// $mask = new Imagick($path . 'mask.png');

		// // IMPORTANT! Must activate the opacity channel
		// // See: http://www.php.net/manual/en/function.imagick-setimagematte.php
		// // $dude->setImageMatte(1); 

		// // Create composite of two images using DSTIN
		// // See: http://www.imagemagick.org/Usage/compose/#dstin
		// // $dude->resizeImage(274, 275, Imagick::FILTER_LANCZOS, 1);
		// $dude->compositeImage($mask, Imagick::COMPOSITE_DSTIN, 0, 0);
		// // $dude->radialBlurImage(20);
		// // Write image to a file.
		// // $dude->writeImage($path . 'newimage.png');

		// // And/or output image directly to browser
		// header("Content-Type: image/png");
		// echo $dude;

		$source = imagecreatefrompng( '/var/www/xerp/upload/0/source.png' );
		$mask = imagecreatefrompng( '/var/www/xerp/upload/0/mask.png' );
		$this->magealphamask( $source, $mask );
		header( "Content-type: image/png");
		imagepng( $source );
	
	}

	function magealphamask(&$picture, $mask){
		//Get With and Height of Merged Image
		$xSize = imagesx( $picture );
	    $ySize = imagesy( $picture );

	    $posX = 0;
	    $posY = 0;

		//Step 1
			// Create a new Temp image having width and height same as original picture 
		    $newPicture = imagecreatetruecolor( $xSize, $ySize );
		    imagealphablending($newPicture, false);
	    	//and having background color transparent
		    imagefill( $newPicture, 0, 0, imagecolorallocatealpha( $newPicture, 0, 0, 0, 127 ) );
		    imagesavealpha($newPicture, true);
		//Step 2
			// Merge mask image to Temp Image, according to x and y cordinates width
			imagecopymerge($newPicture, $mask, $posX, $posY, 0, 0, $xSize,$ySize, 100);
			// and Result will be temp image
		    // $picture = $newPicture;
		    // return;
		//Step 3
			// In a FOR Loop of original picture widtha and height
			for( $x = 0; $x < $xSize; $x++ ) {
		    	for( $y = 0; $y < $ySize; $y++ ) {
		    		//if pixel of temp image at x and y is white
					$alpha = imagecolorsforindex( $newPicture, imagecolorat( $newPicture, $x, $y ) );
					if(($alpha['red'] == 255) && ($alpha['green'] == 255) && ($alpha['blue'] == 255) && ($alpha['alpha'] == 0)){
						// Make the background transparent
						$transparency = imagecolorallocatealpha($picture, 0, 0, 0, 127);
		                imagesetpixel( $picture, $x, $y, $transparency); // Stick a black, but totally transparent, pixel in.
		    			//then set transparent pixel of original picture at same x and y
		            }
		    	}
		    }
		// Destroying the new created image
	    imagedestroy($newPicture);
	}

}
