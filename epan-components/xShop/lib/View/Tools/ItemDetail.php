<?php

namespace xShop;

class View_Tools_ItemDetail extends \componentBase\View_Component{
	public $html_attributes=array(); // ONLY Available in server side components
	public $tabs="";
	function init(){
		parent::init();
		if($_GET['review']){
			// throw new \Exception($_GET['days'], 1);
			if(!$this->updateReview())
				$this->js()->univ()->errorMessage('You can\'t add more reviews');
		}
		
		$this->addClass('xshop-item');
		// $this->js(true)->_load('jquery-elevatezoom');
		$this->api->stickyGET('xsnb_item_id');
		$config_model=$this->add('xShop/Model_Configuration');
		$config_model->tryLoadAny();
		$item=$this->add('xShop/Model_Item');
		if(!$_GET['xsnb_item_id'])
			return;

		$item->load($_GET['xsnb_item_id']);		
		$this->setModel($item);
	
	//======================Review Section==========
		
		$item_id=$this->api->stickyGET('xsnb_item_id');
		
		//Set Tool Custom Option 
		$this->template->trySet('item_id',$item_id);
		$this->template->trySet('auth',$this->html_attributes['show-post-review-auth']);
		$this->template->trySet('xdays',$this->html_attributes['show-post-review-allow-days']?:1);
		$this->template->trySet('subpage',$_GET['subpage']);
		
		if(!$this->html_attributes['show-post-review']){
			$this->template->trySet('review_section',"");
		}	
		// throw new \Exception("Error Processing Request", 1);
		$this->template->trySet('id',$item_id);
		$review=$this->add('xShop/Model_ItemReview');
		$review->addCondition('item_id',$item_id);
		$review->tryLoadAny();
		// $review->setOrder('id','desc');
		$this->template->trySet('review_value',$review['review']);	

	//======================Name===================
		
		if($this->html_attributes['show-item-name']){
			$str = '<h1 class="xshop-item-detail-name">'.$item['name'].'</h1>';
			$this->template->trySetHtml('item_name' ,$str);
		}

	//======================Sku==================
		if($this->html_attributes['show-item-code']){
			$str = '<div class="col-md-6 col-sm-6 xshop-item-detail-code">'.$item['sku'].'</div>';
			$this->template->trySetHtml('item_sku' ,$str);
		}else
			$this->template->tryDel('item_sku');
	//======================Reviews==============================		
		if($this->html_attributes['show-item-review']){
			$str = '<div class="col-md-6 col-sm-6 xshop-item-detail-review"></div>';
			$this->template->trySetHtml('review' ,$str);
		}else
			$this->template->tryDel('review');
	//======================Date======================
		if($this->html_attributes['show-item-date']){
			$str = '<span class="pull-right xshop-item-detail-date">'.$item['created_at'].'</span>';
			$this->template->trySetHtml('date',$str);		
		}

	//======================Images=====================
		$col_width = "col-md-12 col-sm-12 col-lg-12";
		if($this->html_attributes['show-image']){
			$col_width = "col-md-8 col-sm-8 col-lg-8";
			$str = '<div class="col-md-4 xshop-item-detail-images">';
			$images = $this->add('xShop/View_Tools_ItemImages')->getHTML();
			$images = $str.$images.'</div>';
			$this->template->trySetHTML('item_images',$images);
		}else{
			$this->template->tryDel('item_images');
		}

		$this->template->trySetHtml('item-detail-width',$col_width);

	//=======================Detail HEADING=================================	
		if($this->html_attributes['show-heading']){
			$str = '<div class="xhop-itemdetail-name"> <h1>'.$item['name'].'</h1></div>';
			$this->template->trySetHtml('item_detail_heading',$str);
		}
		
	//======================== ITEM SHORT DESCRIPTIONS ===================
		if($this->html_attributes['show-item-short-description'])
			$this->template->trySet('item_offer_supplier_shipping_info',$item['short_description']);

	//=======================Item Price===================================	
		if( $item['show_price'] and $this->html_attributes['show-item-price']){
			$str = '<div class="xshop-item-old-price" onclick="javascript:void(0)">'.$this->api->currency['symbole']." ".$item['original_price'].'</div>';
			$str.= '<div class="xshop-item-price" onclick="javascript:void(0)">'.$this->api->currency['symbole']." ".$item['sale_price'].'</div>';
			$this->template->trySetHtml('xshop_item_detail_price',$str);
		}
	//===========================Tags ===========================================
		if( $this->html_attributes['show-item-tags'] and $item['tags']){
			$label = "Tags";
			if(trim($this->html_attributes['item-tag-label']) !="")
				$label = $this->html_attributes['item-tag-label'];
			$str = '<div class="xshop-item-detail-title xshop-item-tags-label">'.$label.'</div>';
			$str.= '<div class="xshop-item-detail-tags">'.str_replace(',', " ", $item['tags']).'</div>';
			$this->template->trySetHtml('xshop_item_tags',$str);
		}
		
	//===========================COMMENTS API ===========================
		if($item['allow_comments'] and $this->html_attributes['show-item-comment']){
			if($item['comment_api'] and $config_model['disqus_code'])
				$this->template->trySetHTML('xshop_item_discus',$config_model['disqus_code']);
			else 
				$this->template->trySetHTML('xshop_item_discus',"<div class='alert alert-warning'>Place Your Discus Code and Select Comment Api in Item or Configuration</div>");
		}	

	//======================== CUSTOM BUTTON ==========================
		if($config_model['add_custom_button']){
			if($this->model['add_custom_button']){
				$btn_label = $this->model['custom_button_label']?:$config_model['custom_button_text'];
				$btn_link  = $this->model['custom_button_url']?:$config_model['custom_button_url'];
				$str='<a class="btn btn-default xshop-item-detail-custom-link" href="'.$btn_link.'">'.$btn_label.'</a>';
				$this->template->trySetHTML('xshop_item_custom_btn',$str);
			}else{
				$this->template->tryDel('xshop_item_custom_btn');
			}
			
		}
		//end of custom btn in item detail		


	//=====================ITEM AFFILIATES===============================
		if($this->html_attributes['show-item-affiliate']){
			$item_aff_ass = $this->add('xShop/Model_ItemAffiliateAssociation')->addCondition('item_id',$item->id);
			$label = "Affiliate's";
			if(trim($this->html_attributes['item-affiliate-label']) != "")
				$label = $this->html_attributes['item-affiliate-label'];
			$str = '<div class="xshop-item-detail-title xshop-item-affiliate-label">'.$label.'</div>';

			$str .='<div class="xshop-item-affiliate-block">';
			foreach ($item_aff_ass as $junk) {
				$aff = $this->add('xShop/Model_Affiliate')->tryload($item_aff_ass['affiliate_id']);
				$str .= '<div class="xshop-item-affiliate">'.$aff['affiliatetype']." :: ".$aff['company_name']."</div>";
				$aff->unLoad();
			}
			$str .="</div>";
			$this->template->SetHTML('xshop_item_affiliates',$str);
		}

	// =================Item Detail and specification and Attachments===================
		$detail_label = trim($this->html_attributes['item-detail-label'])?:'Description';
		$detail_header = "";
		if($this->html_attributes['show-item-detail-in-tabs']){
			$this->tabs = $this->add('Tabs',null,'xshop_item_detail_information');
			// $tabs->addTab('upload');
			$detail_tab = $this->tabs->addTab($detail_label);
		}else{
			$detail_tab = $this;
			$detail_header = '<div class="xshop-item-detail-title xshop-item-detail-label">'.$detail_label.'</div>';
		}
		

		$item_description = $item['description'];
		// throw new \Exception($item_description);
		
		//Live Edit of item Detail (server site live edit )
		if( $this->api->edit_mode == true ){
			$this->js(true)->_load('xshopContentUpdate');
			$str = '<div class="epan-container epan-sortable-component epan-component  ui-sortable component-outline epan-sortable-extra-padding ui-selected xshop-item-detail-content-live-edit" component_type="Container" id="xshop_item_detail_content_live_edit_'.$item['id'].'">';
			$str.= $item_description;
			$str.="</div>";
									
			$btn = 'onclick="javascript:$(this).univ().producDetailUpdate(';
			$btn.= '\'xshop_item_detail_content_live_edit_'.$item['id'].'\' , \''.$item['id'].'\' , \''.$item['sku'].'\')"';
			$str.='<div id="xshop_item_detail_live_edit_update" class="btn btn-danger pull-right btn-block" '.$btn.'>Update</div>';
			$item_description = $str;
		}
		//Detail tabs
		$detail_tab->add('View')->setHtml($detail_header.$item_description);
			
		//Specification
		$specification_label = trim($this->html_attributes['item-specification-label'])?:'Specification';
		if($this->html_attributes['show-item-specification']){
			$specification_tab = $this;
			if($this->html_attributes['show-item-detail-in-tabs']){
				$specification_tab = $this->tabs->addTab($specification_label);
			}else{
				$this->add('View')->setHtml('<div class="xshop-item-detail-title xshop-item-specification-label">'.$specification_label.'</div>');
			}

			$specification = $this->add('xShop/Model_ItemSpecificationAssociation')->addCondition('item_id',$item->id);
			$specification_tab->add('Grid')->setModel($specification,array('specification','value'));	
		}

		//if Item Designable
			if($this->model['is_designable']){
				// add Personalioze View
				$this->add('Button',null,'xshop_item_design_item')->set('Personalize')->js('click',$this->js()->univ()->location("index.php?subpage=".$this->html_attributes['personalization-page']."&xsnb_design_item_id=".$this->model->id));
			}

			// if designable or not add price tab to show the detail
			// else{
				//Price Section Add to cart in tab
				//add AddToCart View
				if($this->html_attributes['show-cart-section']){
					$cart_label = trim($this->html_attributes['item-cart-label'])?:'Cart';
					$cart_tab = $this;
					$show_cart_btn = 1;
				if($this->html_attributes['show-cart-btn'] == '0')
					$show_cart_btn = 0;

				if($this->html_attributes['show-item-detail-in-tabs'] and $this->html_attributes['show-cart-section-in-tabs']){
					$cart_tab = $this->tabs->addTab($cart_label);
					$cart_tab->add('xShop/View_Item_AddToCart',array('name'=>'cust_'.$this->model->id,'item_model'=>$this->model,'show_custom_fields'=>1,'show_price'=>$this->model['show_price'], 'show_qty_selection'=>1,'show_cart_btn'=>$show_cart_btn));
				}else
					$cart_tab->add('xShop/View_Item_AddToCart',array('name'=>'cust_'.$this->model->id,'item_model'=>$this->model,'show_custom_fields'=>1,'show_price'=>$this->model['show_price'], 'show_qty_selection'=>1),'xshop_item_cart_btn');
				}
			// }
		

		//Attachments
		$attachment_label = trim($this->html_attributes['item-attachment-label'])?:'Attachments';
		$attachment_header = "";
		if($item['is_attachment_allow'] and $this->html_attributes['show-item-attachment']){
			$attachment_tab = $this;
			
			if($this->html_attributes['show-item-detail-in-tabs']){
				$attachment_tab = $this->tabs->addTab($attachment_label);
			}else{
				$attachment_header = '<div class="xshop-item-detail-title xshop-item-attachment-label">'.$attachment_label.'</div>';
			}

			$attachment_model=$this->add('xShop/Model_ItemAttachment');
			// $attachment_model->addCondition('item_id',$item->id);
			$html = "";
			foreach ($attachment_model as $junk) {
				$html .= '<div class="xshop-item-attachment-link"> <a target="_blank" href="'.$attachment_model['attachment_url'];
				$html.= '"</a>'.$attachment_model['name'].'</div>';
			}
			$attachment_tab->add('View')->setHtml($attachment_header.$html)->addClass('xshop-item-attachment');
		}

		//Item Upload Images
		$upload_label = trim($this->html_attributes['item-upload-label'])?:'Upload';
		$upload_header = "";
		if($item['allow_uploadedable'] and $this->html_attributes['show-item-upload']){
			$up_tab = $this;
			
			if($this->html_attributes['show-item-detail-in-tabs']){
				$up_tab=$this->tabs->addTab($upload_label);
			}else{
				$upload_header = '<div class="xshop-item-detail-title xshop-item-upload-label">'.$upload_label.'</div>';
			}

			$member = $this->add('xShop/Model_MemberDetails');
      		if(!$member->loadLoggedIn()){
      			$up_tab->add('View_Error')->set('Login First');
      			return;
      		}

		    $image_model = $this->add('xShop/Model_MemberImages');
		    $image_model->addCondition('member_id',$member->id);

			$member_image=$this->add('xShop/Model_MemberImages');
			
			$up_form=$up_tab->add('Form');
			$up_form->setModel($member_image,array('image_id'));
			$up_form->addSubmit('Upload');

			$v = $up_tab->add('View');
			if($_GET['show_cart']){				
				$v->add('View')->set('Cart Tool');
				$v->add('xShop/View_Item_AddToCart',array('name'=>'cust_'.$this->model->id,'item_model'=>$this->model,'show_custom_fields'=>1,'show_price'=>true, 'show_qty_selection'=>1,'file_upload_id'=>$_GET['file_upload_id']));
			}

			if($up_form->isSubmitted()){
				$up_form->js(null,$v->js()->reload(array('show_cart'=>1,'file_upload_id'=>$up_form['image_id'])))->execute();
			}
			
		}

	//==================Enquiry Form================================
		if($this->html_attributes['show-item-enquiry-form']){
			$label = "Enquiry Form";
			if(trim($this->html_attributes['item-enquiry-form-label']) != "")
				$label = trim($this->html_attributes['item-enquiry-form-label']);
			
			$str = '<div class="xshop-item-detail-title xshop-item-enqyiry-form-label">'.$label.'</div>';
			$this->template->trySetHtml('xshop_item_enquiry_label',$str);

			$enquiry_form=$this->add('Form',null,'xshop_item_enquiry');
			$enquiry_form->addField('line','name');
			$enquiry_form->addField('line','contact_no');
			$enquiry_form->addField('line','email_id');
			$enquiry_form->addField('text','message');
			$enquiry_form->addSubmit('Send');
			if($enquiry_form->Submitted()){	
				$item_enq_model=$this->add('xShop/Model_itemEnquiry');
				$epan=$this->add('Model_Epan');
				$epan->tryLoadAny();
				// throw new \Exception("Error Processing Request".$item[]);
				$item_enq_model->createNew($enquiry_form['name'],$enquiry_form['contact_no'],$enquiry_form['email_id'],$enquiry_form['message'],$item['id'],$item['sku'],$item['name']);
					
				if($item['enquiry_send_to_self']){
					$item->sendEnquiryMail($epan['email_id'],$enquiry_form['name'],$enquiry_form['contact_no'],$enquiry_form['email_id'],$enquiry_form['message'],$enquiry_form,$item['name'],$item['SKU']);
				}
					
				if($item['enquiry_send_to_supplier']){
					// $item_enq_model->createNew($enquiry_form['name'],$enquiry_form['contact_no'],$enquiry_form['email_id'],$enquiry_form['message'],$item['id'],$item['sku'],$item['name']);				
					$item->sendEnquiryMail($item['supplier_email_id'],$enquiry_form['name'],$enquiry_form['contact_no'],$enquiry_form['email_id'],$enquiry_form['message'],$enquiry_form,$item['name'],$item['sku']);
				}

				if($item['enquiry_send_to_manufacturer']){
					// $item_enq_model->createNew($enquiry_form['name'],$enquiry_form['contact_no'],$enquiry_form['email_id'],$enquiry_form['message'],$item['id'],$item['sku'],$item['name']);
					$item->sendEnquiryMail($item['manufacturer_email_id'],$enquiry_form['name'],$enquiry_form['contact_no'],$enquiry_form['email_id'],$enquiry_form['message'],$enquiry_form,$item['name'],$item['SKU']);
					// throw new \Exception($item['manufacturer_email_id']);
				}	
				
				if($item['item_enquiry_auto_reply']){
					$item->sendEnquiryMail($enquiry_form['email_id'],null,null,null,null,null,$item['name'],$item['sku'],'1');
				}

				$enquiry_form->js(true,$enquiry_form->js()->reload())->univ()->successMessage('Enquiry Form Send Success fully')->execute();
			}
		}

	}

