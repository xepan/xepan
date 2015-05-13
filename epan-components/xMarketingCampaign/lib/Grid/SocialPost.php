<?php

namespace xMarketingCampaign;

class Grid_SocialPost extends \Grid{
	public $preview_vp;
	// public $total_posts_vp;
	function init(){
		parent::init();
		$this->addQuickSearch(array('name','category'));
		$this->addPaginator($ipp=50);
		$this->add_sno();
		$self=$this;
		$this->preview_vp = $this->add('VirtualPage');
		$this->preview_vp->set(function($p)use($self){

			$m=$p->add('xMarketingCampaign/Model_SocialPost')->load($_GET['socialpost_id']);
			$p->add('View')->set('Created '. $self->add('xDate')->diff(\Carbon::now(),$m['created_at']) .', Last Modified '. $self->add('xDate')->diff(\Carbon::now(),$m['updated_at']) )->addClass('atk-size-micro pull-right')->setStyle('color','#555');
			$p->add('HR');
			$p=$p->add('View')->addClass('panel panel-default')->setStyle('padding','20px');
			
			$cols = $p->add('Columns');
			$share_col =$cols->addColumn(4);
			$title_col =$cols->addColumn(8);

			$share_col->addClass('text-center');
			$share_col->add('View')->setElement('a')->setAttr(array('href'=>$m['url'],'target'=>'_blank'))->set($m['url']);
			$share_col->add('View')->setElement('img')->setAttr('src',$m['image'])->setStyle('max-width','100%');



			$title_col->add('H4')->set($m['post_title']);
			$cols_hrs=$p->add('Columns');
			$l_c= $cols_hrs->addColumn(4);
			$l_c->add('View')->set('Share URL')->addClass('atk-size-micro pull-right')->setStyle('color','#555');
			$l_c->add('HR');
			
			$r_c= $cols_hrs->addColumn(8);
			$r_c->add('View')->set('Post Title')->addClass('atk-size-micro pull-right')->setStyle('color','#555');
			$r_c->add('HR');

			if($m['message_160_chars']){
				$p->add('View')->set($m['message_160_chars']);
				$p->add('View')->set('Message in 160 Characters')->addClass('atk-size-micro pull-right')->setStyle('color','#555');
				$p->add('HR');
			}

			if($m['message_255_chars']){
				$p->add('View')->set($m['message_255_chars']);
				$p->add('View')->set('Message in 255 Characters')->addClass('atk-size-micro pull-right')->setStyle('color','#555');
				$p->add('HR');
			}

			if($m['message_3000_chars']){
				$p->add('View')->set($m['message_3000_chars']);
				$p->add('View')->set('Message in 3000 Characters')->addClass('atk-size-micro pull-right')->setStyle('color','#555');
				$p->add('HR');
			}

			if($m['message_blog']){
				$p->add('View')->setHTML($m['message_blog']);
				$p->add('View')->set('Message for Blogs')->addClass('atk-size-micro pull-right')->setStyle('color','#555');
				$p->add('HR');
			}

		});

	}

	function format_preview($f){
				$this->current_row_html[$f]='<a href="javascript:void(0)" onclick="'. $this->js()->univ()->frameURL($this->model['name'],$this->api->url($this->preview_vp->getURL(),array('socialpost_id'=>$this->model->id))) .'">'.$this->current_row[$f].'</a>';
	}
	// function format_total_posts($f){
	// 			$this->current_row_html[$f]= '<a href="javascript:void(0)" onclick="'.$this->js()->univ()->frameURL('Total Posts Of  "'.$this->model['name'].'"',$this->api->url($this->total_posts_vp->getURL(),array('socialpost_id'=>$this->model->id))).'">'.$this->current_row[$f].'</a>';
	// 		$this->addFormatter('total_posts','total_posts');
	// }
	function format_unread_comment($f){
		if($this->current_row[$f])
			$this->current_row_html[$f] = '<i class="atk-label atk-swatch-ink" style="background-color:red"/>'.$this->current_row[$f];
	}
	function setModel($model,$fields=null){
		$m = parent::setModel($model,$fields);
			$this->addFormatter('name','preview');
			$this->addFormatter('unread_comment','unread_comment');
			$this->addColumn('Expander','post');
		return $m;
	}
	function formatRow(){
		parent::formatRow();
	}

	function recursiveRender(){
		$btn= $this->addButton("Social Category Management");
		if($btn->isClicked()){
			$this->js()->univ()->frameURL('Social Post  Category',$this->api->url('xMarketingCampaign_page_owner_socialcontentscat'))->execute();
		}
		parent::recursiveRender();
	}
}