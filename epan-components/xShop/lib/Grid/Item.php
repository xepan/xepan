<?php

namespace xShop;

class Grid_Item extends \Grid{
	function init(){
		parent::init();
		
		$this->add_sno();
		$this->addQuickSearch(array('sku','name','sale_price'));
		$this->addPaginator($ipp=100);
		$self = $this;
	}


	function setModel($m,$fields){
		parent::setModel($m,$fields);
		//$this->addColumn('expander','details');
		// $this->addColumn('expander','categories');
		// $this->addColumn('expander','custom_fields',array("descr"=>"Custom Fields",'icon'=>'cog','icon_only'=>true));
		// $this->addColumn('expander','specifications',array("descr"=>"Specfications",'icon'=>'cog','icon_only'=>true));
		// $this->addColumn('expander','images',array("descr"=>"Images",'icon'=>'picture','icon_only'=>true));
		// $this->addColumn('expander','attachments',array("descr"=>"Docs",'icon'=>'folder','icon_only'=>true));
		// $this->addColumn('expander','rate_effect',array("descr"=>"Rate Effect",'icon'=>'cog','icon_only'=>true));
		// $this->addColumn('pics_docs','pics_docs','Pics / Docs');
		
		$this->addColumn('Button','duplicate',array("descr"=>"Duplicate",'icon'=>'cog','icon_only'=>true));

		if($_GET['duplicate']){
			try{
				$this->api->db->beginTransaction();
				$this->add('xShop/Model_Item')->load($_GET['duplicate'])->duplicate(false);
				$this->api->db->commit();
			}catch(\Exception $e){
				$this->api->db->rollback();
				if($this->api->getConfig('developer_mode'))
					throw $e;
				else
					$this->js()->univ()->errorMessage($e->getMessage())->execute();
			}
			$this->js()->reload()->execute();
		}

	}
	function recursiveRender(){
		// $this->addMethod('format_name',function($g,$f){
		// 	$g->current_row_html[$f]='<a href="javascript:void(0)" onclick="'.$g->js()->univ()->frameURL($g->model['name']." Details",'index.php?page=xShop_page_owner_item_details&cut_page=1&xshop_items_id='.$g->model->id).'">'.$g->current_row[$f].'</a>';
		// });
		// $this->addFormatter('name','name');
		parent::recursiveRender();
	}

	function init_pics_docs($field){
	    $this->columns[$field]['tpl']=$this->add('GiTemplate')->loadTemplate('column/item-grid');

	    $m=$this->model;

	    $do_flag = $this->add('VirtualPage')->set(function($p)use($m){
	        $name=$m->load($_GET['id'])->get('name');
	        // $m->flag();
	        return $p->js()->univ()->alert('You have flagged '.$name)->execute();
	    });

	    $this->on('click','.do-set-default')->univ()->ajaxec(array($do_flag->getURL(), 'id'=>$this->js()->_selectorThis()->closest('tr')->data('id')));
	}
	function format_pics_docs($field){
	    $this->current_row_html[$field] = $this->columns[$field]['tpl']->render();
	}

}