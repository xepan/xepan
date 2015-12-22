<?php

class page_test extends Page {

	function page_index(){
		
		$content = $this->drawCalendar('04','2016','');
		// $v = $this->add('View');
		// $v->setHtml($content);
		// echo $content;
		// $content = $this->drawCalendar('04','2016','');
		// echo $content;
		// exit;		//new FPDF_xPdf
		//Html2Pdf
		// file_put_contents("./templates/layout/test.html", $content);
		$content = file_get_contents("./templates/layout/test.html");

		$pdf = new TCPDF_TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetFont('times', 'BI', 20);
		// add a page
		$pdf->AddPage();
		$pdf->WriteHTML($content, true, false, true, false, '');
  		
		$pdfData = $pdf->Output(null,'S');

		//Convert PDF Data to Image Data
		$imageData = new Imagick();
	    $imageData->readimageblob($pdfData);

	    header('Expires: Wed, 1 Jan 1997 00:00:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
		header('Content-type: image/png');
		echo $imageData;
	}

	function drawCalendar($month,$year,$resultA,$events=[],$styles=[]){
		// style="text-align:left;"
		$header_font_size = 30;
		$day_date_font_size = 16;
		$day_name_font_size = 20;
		$event_font_size = 13;

		//Calculate Vertical Alignment as cellPadding
		//cell_paddding = cell_height / 2 - font_size / 2;

		$month_name_array = ['01'=>'January','1'=>'January','02'=>'February','2'=>'February','03'=>'March','3'=>'March','04'=>'April','4'=>'April','05'=>'May','5'=>'May','06'=>'June','6'=>'June','07'=>'July','7'=>'July','08'=>'August','8'=>'August','09'=>'September','9'=>'September','10'=>'October','11'=>'November','12'=>'December'];
		$month_name = $month_name_array[$month];
		if(is_array($styles)){
			$header_font_size = isset($styles['header_font_size'])?$styles['header_font_size']:30;
			$day_date_font_size = isset($styles['day_date_font_size'])?$styles['day_date_font_size']:16;
			$day_name_font_size = isset($styles['day_name_font_size'])?$styles['day_name_font_size']:20;
			$event_font_size = isset($styles['event_font_size'])?$styles['event_font_size']:13;
		}

		$cell_padding = 0;
		if($styles['valignment'] == 'middle')
			$cell_padding = (($styles['calendar_cell_heigth'] / 2) - ($day_date_font_size / 2));
		if($styles['valignment'] == 'bottom')
			$cell_padding = ( $styles['calendar_cell_heigth'] - $day_date_font_size);

  		/* draw table */
  		$calendar = '<div style="font-face:K010; font-family:K010; font-size:'.$header_font_size.'px;color:Black;">'.$month_name.' - '.$year.'</div>';
  		$calendar .= '<table cellspacing="0" class="calendar" width="100%" align="center" border="1">';
 		/* table headings */
  		$headings = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
  		$styles['day_name_bg_color'] = "red";
  		$calendar.= '<tr style="background-color:'.$styles['day_name_bg_color'].';font-size:'.$day_name_font_size.'px;color:'.$styles['day_name_font_color'].';" class="calendar-row"><td  class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';
  		$calendar.="</table>";

  		$calendar .= '<table cellspacing="0" class="calendar" width="100%" style="padding-top:'.$cell_padding.';" align="center" border="1">';
  		/* days and weeks vars now ... */
  		$running_day = date('w',mktime(0,0,0,$month,1,$year));
  		$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
  		$days_in_this_week = 1;
  		$day_counter = 0;

  		$styles['alignment'] = "left";
		 /* row for week one */
		$calendar.= '<tr class="calendar-row" style="text-align:'.$styles['alignment'].';">';
  		/* print "blank" days until the first of the current week */
  		$styles['calendar_cell_bg_color'] = "red";
  		for($x = 0; $x < $running_day; $x++){
    		$calendar.= '<td class="calendar-day-np" style="background-color:'.$styles['calendar_cell_bg_color'].'">&nbsp;</td>';
    		$days_in_this_week++;
  		}

		/* keep going with days.... */
		for($list_day = 1; $list_day <= $days_in_month; $list_day++){
			$styles['calendar_cell_bg_color'] = "red";
			$styles['calendar_cell_heigth'] = 40;
			$styles['day_date_font_color'] = "black";
		    $calendar.= '<td class="calendar-day" style="background-color:'.$styles['calendar_cell_bg_color'].';overflow:hidden; height:'.$styles['calendar_cell_heigth'].'; max-height:'.$styles['calendar_cell_heigth'].';font-size:'.$day_date_font_size.'px;color:'.$styles['day_date_font_color'].'">';
		    /* add in the day number */
		    $calendar.= '<div class="day-number">'.$list_day.'</div>';

		    $date=date('Y-m-d',mktime(0,0,0,$month,$list_day,$year));
		    
		    $event_date_format = date('d-F-Y',strtotime($date));
		    $styles['event_font_color'] = "black";
		    if($message = $events[$event_date_format]){
		    	$calendar .= '<small style="text-align:right; font-size:'.$event_font_size.'px;color:'.$styles['event_font_color'].'">'.$message."</small>";
		    }

		    $tdHTML='';
		    if(isset($resultA[$date])) $tdHTML=$resultA[$date];

		    $calendar.=$tdHTML;      

		    $calendar.= '</td>';

		    $styles['alignment']="left";

		    if($running_day == 6){
		      $calendar.= '</tr>';
		      if(($day_counter+1) != $days_in_month){
		        $calendar.= '<tr class="calendar-row" style="text-align:'.$styles['alignment'].';">';
		      	// echo "Day Counter=".$day_counter."Day in month =".$days_in_month."<br/>";
		      }

		      $running_day = -1;
		      $days_in_this_week = 0;
		    }
		    $days_in_this_week++; $running_day++; $day_counter++;
		 	
		}

      	// echo $calendar;
	  	/* finish the rest of the days in the week */
	  	$styles['calendar_cell_bg_color'] = "red";
	  	if($days_in_this_week < 8){	
	    	for($x = 1; $x <= (8 - $days_in_this_week); $x++){
	    		$calendar.= '<td class="calendar-day-np" style="background-color:'.$styles['calendar_cell_bg_color'].'">&nbsp;</td>';
	  		}
	  	}
	  	/* final row */
	  	$calendar.= '</tr>';
	  	/* end the table */
	  	$calendar.= '</table>';
	  	/* all done, return result */
	  	return $calendar;
	}

	function draw_calendar($month,$year,$resultA){
  		/* draw table */
  		$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';
 		/* table headings */
  		$headings = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
  		$calendar.= '<tr class="calendar-row"><td class="calendar-day-head" style="background-color:green;">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';
  		
  		/* days and weeks vars now ... */
  		$running_day = date('w',mktime(0,0,0,$month,1,$year));
  		$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
  		$days_in_this_week = 1;
  		$day_counter = 0;

		 /* row for week one */
		$calendar.= '<tr class="calendar-row">';
  		/* print "blank" days until the first of the current week */
  		for($x = 0; $x < $running_day; $x++){
    		$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
    		$days_in_this_week++;
  		}

		/* keep going with days.... */
		for($list_day = 1; $list_day <= $days_in_month; $list_day++){

		    $calendar.= '<td class="calendar-day">';
		    /* add in the day number */
		    $calendar.= '<div class="day-number">'.$list_day.'</div>';

		    $date=date('Y-m-d',mktime(0,0,0,$month,$list_day,$year));

		    $tdHTML='';        
		    if(isset($resultA[$date])) $tdHTML=$resultA[$date];

		    $calendar.=$tdHTML;      

		    $calendar.= '</td>';

		    if($running_day == 6){
		      $calendar.= '</tr>';
		      if(($day_counter+1) != $days_in_month)
		        $calendar.= '<tr class="calendar-row">';

		      $running_day = -1;
		      $days_in_this_week = 0;
		    }
		    $days_in_this_week++; $running_day++; $day_counter++;
		 	
		}

	  	/* finish the rest of the days in the week */
	  	if($days_in_this_week < 8){	
	    	for($x = 1; $x <= (8 - $days_in_this_week); $x++){
	    		$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
	  		}
	  	}

	  	/* final row */
	  	$calendar.= '</tr>';

	  	/* end the table */
	  	$calendar.= '</table>';

	  	/* all done, return result */
	  	return $calendar;
	}

	function page_deleteAllDesign(){

		$item = $this->add('xShop/Model_Item');
		$item->addCondition('website_display',true);
		$item->addCondition('is_designable',true);
		$item->addCondition('is_template',false);
		
		$item->each(function($itm){
			echo "Item Name = ".$itm['name']." id == ".$itm['id']."<br/>";
			$itm->forceDelete();
		});
		
		$items = $this->add('xShop/Model_Item');
		$items->addCondition('is_designable',true);
		$items->addCondition('is_saleable',false);
		$items->addCondition('is_template',false);
		foreach ($items as $it) {
			echo "Item Name = ".$it['name']." id == ".$it['id']."<br/>";
			$items->forceDelete();
		}
		

		// throw new \Exception($item->count()->getOne());
		
	}


	function page_activitylog(){
		$this->add('View_ActivityLog');
	}

	function page_updatesearchstring(){
		// set_time_limit(0);

		// create FULLTEXT index
		// $docs = $this->add('xHR/Model_Document')->getDefaults();
		// $class_array = [];
		// foreach ($docs as $doc) {			
		// 	$array = explode('\\', $doc['name']);
		// 	$array2= explode("_", $array[1]);
			

		// 	if($array2[0]=='Jobcard') $array2[0] = 'JobCard';
		// 	if($array[0]=="xPurchase" and $array2[0] == "Invoice") $array2[0] = "PurchaseInvoice";
		// 	if($array[0]=="xShop" and $array2[0] == "Invoice") $array2[0] = "SalesInvoice";

		// 	$class_name = $array[0]."/Model_".$array2[0];
		// 	// echo $class_name." ".var_dump($class_array)."<br/>";
		// 	if(in_array($class_name, $class_array))
		// 		continue;

		// 	$root_model = $this->add($class_name);
		// 	try{
		// 		$this->api->db->dsql()->expr("CREATE FULLTEXT INDEX search_string_index ON ". $root_model->table . "(search_string);")->execute();
		// 	}catch(Exception $e){

		// 	}
		// }

		// return;

		$activities = $this->add('xCRM/Model_Activity');
		$activities->addExpression('ss')
			->set(
				$activities->dsql()->expr(
					'CONCAT("Activity: ",[8]," ",[0]," ",IFNULL([1],"")," ",IFNULL([2],"")," ",IFNULL([3],"")," ",IFNULL([4],"")," ",IFNULL([5],"")," ",IFNULL([6],"")," ",IFNULL([7],""))',
					[
						$activities->getElement('action'),
						$activities->getElement('created_at'),
						$activities->getElement('from'),
						$activities->getElement('action_from'),
						$activities->getElement('to'),
						$activities->getElement('action_to'),
						$activities->getElement('subject'),
						$activities->getElement('message'),
						$activities->getElement('related_root_document_name'),

					]
			)
		);

		$activities->_dsql()->set('search_string',$activities->dsql()->expr('[0]',[$activities->getElement('ss')]))->debug()->update();

		return;


		$docs = $this->add('xHR/Model_Document')->getDefaults();
		$class_array = [];
		foreach ($docs as $doc) {			
			$array = explode('\\', $doc['name']);
			$array2= explode("_", $array[1]);
			
			if(strtolower($array2[0])=='activity') continue;

			if($array2[0]=='Jobcard') $array2[0] = 'JobCard';
			if($array[0]=="xPurchase" and $array2[0] == "Invoice") $array2[0] = "PurchaseInvoice";
			if($array[0]=="xShop" and $array2[0] == "Invoice") $array2[0] = "SalesInvoice";

			$class_name = $array[0]."/Model_".$array2[0];
			// echo $class_name." ".var_dump($class_array)."<br/>";
			if(in_array($class_name, $class_array))
				continue;

			$root_model = $this->add($class_name);
			$root_model->addCondition('search_string',Null);

			foreach ($root_model as $model) {
				$array = explode('\\', $doc['name']);
				$array2= explode("_", $array[1]);
				
				if($array2[0]=='Jobcard') $array2[0] = 'JobCard';
				if($array[0]=="xPurchase" and $array2[0] == "Invoice") $array2[0] = "PurchaseInvoice";
				if($array[0]=="xShop" and $array2[0] == "Invoice") $array2[0] = "SalesInvoice";

				$class_name = $array[0]."/Model_".$array2[0];
				$this->add($class_name)->load($model->id)->save();
				echo $class_name. " " . $model->id ."<br/>";
				ob_flush();
			}

			$class_array[] = $class_name;

		}

	}

	function page_notify(){
		$this->js(true)
			->_load('pnotify.custom.min')
			->_load('xepan.pnotify')
			->_css('pnotify.custom.min')
			->_library('PNotify.desktop')->permission();

		$this->add('Button')
			->set('Notify')
			->js('click')->univ()->notify("Heading","this is a message for notification",'success',true,$this->js()->alert('Clicked')->_enclose());

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
