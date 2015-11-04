<?php

namespace xShop;

class Controller_RenderCalendar extends \AbstractController {
	public $options = array();
	public $phpimage;
	public $pdf;

	function init(){
		parent::init();

		$all_events = json_decode($this->options['events'],true);
		$current_month_events = [];
		if(count($all_events[$this->options['month']]))
			$current_month_events = $all_events[$this->options['month']];

		$calendar_html = $this->drawCalendar($this->options['month'],$this->options['year'],[],$current_month_events);
		// throw new \Exception($cale);
		
		
		//Convert Html to PDF
		$this->convertHtmlToPdf($calendar_html);
		//Convert PDF Data to Image Data
		$this->convertPdfToImage($this->pdf);

	}

	function convertPdfToImage($pdfData){
		$imageData = new \Imagick();
	   	$imageData->readimageblob($pdfData);
	   	$this->phpimage = $imageData;
	}

	function convertHtmlToPdf($html){
		if(!$html)
			throw new \Exception("Html Not Given");

		$pagelayout = array($this->options['height'],$this->options['width']); //  or array($height, $width)
		$pdf = new \TCPDF_TCPDF('l', 'pt', $pagelayout, true, 'UTF-8', false);
		$pdf->SetMargins(0, 0, 0);
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);
		// $pdf = new \TCPDF_TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetFont('freemono', 'BI', 20);
		// add a page
		$pdf->AddPage();
		$pdf->WriteHTML($html, true, false, true, false, '');
		$this->pdf = $pdf->Output(null,'S');
	}

	function drawCalendar($month,$year,$resultA,$events=[]){



  		/* draw table */
  		$calendar = '<div>'.$month.' - '.$year.'</div>';
  		$calendar .= '<table cellpadding="0" cellspacing="0" class="calendar" width="100%">';
 		/* table headings */
  		$headings = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
  		$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';
  		
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
		    
		    $event_date_format = date('d-F-Y',strtotime($date));
		    if($message = $events[$event_date_format]){
		    	$calendar .= '<small style="font-size:6px;">'.$message."</small>";
		    }

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

	function show($type="png",$quality=3,$base64_encode=true, $return_data=false){
		// ob_start();
		// imagepng($this->phpimage, null,9,PNG_ALL_FILTERS);
		// $imageData = ob_get_contents();
		// ob_clean();

		// $this->cleanup();
		$imageData = $this->phpimage;

		if($base64_encode)
			$imageData = base64_encode($imageData);
		
		if($return_data)
			return $imageData;

		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
		if($type="png")
			header("Content-type: image/png");
		// imagepng($this->phpimage, null, 9, PNG_ALL_FILTERS);
		
		echo $imageData;
		die();
	}

	public function cleanup(){
		imagedestroy($this->phpimage);
	}
}