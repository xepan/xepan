<?php

namespace xShop;

class Grid_Blog extends \Grid{
	function init(){
		parent::init();
		
		$this->add_sno();
		$this->addPaginator($ipp=100);
		$self = $this;

		// $this->add('VirtualPage')->addColumn('Details','Details',array('icon'=>'edit'),$this)->set(function($p){
		// 	$selected_item = $p->add('xShop/Model_Item')->load($p->id);
		
		// 	$filter_box = $p->add('View_Box')->setHTML('Item :: <b>'.$selected_item['name'].'</b>');

		// 	$tab = $p->add('Tabs');
		// 	$tab->addTabURL($p->api->url('xShop/page/owner/item_basic',array('item_id'=>$p->id)),'Basic');
		// 	// $tab->addTabURL($p->api->url('xShop/page/owner/item_attributes',array('item_id'=>$p->id)),'Attributes');
		// 	// $tab->addTabURL($p->api->url('xShop/page/owner/item_qtyandprice',array('item_id'=>$p->id)),'Qty & Price');
		// 	// $tab->addTabURL($p->api->url('xShop/page/owner/item_media',array('item_id'=>$p->id)),'Media');
		// 	// $tab->addTabURL($p->api->url('xShop/page/owner/item_category',array('item_id'=>$p->id)),'Category');
		// 	// $tab->addTabURL($p->api->url('xShop/page/owner/item_affliate',array('item_id'=>$p->id)),'Affiliate');
		// 	// $tab->addTabURL($p->api->url('xShop/page/owner/item_preview',array('item_id'=>$p->id)),'Preview');
		// 	// $tab->addTabURL($p->api->url('xShop/page/owner/item_seo',array('item_id'=>$p->id)),'SEO');
		// 	// $tab->addTabURL($p->api->url('xShop/page/owner/item_stock',array('item_id'=>$p->id)),'Stock');
		// 	// $tab->addTabURL($p->api->url('xShop/page/owner/item_prophases',array('item_id'=>$p->id)),'Production Phases');
		// 	// $tab->addTabURL($p->api->url('xShop/page/owner/item_account',array('item_id'=>$p->id)),'Accounts');
		// 	// $tab->addTabURL('xShop/page/owner/item_composition','Composition',array('item_id'));
		// });

		$this->addColumn('image');
	}

	function setModel($m,$fields=null){
		parent::setModel($m,$fields);
		
		//Duplicate Function
		// $this->addColumn('Button','duplicate',array("descr"=>"Duplicate",'icon'=>'cog','icon_only'=>true));

		// if($_GET['duplicate']){
		// 	try{
		// 		$this->api->db->beginTransaction();
		// 		$this->add('xShop/Model_Item')->load($_GET['duplicate'])->duplicate(false);
		// 		$this->api->db->commit();
		// 	}catch(\Exception $e){
		// 		$this->api->db->rollback();
		// 		if($this->api->getConfig('developer_mode'))
		// 			throw $e;
		// 		else
		// 			$this->js()->univ()->errorMessage($e->getMessage())->execute();
		// 	}
		// 	$this->js()->reload()->execute();
		// }
		
		//Quick Search
		if(!$fields)
			$fields = $this->model->getActualFields();
		$this->addQuickSearch($fields,null,'xShop/Filter_Blog');

	}

	function recursiveRender(){
		$cat_btn = $this->addButton('Blog Category Management');
		if($cat_btn->isClicked()){
			$this->js()->univ()->frameURL('Blog Category',$this->api->url('xShop_page_owner_blogcategory'))->execute();
		}

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

	function removeColumns($columns){
		foreach ($columns as $column) {
			if($this->hasColumn($column))$this->removeColumn($column);
		}

	}

	function formatRow(){
		//Publish
		$designer = "";
		if($designer = $this->model['designer'])
			$designer = 'Designer: '.$designer;

		$template_html = "";
		if($this->model['is_publish'])
			$this->setTDParam('name','class','atk-effect-success');
		else
			$this->setTDParam('name','class','');

		//Designable Item
		if($this->model['is_template']){
			$title = "Template ( Designer :: ".$designer.")";
			$this->setTDParam('name','title',$title);
			$template_html='<i class="icon-edit"></i>';
		}

		$this->current_row_html['name'] = '<span class="atk-size-mega">'.$template_html.$this->current_row['name'].'</span></span>'.'<span class="pull-right" title="Code">'.$this->current_row['sku'].'</span><br>';//.$options.'<br>'.$designer;
		

		//Item Image Formatter
		$img_url = "epan-components/xShop/templates/images/item_no_image.png";
		$item_images=$this->model->images()->setLimit(1)->tryLoadAny();
		if($item_images->loaded())
			$img_url = $item_images->ref('item_image_id')->ref('thumb_file_id')->get('url');


		$this->current_row_html['image']='<img style="max-width:70px;" alt="'.$item_images['alt_text'].'" title="'.$item_images['title'].'" src="'.$img_url.'"></img>';
		
		parent::formatRow();
	}



}
