<?php

class page_xShop_page_owner_font extends page_xShop_page_owner_main{
	function init(){
		parent::init();

	      $com_btn=$this->add('xShop/View_FontUpload');
    		$this->api->addLocation(array(
                    'ttf'=>array('epan-components/xShop/templates/fonts')
                    ))->setParent($this->api->pathfinder->base_location);

        $p=$this->api->pathfinder->searchDir('ttf','.');
        sort($p);
        $font_array=array();

        foreach ($p as  $junk) {
           $font_name = explode(".", $junk);
           // $font_name = $font_name[0];
           if(!in_array($font_name, $font_array)){
               $font_array[]=$font_name;
           }
        }
           	
        if(count($font_array)){
           	$font_array=array_combine(range(1, count($font_array)), $font_array);
        }

        $m= $this->add('Model');
        $m->setSource('Array',$font_array);

        $grid = $this->add('Grid');
        $grid->setModel($m);
        if($font_name= $_GET['delete']){
          	$delete_font = $font_array[$_GET['delete']][0];
           	$delete_font = trim($delete_font).".ttf";
    		    $font_path = getcwd().DS.'epan-components'.DS.'xShop'.DS.'templates'.DS.'fonts'.DS.$delete_font;
            if (file_exists($font_path)){
    		      unlink($font_path);				
       			  $grid->js(true,$grid->js()->univ()->errorMessage("Deleted"))->univ()->reload()->execute();
            }
        }
           		
    	  $grid->addColumn("Font");
    	  $grid->addMethod('format_Font',function($g,$f)use($font_array){
    	   $g->current_row_html[$f] = $font_array[$g->model->id][0];
    	  });       
        $grid->addFormatter('Font','Font');
    	  $grid->addColumn('Button','Delete');
        // $grid->addPaginator(100);
	}
}