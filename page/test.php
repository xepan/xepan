<?php


class page_test extends Page {

	function page_index(){
		$l = $this->api->locate('addons', 'autocomplete', 'location');
        $addon_location = $this->api->locate('addons', 'autocomplete');

        $this->api->pathfinder->addLocation(array(
            'js'=>'js',
            'css'=>'templates/css'
            ))
            ->setBasePath($this->api->pathfinder->base_location->base_path.'/'.$addon_location)
            ->setBaseURL($this->api->pm->base_path.'/'.$addon_location);
        ;

		$form = $this->add('Form');

		$field = $form->addField('line','abcd');

		$m = $this->add('Model');
		$m->addField('id');
		$m->addField('name');

		$m->setSource('Array',[
				['id'=>1,'name'=>'ramlal'],
				['id'=>2,'name'=>'shyamlal'],
				['id'=>2,'name'=>'ghanshaymlal']
			]
		);

		$field->setModel($m);

		$field->js(true)
            ->_load('autocomplete_univ6')
            ->_css('autocomplete')
            ->univ()
            ->myautocomplete($this->api->url(), $field, [], 'id', 'name');


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
		else
			$this->app->layout->template->tryDel('page_title');
	}

	function page_layout(){
		if($_GET['name']){
			$this->template->loadTemplate($_GET['name']);
		}
	}

	function page_mask(){
		
		$this->template->loadTemplate('page/temp');

		$this->add('View')->setElement('img')->setAttr('src',$this->api->url(null,['img'=>1]));

		if($_GET['img']){

			$source = imagecreatefrompng( '/var/www/xerp/upload/0/source.png' );
			$xSize = imagesx( $source );
		    $ySize = imagesy( $source );
			
			$newPicture = imagecreatetruecolor( $xSize, $ySize );
		    imagealphablending($newPicture, false);
		    imagefill( $newPicture, 0, 0, imagecolorallocatealpha( $newPicture, 255, 255, 255, 0 ) );
		    imagesavealpha($newPicture, true);

			$mask = imagecreatefrompng( '/var/www/xerp/upload/0/checker.png' );
			imagecopymerge($newPicture, $mask, 0, 0, 0, 0, $xSize , $ySize, 100);
			$mask = $newPicture;
			
			$picture_temp = imagecreatetruecolor( $xSize, $ySize );
		    imagefill( $picture_temp, 0, 0, imagecolorallocatealpha( $picture_temp, 255, 255, 255, 127 ) );
		    imagealphablending($picture_temp, false);
		    imagesavealpha($picture_temp, true);
		    for($x=0;$x< $xSize;$x++)
			    for($y=0;$y< $ySize;$y++){
			    	$mcolor=imagecolorsforindex( $mask, imagecolorat( $mask, $x, $y ) );
			    	if($mcolor['red']==255 && $mcolor['green']==255 && $mcolor['blue']==255){
				    	$color=imagecolorsforindex( $source, imagecolorat( $source, $x, $y ) );
					    $red = imagecolorallocate($picture_temp, $color['red'], $color['green'], $color['blue']); 
				    	imagesetpixel($picture_temp, $x, $y, $red);
			    	}
			    }

			header( "Content-type: image/png");
			imagepng( $picture_temp );
			exit;

		}

		if($_GET['img']){
			$source = imagecreatefrompng( '/home/adam/Pictures/source.png' );
			$this->magealphamask( $source, $mask );
			header( "Content-type: image/png");
			imagepng( $source );
			exit;
		}
	}

	function magealphamask(&$picture, $mask){
		//Get With and Height of Merged Image
		$xSize = imagesx( $picture );
	    $ySize = imagesy( $picture );

	    $posX = 0;
	    $posY = 0;

	    // Step 0 .. create a alpha channel image
	    $picture_temp = imagecreatetruecolor( $xSize, $ySize );
	    imagealphablending($picture_temp, false);
	    imagesavealpha($picture_temp, true);

		//Step 1
			// Create a new Temp image having width and height same as original picture 
		    $newPicture = imagecreatetruecolor( $xSize, $ySize );
		    imagealphablending($newPicture, false);
	    	//and having background color transparent
		    imagefill( $newPicture, 0, 0, imagecolorallocatealpha( $newPicture, 255, 255, 255, 0 ) );
		    imagesavealpha($newPicture, true);
		//Step 2
			// Merge mask image to Temp Image, according to x and y cordinates width
		    imagealphablending($newPicture, true);
			imagecopymerge($newPicture, $mask, 0, 0, 0, 0, $xSize , $ySize, 100);
			// and Result will be temp image
		//Step 3
			// In a FOR Loop of original picture widtha and height
			for( $x = 0; $x < $xSize; $x++ ) {
		    	for( $y = 0; $y < $ySize; $y++ ) {
		    		//if pixel of temp image at x and y is white
					$alpha = imagecolorsforindex( $newPicture, imagecolorat( $newPicture, $x, $y ) );
					$orig = imagecolorsforindex( $picture, imagecolorat( $picture, $x, $y ) );
					$transparency = imagecolorallocatealpha($picture, $orig['red'],$orig['green'],$orig['blue'], (765-($alpha['red'] + $alpha['green'] + $alpha['blue']))/765 * 127);
					// Make the background transparent
	                imagesetpixel( $picture_temp, $x, $y, $transparency); // Stick a black, but totally transparent, pixel in.
	    			//then set transparent pixel of original picture at same x and y
		    	}
		    }

		// Destroying the new created image
		    $picture = $picture_temp;
	    imagedestroy($newPicture);
	}

}
