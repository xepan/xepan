<?php

namespace xShop;

class Grid_Item extends \Grid{
	function init(){
		parent::init();
		
		$this->add_sno();
		$this->addPaginator($ipp=100);
		$self = $this;

		$this->add('VirtualPage')->addColumn('Details','Details',array('icon'=>'edit'),$this)->set(function($p){
			$selected_item = $p->add('xShop/Model_Item')->load($p->id);
		
			$filter_box = $p->add('View_Box')->setHTML('Item :: <b>'.$selected_item['name'].'</b>');

			$tab = $p->add('Tabs');
			$tab->addTabURL($p->api->url('xShop/page/owner/item_basic',array('item_id'=>$p->id)),'Basic');
			$tab->addTabURL($p->api->url('xShop/page/owner/item_attributes',array('item_id'=>$p->id)),'Attributes');
			$tab->addTabURL($p->api->url('xShop/page/owner/item_qtyandprice',array('item_id'=>$p->id)),'Qty & Price');
			$tab->addTabURL($p->api->url('xShop/page/owner/item_media',array('item_id'=>$p->id)),'Media');
			$tab->addTabURL($p->api->url('xShop/page/owner/item_category',array('item_id'=>$p->id)),'Category');
			$tab->addTabURL($p->api->url('xShop/page/owner/item_affliate',array('item_id'=>$p->id)),'Affiliate');
			$tab->addTabURL($p->api->url('xShop/page/owner/item_preview',array('item_id'=>$p->id)),'Preview');
			$tab->addTabURL($p->api->url('xShop/page/owner/item_seo',array('item_id'=>$p->id)),'SEO');
			$tab->addTabURL($p->api->url('xShop/page/owner/item_stock',array('item_id'=>$p->id)),'Stock');
			$tab->addTabURL($p->api->url('xShop/page/owner/item_prophases',array('item_id'=>$p->id)),'Production Phases');
			$tab->addTabURL($p->api->url('xShop/page/owner/item_account',array('item_id'=>$p->id)),'Accounts');
			// $tab->addTabURL('xShop/page/owner/item_composition','Composition',array('item_id'));
		});
	}


	function setModel($m,$fields){
		parent::setModel($m,$fields);
		
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
		
		$this->addQuickSearch($fields,null,'xShop/Filter_Item');

	}
	function recursiveRender(){
		$cat_btn = $this->addButton('Item Category Management');
		if($cat_btn->isClicked()){
			$this->js()->univ()->frameURL('Item Category',$this->api->url('xShop_page_owner_category'))->execute();
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

}