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

	function setModel($m,$fields=null){
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
		if(!$fields)
			$fields = $this->model->getActualFields();
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

	function removeColumns($columns){
		foreach ($columns as $column) {
			if($this->hasColumn($column))$this->removeColumn($column);
		}

	}

	function formatRow(){
		//Publish
		$designer = $this->model['designer']?:"No Specified";
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

		
		$options ="";

		if($this->model['is_saleable'])
			$options.= '<i class="glyphicon glyphicon-shopping-cart atk-swatch-green" title="Saleable"></i>';
		else
			$options.= '<i class="glyphicon glyphicon-shopping-cart atk-swatch-red " title="Non Saleable "></i>';
		
		if($this->model['is_party_publish'])
			$options.= '<i class="icon-publish atk-swatch-green atk-padding-small" title="Publish Via Designer(Party) On"></i>';
		else
			$options.= '<i class="icon-publish atk-swatch-red atk-padding-small" title="Publish Via Designer(Party) Off"></i>';
		
		if($this->model['is_purchasable'])
			$options.= '<i class="atk-effect-success atk-size-micro" title="Purchable">P</i>';
		else
			$options.= '<i class="atk-effect-danger atk-size-micro" title="Non Purchable ">P</i>';

		if($this->model['mantain_inventory'])
			$options.= '<i class="icon-box atk-swatch-green atk-padding-small" title="Mantain Inventory"></i>';
		else
			$options.= '<i class="icon-box atk-swatch-red atk-padding-small" title="Non Mantain Inventory"></i>';
		
		if($this->model['allow_negative_stock'])
			$options.= '<i class="glyphicon glyphicon-minus-sign atk-swatch-green" title="Allow Negative Stock"></i>';
		else
			$options.= '<i class="glyphicon glyphicon-minus-sign atk-swatch-red" title="Denied Negative Stock"></i>';
		
		if($this->model['is_productionable'])
			$options.= '<i class="glyphicon glyphicon-arrow-right atk-swatch-green atk-padding-small" title="Productionable"></i>';
		else
			$options.= '<i class="glyphicon glyphicon-arrow-right atk-swatch-red atk-padding-small" title="Non Productionable"></i>';



		if($this->model['is_enquiry_allow'])
			$options.= '<i class="icon-mail atk-swatch-green atk-padding-small" title="Enquiry Allowed"></i>';
		else
			$options.= '<i class="icon-mail atk-swatch-red atk-padding-small" title="Enquiry Deniend"></i>';

		if($this->model['allow_comments'])
			$options.= '<i class="icon-comment atk-swatch-green atk-padding-small" title="Comment Syatem On"></i>';
		else
			$options.= '<i class="icon-comment atk-swatch-red atk-padding-small" title="Comment System Off"></i>';


		if($this->model['is_attachment_allow'])
			$options.= '<i class="icon-folder atk-swatch-green" title="Allow Attachment"></i>';
		else
			$options.= '<i class="icon-folder atk-swatch-red" title="Denied Attachment"></i>';

		if($this->model['is_designable'])
			$options.= '<i class="icon-edit atk-swatch-green atk-padding-small" title="Designable"></i>';
		else
			$options.= '<i class="icon-edit atk-swatch-red atk-padding-small" title="Non Designable"></i>';

		if($this->model['qty_from_set_only'])
			$options.= '<i class="glyphicon glyphicon-lock atk-swatch-green atk-padidng-small" title="Select Quantity From Define Set"></i>';
		else
			$options.= '<i class="glyphicon glyphicon-lock atk-swatch-red atk-padidng-small" title="Select Quantity As User Want"></i>';
		
		if($this->model['negative_qty_allowed'])
			$options.= '<i class="atk-effect-green" title="Negative Qty Allowed">-Qty</i>';
		else
			$options.= '<i class="atk-effect-red" title="Negative Qty Denied">-Qty</i>';
		
		if($this->model['website_display'])
			$options.= '<i class="glyphicon glyphicon-globe atk-swatch-green atk-padding-small" title="Display on Website"></i>';
		else
			$options.= '<i class="glyphicon glyphicon-globe atk-swatch-red atk-padding-small" title="No Display on Website "></i>';
		
		
		// $options .= "'qty_from_set_only',
		// 					'is_template',
		// 					'Item_enquiry_auto_reply',
		//";

		$this->current_row_html['name'] = $template_html.$this->current_row['name'].'</span>'.'<span class="pull-right" title="Code">'.$this->current_row['sku'].'</span><br>'.$options;

		parent::formatRow();
	}

}