	function updateReview(){
		$item_id = $this->api->stickyGET('xsnb_item_id');
		$rating = $this->api->stickyGET('rating');

		$auth = $this->html_attributes['show-post-review-auth'];
		$days = $this->html_attributes['show-post-review-allow-days']?:1;
		
		if($auth and !$this->api->auth->isLoggedIn()){
			echo "Authentication Failed";
			 exit;
		}	
		$current_ip = getenv('HTTP_CLIENT_IP')?:
					getenv('HTTP_X_FORWARDED_FOR')?:
					getenv('HTTP_X_FORWARDED')?:
					getenv('HTTP_FORWARDED_FOR')?:
					getenv('HTTP_FORWARDED')?:
					getenv('REMOTE_ADDR');

		$days = 1;
		if($_GET['days'])
			$days = $_GET['days']; //xdays			
					
		$review_model=$this->add('xShop/Model_ItemReview');
		$review_model->addCondition('item_id',$item_id);
		$review_model->addCondition('ip',$current_ip);

		//Save Review First time
		if($review_model->count()->getOne() == 0){
			$review_model['review'] = $rating;
			$review_model['date'] = $this->api->now;
			$review_model->save();
		}else{
			$review_model->setOrder('date','desc');
			$review_model->setLimit(1);
			$review_model->tryLoadAny();

			$day_diff = $this->api->my_date_diff($this->api->now, $review_model['date']);
			$day_diff = $day_diff['days'];
			
			if($days == 1){
				echo "You have allready Given Review";
				return;
			}

			// if($days < $day_diff){
				$b = $this->add('xShop/Model_ItemReview');
				$b['review'] = $rating;
				$b['date'] = $this->api->now;
				$b['ip'] = $current_ip;
				$b['item_id'] = $item_id;
				$b->save();
				
				// echo true;
				
			// }

		}
	}

	function defaultTemplate(){
		$this->app->pathfinder->base_location->addRelativeLocation(
		    'epan-components/'.__NAMESPACE__, array(
		        'php'=>'lib',
		        'template'=>'templates',
		        'css'=>'templates/css',
		        'js'=>'templates/js',
		    )
		);
		
		return array('view/xShop-ItemDetail');
	}
}