<?php

class page_xShop_page_designer_calendar extends Page {
  public $start_year=2000; // Starting year for dropdown list box
  public $end_year=2020;   // Ending year for dropdown list box
	
  function init(){
		parent::init();  
      $date=$this->api->today;
      $y=date('Y',strtotime($date));
      for ($i=$this->end_year; $i >=$this->start_year ; $i--) { 
        $years[$i]=$i;
      }

    $this->api->stickyGET('month');
    $this->api->stickyGET('years');
    $this->api->stickyGET('events');
    $this->api->stickyGET('from_date');
    $this->api->stickyGET('to_date');


      $month=array( '01'=>"January",'02'=>"February",'03'=>"March",'04'=>"April",
          '05'=>"May",'06'=>"Jun",'07'=>"July",'08'=>"August",'09'=>"September",
          '10'=>"October",'11'=>"November",'12'=>"December");


      $form=$this->add('Form',null,null,array('form/horizontal'));
      $form->addField('DropDown','month')->setValueList($month)->setEmptyText('Please Select Month');
      $form->addField('DropDown','year')->setValueList($years)->setEmptyText('Please Select Year');
      $form->addField('line','events');
      $form->addField('DatePicker','from_date');
      $form->addField('DatePicker','to_date');
      $form->addSubmit('Get Calendar');
      
      $view=$this->add('xShop/View_Lister_designerCalendar',array('month'=>$_GET['month'],
                                                            'years'=>$_GET['years'],
                                                            'events'=>$_GET['events'],
                                                            'from_date'=>$_GET['from_date'],
                                                            'to_date'=>$_GET['to_date']));//->getHtml();

      if($form->isSubmitted()){
          // echo "string".$_GET['month'];
          // echo "string".$_GET['years'];
          // echo "string".$_GET['from_date'];
          // echo "string".$_GET['to_date'];

          $form->js(null,$view->js()->reload())->reload(array('month'=>$form['month'],
                                    'years'=>$form['years'],
                                    'events'=>$form['events'],
                                    'from_date'=>$form['from_date'],
                                    'to_date'=>$form['to_date'],
                                      ))->execute();
      }
  }

  // function defaultTemplate(){
  //   $this->app->pathfinder->base_location->addRelativeLocation(
  //       'epan-components/xShop', array(
  //           'php'=>'lib',
  //           'template'=>'templates',
  //           'css'=>array('templates/css','templates/js'),
  //           'img'=>array('templates/css','templates/js'),
  //           'js'=>'templates/js',
  //       )
  //   );
  //     return array('view/calendar/calendar');
  // }
}    