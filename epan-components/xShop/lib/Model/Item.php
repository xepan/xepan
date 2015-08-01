<?php
namespace xShop;

class Model_Item extends \Model_Document{
	public $table='xshop_items';
	public $table_alias='Item';

	public $status=array();
	public $root_document_name='xShop\Item';

	public $actions=array(
			'allow_add'=>array(),
			'allow_del'=>array(),
			'forceDelete'=>array(),
			'can_see_activities'=>array(),
		);

	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->hasOne('xShop/Application','application_id');
		$this->hasOne('xShop/MemberDetails','designer_id')->sortable(true);

		// //for Mutiple Epan website
		// $this->hasOne('Epan','epan_id');
		// $this->addCondition('epan_id',$this->api->current_website->id);

		// Basic Field
		$this->addField('name')->mandatory(true)->group('b~5')->sortable(true);
		$this->addField('sku')->PlaceHolder('Insert Unique Referance Code')->caption('Code')->hint('Place your unique Item code ')->mandatory(true)->group('b~3')->sortable(true);
		$this->addField('is_publish')->type('boolean')->defaultValue(true)->group('b~2')->sortable(true);
		$this->addField('is_party_publish')->type('boolean')->defaultValue(true)->group('b~2')->sortable(true);

		$this->addField('original_price')->type('money')->mandatory(true)->group('c~6~Basic Price');
		$this->addField('sale_price')->type('money')->mandatory(true)->group('c~6')->sortable(true);
		$this->addField('short_description')->type('text')->group('c~12');
		
		$this->addField('rank_weight')->defaultValue(0)->hint('Higher Rank Weight Item Display First')->mandatory(true)->group('d~4');
		// $this->addField('created_at')->type('date')->defaultValue(date('Y-m-d'))->group('d~4');
		$this->addField('expiry_date')->type('date')->group('d~4');
		$this->addField('description')->type('text')->display(array('form'=>'RichText'))->group('z~12');
		
		// Price and Qtuanitity Management
		$this->addField('minimum_order_qty')->type('int')->group('e~3~Basic Quantity Options')->defaultValue(1);
		$this->addField('maximum_order_qty')->type('int')->group('e~3');
		$this->addField('qty_unit')->group('e~3')->defaultValue('pcs');
		$this->addField('qty_from_set_only')->type('boolean')->group('e~3')->defaultValue(false);
		
		//Item Allow Optins
		$this->addField('is_saleable')->type('boolean')->group('f~2~<i class=\'fa fa-cog\' > Item Allow Options</i>');
		$this->addField('is_purchasable')->type('boolean')->group('f~2~<i class=\'fa fa-cog\' > Item Allow Options</i>');
		$this->addField('mantain_inventory')->type('boolean')->group('f~2~<i class=\'fa fa-cog\' > Item Allow Options</i>');
		$this->addField('allow_negative_stock')->type('boolean')->group('f~3~<i class=\'fa fa-cog\' > Item Allow Options</i>');
		$this->addField('is_servicable')->type('boolean')->group('f~2~<i class=\'fa fa-cog\' > Item Allow Options</i>')->system(true);
		$this->addField('is_productionable')->type('boolean')->group('f~2~<i class=\'fa fa-cog\' > Item Allow Options</i>');
		$this->addField('website_display')->type('boolean')->group('f~2');
		$this->addField('is_downloadable')->type('boolean')->group('f~2')->system(true);
		$this->addField('is_rentable')->type('boolean')->group('f~2')->system(true);
		$this->addField('is_designable')->type('boolean')->group('f~2');
		$this->addField('is_template')->type('boolean')->defaultValue(false)->group('f~2');
		$this->addField('is_enquiry_allow')->type('boolean')->group('f~2');
		$this->addField('is_attachment_allow')->type('boolean')->group('f~2');
		$this->addField('is_fixed_asset')->type('boolean')->group('f~2')->system(true);
		$this->addField('warrenty_days')->type('int')->group('f~2');
		
		//Item Display Options
		$this->addField('show_detail')->type('boolean')->defaultValue(true)->group('g~2~Item Display Options');
		$this->addField('show_price')->type('boolean')->group('g~2');
		$this->addField('is_visible_sold')->type('boolean')->hint('If Product remains visible after sold')->group('g~2');
		$this->hasOne('xShop/ItemOffer','offer_id')->group('g~2');
		$this->addField('offer_position')->setValueList(array('top:0;-left:0;'=>'TopLeft','top:0;-right:0;'=>'TopRight','bottom:0;-left:0;'=>'BottomLeft','bottom:0;-right:0;'=>'BottomRight'))->group('g~2');
		
		//Marked
		$this->addField('new')->type('boolean')->caption('New')->defaultValue(true)->group('h~3~<i class=\'fa fa-cog\' > Marked Options</i>');
		$this->addField('feature')->type('boolean')->caption('Featured')->group('h~3');
		$this->addField('latest')->type('boolean')->caption('Latest')->group('h~3');
		$this->addField('mostviewed')->type('boolean')->caption('Most Viewed')->group('h~3');

		//Enquiry Send To
		$this->addField('enquiry_send_to_admin')->type('boolean')->group('i~3~<i class=\'fa fa-cog\' > Enquiry Send To</i>');
		$this->addField('Item_enquiry_auto_reply')->caption('Item Enquiry Auto Reply')->type('boolean')->group('i~3');
		
		//Item Comment Options
		$this->addField('allow_comments')->type('boolean')->group('j~4~<i class=\'fa fa-cog\'> Item Comment Options</i>');
		$this->addField('comment_api')->setValueList(
														array('disqus'=>'Disqus')
														)->group('j~4');

		//Item Other Options
		$this->addField('add_custom_button')->type('boolean')->group('k~3~<i class=\'fa fa-cog\'> Item Other Options</i>');
		$this->addField('custom_button_label')->group('k~4');
		$this->addField('custom_button_url')->placeHolder('subpage name like registration etc.')->group('k~5');
		$this->addField('theme_code')->hint('To club same theme code items in one')->group('k~6')->sortable(true);
		$this->addField('reference')->PlaceHolder('Any Referance')->hint('Use URL for external link')->group('k~6')->sortable(true);
		
		//Item Stock Options	
		$this->addField('negative_qty_allowed')->type('number');

		// Item WaterMark
		$this->add('filestore/Field_Image','watermark_image_id');
		$this->addField('watermark_text')->type('text')->group('o~5~bl');
		$this->addField('watermark_position')->enum(array('TopLeft','TopRight','BottomLeft','BottomRight','Center','Left Diagonal','Right Diagonal'));
		$this->addField('watermark_opacity');
		
		//Item Designs
		$this->addField('designs')->type('text')->group('o~5~bl');
	
		//Search String
		$this->addField('search_string')->type('text')->system(true);

		//Item SEO
		$this->addField('meta_title');
		$this->addField('meta_description')->type('text');
		$this->addField('tags')->type('text')->PlaceHolder('Comma Separated Value');

		//others
		$this->addField('terms_condition')->type('text')->display(array('form'=>'RichText'));//->group('c~12');
		$this->addField('duplicate_from_item_id');//->group('c~12');
		
		//Blog
		$this->addField('is_blog')->type('boolean');

		$this->hasMany('xShop/CategoryItem','item_id');
		$this->hasMany('xShop/ItemAffiliateAssociation','item_id');
		$this->hasMany('xShop/ItemImages','item_id');
		// $this->hasMany('xShop/Attachments','item_id');
		$this->hasMany('xShop/ItemEnquiry','item_id');
		$this->hasMany('xShop/OrderDetails','item_id');
		$this->hasMany('xShop/QuotationItem','quotation_id');
		$this->hasMany('xShop/ItemSpecificationAssociation','item_id');
		$this->hasMany('xShop/CustomFieldValueFilterAssociation','item_id');
		$this->hasMany('xShop/ItemCustomFieldAssos','item_id');
		$this->hasMany('xShop/ItemReview','item_id');
		$this->hasMany('xShop/ItemMemberDesign','item_id');
		$this->hasMany('xShop/ItemDepartmentAssociation','item_id');
		$this->hasMany('xShop/ItemComposition','item_id',null,'CompositionItems');
		$this->hasMany('xShop/ItemComposition','composition_item_id',null,'UsedInComposition');
		$this->hasMany('xShop/ItemTaxAssociation','item_id');
		// $this->hasMany('xStore/TransferNoteItem','item_id');
		$this->hasMany('xStore/MaterialRequestItem','item_id');
		// $this->hasMany('xStore/PurchaseMaterialRequestItem','item_id');
		$this->hasMany('xShop/QuantitySet','item_id');
		$this->hasMany('xShop/CustomRate','item_id');
		$this->hasMany('xPurchase/PurchaseOrderItem','item_id');
		$this->hasMany('xShop/InvoiceItem','item_id');
		$this->hasMany('xDispatch/DispatchRequestItem','item_id');
		$this->hasMany('xStore/Stock','item_id');
		$this->hasMany('xStore/StockMovementItem','item_id');

		$this->addExpression('theme_code_group_expression')->set('(IF(ISNULL('.$this->table_alias.'.theme_code),'.$this->table_alias.'.id,'.$this->table_alias.'.theme_code))');
			
		$this->addHook('beforeSave',$this);
		$this->addHook('afterInsert',$this);
		$this->addHook('beforeDelete',$this);
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeSave($m){
		// todo checking SKU value must be unique
		$item_old=$this->add('xShop/Model_Item');
		if($this->loaded())
			$item_old->addCondition('id','<>',$this->id);
		$item_old->tryLoadAny();

		if($item_old['sku'] == $this['sku'])
			throw $this->exception('Item Code is Allready Exist','Growl')->setField('sku');

		//do inserting search string for full text search
		// $p_model=$this->add('xShop/Model_Item');
		$this['search_string']= implode(" ", $this->getCategory($this['id'])). " ".
								$this["name"]. " ".
								$this['sku']. " ".
								$this['short_description']. " ".
								$this["description"]. " ".
								$this["meta_title"]. " ".
								$this["meta_description"]. " ".
								$this['sale_price']
							;	

		if(($this->dirty['sale_price'] or $this->dirty['original_price']) and $this['id'] > 0){
			$this->updateDefaultQuantitySet();
		}
		// TOOOOOOOOOOOODOOOOOOOOOOO check for the uodate item designer if ==================
		// if($this->loaded() and $this->dirty['designer_id']){	
		// 	$this->updateItemDesigner();
		// }
	}

	function afterInsert($obj,$new_item_id){
		$new_item =  $this->add('xShop/Model_Item')->load($new_item_id);
		$new_item->updateDefaultQuantitySet();

		if(!$new_item['designer_id']) return;
		$new_item->updateItemDesigner();
	}

	function updateDefaultQuantitySet(){
		//Default Qty Set
		$qty_set_model = $this->ref('xShop/QuantitySet')->addCondition('is_default',true)->tryLoadAny();
		$qty_set_model['old_price'] = $this['original_price'];
		$qty_set_model['price'] = $this['sale_price'];
		$qty_set_model['qty'] = 1;
		$qty_set_model['name'] = "Default";
		$qty_set_model['is_default'] = true;
		$qty_set_model->save();
	}

	function updateItemDesigner(){
		if(!$this->loaded())
			return;
		// if designable add as with admin => member's design too
		$designer = $this->add('xShop/Model_MemberDetails');
		$designer->addCondition('id',$this['designer_id']);
		$designer->tryLoadAny();
		$target = $this->item = $this->add('xShop/Model_ItemMemberDesign');
		$target['item_id'] = $this['id'];
		$target['member_id'] = $designer['id'];
		$target['designs'] = "";
		$target['is_dummy'] = true;
		$target->save();
	}

	function getCategory($item_id=null){
		if(!$item_id) $item_id= $this->id;

		$cat_pro_model=$this->add('xShop/Model_CategoryItem');
		$cat_pro_model->addCondition('item_id',$item_id);
		$cat_name=array();
		foreach ($cat_pro_model as $j) {
			$cat_name[]=$cat_pro_model->ref('category_id')->get('name');
		}
		return $cat_name;				
	}

	function beforeDelete($m){

		$this->api->event('xshop_item_before_delete',$this);

		$order_count = $m->ref('xShop/OrderDetails')->count()->getOne();
		$item_enquiry_count = $m->ref('xShop/ItemEnquiry')->count()->getOne();
		$design_count = $m->ref('xShop/ItemMemberDesign')->count()->getOne();
		$material_request = $m->ref('xStore/MaterialRequestItem')->count()->getOne();
		$po_item = $m->ref('xPurchase/PurchaseOrderItem')->count()->getOne();
		$invoice_item = $m->ref('xShop/InvoiceItem')->count()->getOne();
		$quotation_item = $m->ref('xShop/QuotationItem')->count()->getOne();
		$dispatch_item = $m->ref('xDispatch/DispatchRequestItem')->count()->getOne();
		
		if($order_count or $item_enquiry_count or $design_count or $material_request or $po_item or $quotation_item or $invoice_item or $dispatch_item){
			throw $this->exception('Cannot Delete,first delete Orders or Enquiry or MemberDesign or MaterialRequest or quotation_item or QuantitySet','Growl');
		}

		$m->ref('xShop/CategoryItem')->each(function($obj){$obj->forceDelete();});
		$m->ref('xShop/ItemImages')->each(function($obj){$obj->forceDelete();});
		$m->ref('xShop/ItemCustomFieldAssos')->each(function($obj){$obj->forceDelete();});
		$m->ref('xShop/ItemAffiliateAssociation')->each(function($obj){$obj->forceDelete();});
		$m->ref('xShop/ItemEnquiry')->each(function($obj){$obj->forceDelete();});
		$m->ref('xShop/ItemSpecificationAssociation')->each(function($obj){$obj->forceDelete();});
		$m->ref('xShop/ItemReview')->each(function($obj){$obj->forceDelete();});
		$m->ref('xShop/ItemDepartmentAssociation')->each(function($obj){$obj->forceDelete();});
		$m->ref('xShop/ItemTaxAssociation')->each(function($obj){$obj->forceDelete();});
		$m->ref('xShop/CustomFieldValueFilterAssociation')->each(function($obj){$obj->forceDelete();});
		
		$m->ref('xShop/QuantitySet')->each(function($qty_set){
			$qty_set->forceDelete();
		});

		$m->ref('xShop/CustomRate')->each(function($custom_rate){
			$custom_rate->forceDelete();
		});

	}

	function forceDelete(){
		$this->ref('xShop/OrderDetails')->each(function($order_detail){
			$order_detail->newInstance()->load($order_detail->id)->setItemEmpty();
		});

		$this->ref('xShop/QuotationItem')->each(function($quotation_item){
			$quotation_item->newInstance()->load($quotation_item->id)->setItemEmpty();
		});
		
		$this->ref('xShop/ItemMemberDesign')->each(function($member_design){
			$member_design->newInstance()->load($member_design->id)->setItemEmpty();
		});

		$this->ref('xShop/InvoiceItem')->each(function($invoice_item){
			$invoice_item->newInstance()->load($invoice_item->id)->setItemEmpty();
		});
		
		$this->ref('xStore/MaterialRequestItem')->each(function($material_request_item){
			$material_request_item->newInstance()->load($material_request_item->id)->setItemEmpty();
		});
		
		$this->ref('xPurchase/PurchaseOrderItem')->each(function($po_item){
			$po_item->newInstance()->load($po_item->id)->setItemEmpty();
		});
		
		$this->ref('xDispatch/DispatchRequestItem')->each(function($dispatch_item){
			$dispatch_item->newInstance()->load($dispatch_item->id)->setItemEmpty();
		});

		$this->ref('xStore/Stock')->each(function($obj){
			$obj->forceDelete();
		});

		$this->ref('xStore/StockMovementItem')->each(function($obj){
			$obj->newInstance()->load($obj->id)->set('item_id',NULL)->saveAndUnload();
		});

		$this->ref('CompositionItems')->deleteAll();
		$this->ref('UsedInComposition')->deleteAll();

		$this->delete();
	}
	
	function updateSearchString($item_id=null){
		if($this->loaded()){
			if(!$item_id) $item_id =$this->id;
			$this['search_string']= implode(" ", $this->getCategory()). " ".
								$this["name"]. " ".
								$this['sku']. " ".
								$this['short_description']. " ".
								$this["description"]. " ".
								$this["meta_title"]. " ".
								$this["meta_description"]. " ".
								$this['sale_price']
							;						
			$this->update();
		}
	}

	function sendEnquiryMail($to_mail,$name=null,$contact=null,$email_id=null,$message=null,$form=null,$item_name,$item_code,$reply_email='0'){
						
		$tm=$this->add( 'TMail_Transport_PHPMailer' );
		$msg=$this->add( 'SMLite' );
		if(!$reply_email){
			$msg->loadTemplate( 'mail/xShop_itemenquiry' );		
			$msg_body = "<h3>Enquiry Related to Item:".$item_name."<br> Item Code ".$item_code."</h3>";	
			$msg_body .= "<b>Name : </b>".$name."<br>";
			$msg_body .= "<b>Email id :</b>".$email_id."<br>";
			$msg_body .= "<b>Contact No :</b>".$contact."<br>";
			$msg_body .= "<b>Message : </b>".$message."<br>";
			$msg->trySet('epan',$this->api->current_website['name']);
			$msg->setHTML('custome_form',$msg_body);
			$subject ="You Got An  Enquiry !!!";			
		}else{
			$config_model=$this->add('xShop/Model_Configuration');
			$config_model->tryLoadAny();

			$subject =$config_model['subject'];
			$msg->loadTemplate( 'mail/xShop_itemenquiryreply' );		
			$msg_body = $config_model['message'];
			// throw new \Exception("Error Processing Request".$msg_body);			
			$msg_body .= '<b>Item_name : </b>'.$item_name."<br>";
			$msg_body .= '<b>Item_code : </b>'.$item_code."<br>";
			$msg->setHTML('enquiry_item_reply_detail',$msg_body);
		}

		$email_body=$msg->render();
		// throw new \Exception($to_mail);
		
		if($to_mail){
				$tm->send( $to_mail, "", $subject, $email_body ,false,null);
				// throw new \Exception("Error Processing Request mail in send", 1);
			}

	}

	function updateContent($id,$content){
		if(!$id) return 'false';

		$item = $this->add('xShop/Model_Item');
		$item->tryLoad($id);
		if(!$item->loaded()) return 'false';
			
		$item['description']=$content=="undefined"?"":$content;
		$item->save();
		return 'true';
	}

	function getItem($id){
		$this->load($id);				
		return $this;
	}

	function getItemCount($app_id){
		if($this->loaded())
			throw new \Exception("Item Model Loaded at Count All Item");
		if($app_id)
			$this->addCondition('application_id',$app_id);
		return $this->count()->getOne();
	}

	function getPublishCount($app_id){
		if($this->loaded())
			throw new \Exception("Item Model Loaded at Count Active Item");	
		if($app_id)
			$this->addCondition('application_id',$app_id);
		return $this->addCondition('is_publish',true)->count();
	}

	function getUnpublishCount($app_id){
		if($this->loaded())
			throw new \Exception("Item Model Loaded at Count Unactive Item");
		if($app_id)
			$this->addCondition('application_id',$app_id);
		return $this->addCondition('is_publish',false)->count();	
	}

	function applicationItems($app_id){
		if(!$app_id)
			$app_id=$this->api->recall('xshop_application_id');	

		$this->addCondition('application_id',$app_id);
		$this->tryLoadAny();
		return $this;
	}

	function getAssociatedCategories(){
		$associated_categories = $this->ref('xShop/CategoryItem')->addCondition('is_associate',true)->_dsql()->del('fields')->field('category_id')->getAll();
		return iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($associated_categories)),false);
	}

	function getAssociatedCustomFields($department_ids=null){
		if(!$this->loaded())
			return array();
		$associate_customfields= $this->ref('xShop/ItemCustomFieldAssos');
		$associate_customfields->addCondition('is_active',true);

		if($department_ids)
			$associate_customfields->addCondition('department_phase_id',$department_ids);

		$associate_customfields = $associate_customfields->_dsql()->del('fields')->field('customfield_id')->getAll();
		
		return iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($associate_customfields)),false);
		// return $associate_customfields;
	}

	function customFields($department_ids=null){
		return $this->add('xShop/Model_CustomFields')->addCondition('id',$this->getAssociatedCustomFields($department_ids));
	}

	function getAssociatedAffiliate(){
		$associated_affiliate = $this->ref('xShop/ItemAffiliateAssociation')->addCondition('is_active',true)->_dsql()->del('fields')->field('affiliate_id')->getAll();
		return iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($associated_affiliate)),false);
	}

	function addCustomField($customfield_id){
		$old_model = $this->add('xshop/Model_ItemCustomFieldAssos');
		$old_model->addCondition('item_id',$this->id);
		$old_model->addCondition('customfield_id',$customfield_id);
		$old_model->addCondition('is_allowed',false);
		$old_model->tryLoadAny();
		if($old_model->loaded()){
			$old_model['is_allowed'] = true;
			$old_model->saveandUnload();
		}else{
			$cat_item_cf_model = $this->add('xshop/Model_ItemCustomFieldAssos');
			$cat_item_cf_model['customfield_id'] = $customfield_id;
			$cat_item_cf_model['item_id'] = $this->id;
			$cat_item_cf_model['is_allowed'] = true;
			$cat_item_cf_model->saveandUnload();
		}	
	}
	
	function updateCustomField($item_id=null){
		
		$category_item_model = $this->add('xShop/Model_CategoryItem');
		$category_item_model->addCondition('item_id',$this['id']);
		$category_item_model->tryLoadAny();

		foreach ($category_item_model as $junk) {
			$category_customfield_model = $this->add('xShop/Model_ItemCustomFieldAssos');
			$category_customfield_model->addCondition('category_id',$junk['category_id']);
			
			foreach ($category_customfield_model as $junk) {
				$model = $this->add('xshop/Model_ItemCustomFieldAssos');
				$model->addCondition('item_id',$this['id']);
				$model->addCondition('customfield_id',$junk['customfield_id']);
				$model->tryLoadAny();
								
				$model['is_allowed'] = $junk['is_allowed'];
				$model->saveandUnload();
			}

		}
	}

	function specification($specification=null){
		$specs_assos = $this->add('xShop/Model_ItemSpecificationAssociation')->addCondition('item_id',$this->id);
		$specs_j = $specs_assos->join('xshop_specifications','specification_id');
		$specs_j->addField('name');

		if($specification){
			$specs_assos->addCondition('name',$specification);
			$specs_assos->tryLoadAny();
			if($specs_assos->loaded()) return $specs_assos['value'];
			return false;
		}

		return $specs_assos;
	}

	function addSpecification($specification){
		$specs_assos = $this->add('xShop/Model_ItemSpecificationAssociation')->addCondition('item_id',$this->id);
		$specs_assos->addCondition('specification_id',$specification->id);

		$specs_assos->tryLoadAny();
		if(!$specs_assos->loaded())
			$specs_assos->save();

		return $specs_assos;
	}

	/*
		$custom_field_values=array(
			'Color'=>'Red',
			'Size'=>'9'
		)	
	*/

	function  getPrice($custom_field_values_array, $qty, $rate_chart='retailer'){
		
		// throw new \Exception(print_r($custom_field_values_array,true));

		$cf_array = array();
		$cf = array();
		$dept=array();
		if($custom_field_values_array != ""){
			foreach ($custom_field_values_array as $cf_key => $cf_value) {
				$cf[] = "- :: $cf_key :: $cf_value";
			}
		}

		
		// echo implode("<br/>",$cf);

		$quantitysets = $this->ref('xShop/QuantitySet')->setOrder(array('custom_fields_conditioned desc','qty desc','is_default asc'));
		$i=1;
		foreach ($quantitysets as $qsjunk) {
			// check if all conditioned match AS WELL AS qty
			$cond = $this->add('xShop/Model_QuantitySetCondition')->addCondition('quantityset_id',$qsjunk->id);
			$all_conditions_matched = true;
			foreach ($cond as $condjunk) {				
				if(!in_array(trim(str_replace("  ", " ", $condjunk['custom_field_value'])),$cf)){
					$all_conditions_matched = false;
				}
			}

			if($all_conditions_matched && $qty >= $qsjunk['qty']){
				// echo 'breaking at '. $i++. ' '; 
				break;
			}
		}

		// throw new \Exception(print_r(array('original_price'=>$quantitysets['old_price']?:$quantitysets['price'],'sale_price'=>$quantitysets['price']),true));
		return array('original_price'=>$quantitysets['old_price']?:$quantitysets['price'],'sale_price'=>$quantitysets['price']);
		// return array('original_price'=>rand(1000,9999),'sale_price'=>rand(100,999));

			// return array default_price
		// 1. Check Custom Rate Charts
			/*
				Look $qty >= Qty of rate chart
				get the most field values matched
				having lesser selections of type any or say ...
				when max number of custom fields are having values other than any/%
			*/
		// 2. Custom Field Based Rate Change

		// 3. Quanitity Set

		// 4. Default Price * qty
	}

	function  getPriceBack($custom_field_values_array, $qty, $rate_chart='retailer'){
		
		// throw new \Exception(print_r($custom_field_values_array,true));

		$cf_array = array();
		$cf = array();
		$dept=array();
		if($custom_field_values_array != ""){
			foreach ($custom_field_values_array as $dept_id => $cf_value) {
				if($dept_id=='stockeffectcustomfield'){
					$dept['name'] = 'stockeffectcustomfield';
				}else{
					$dept = $this->add('xHR/Model_Department')->addCondition('id',$dept_id)->tryLoadAny();
				}

				$cf_array[$dept_id] = $cf_value;
				$c = $this->genericRedableCustomFieldAndValue(json_encode($cf_array));
				$arry = explode(",", $c);
				foreach ($arry as $key => $value) {
					$temp = explode("::", $value);
					$cf[]= trim($dept['name'])." :: ".trim($temp[0]) . ' :: '. trim($temp[1]);
				}
			}
		}

		
		// echo implode("<br/>",$cf);

		$quantitysets = $this->ref('xShop/QuantitySet')->setOrder(array('custom_fields_conditioned desc','qty desc','is_default asc'));

		foreach ($quantitysets as $qsjunk) {
			// check if all conditioned match AS WELL AS qty
			$cond = $this->add('xShop/Model_QuantitySetCondition')->addCondition('quantityset_id',$qsjunk->id);
			foreach ($cond as $condjunk) {				
				if(!in_array(trim(str_replace("  ", " ", $condjunk['custom_field_value'])),$cf)){
					continue 2;
				}
			}

			if($qty >= $qsjunk['qty']){
				break;
			}
		}

		// throw new \Exception(print_r(array('original_price'=>$quantitysets['old_price']?:$quantitysets['price'],'sale_price'=>$quantitysets['price']),true));
		return array('original_price'=>$quantitysets['old_price']?:$quantitysets['price'],'sale_price'=>$quantitysets['price']);
		// return array('original_price'=>rand(1000,9999),'sale_price'=>rand(100,999));

			// return array default_price
		// 1. Check Custom Rate Charts
			/*
				Look $qty >= Qty of rate chart
				get the most field values matched
				having lesser selections of type any or say ...
				when max number of custom fields are having values other than any/%
			*/
		// 2. Custom Field Based Rate Change

		// 3. Quanitity Set

		// 4. Default Price * qty
	}

	function getAmount($custom_field_values_array, $qty, $rate_chart='retailer'){
		$price = $this->getPrice($custom_field_values_array, $qty, $rate_chart);
		return array('original_amount'=>$price['original_price'] * $qty,'sale_amount'=>$price['sale_price'] * $qty);

	}

	function includeCustomeFieldValues($import_fields=array(),$join_type='inner'){
		$custom_fields_j = $this->join('xshop_category_item_customfields.item_id');
		$custom_fields_j->hasOne('xShop/CustomFields','customfield_id');
		$custom_fields_values_j = $custom_fields_j->join('xshop_custom_fields_value.itemcustomfiledasso_id');

		foreach ($import_fields as $key=>$value) {
			if(!is_numeric($key))
				$custom_fields_values_j->addField($key,$value);
			else
				$custom_fields_values_j->addField($value);
		}

	}

	function activeAffiliate($affiliate_id){
		if($this->loaded() and !$affiliate_id)
			throw new \Exception("Item Model Must be Loaded ");

		$aff = $this->add('xShop/Model_Affiliate')->tryLoad($affiliate_id);

		$old_model = $this->add('xShop/Model_ItemAffiliateAssociation');
		$old_model->addCondition('item_id',$this->id);
		$old_model->addCondition('affiliate_id',$aff['id']);
		$old_model->addCondition('is_active',false);		
		$old_model->tryLoadAny();
		if($old_model->loaded()){
			$old_model['is_active'] = true;
			$old_model->saveandUnload();
		}else{
			$item_aff_model = $this->add('xShop/Model_ItemAffiliateAssociation');
			$item_aff_model['item_id'] = $this->id;
			$item_aff_model['affiliate_id'] = $affiliate_id;
			$item_aff_model['affiliatetype_id'] = $aff['affiliatetype_id'];
			$item_aff_model['is_active'] = true;
			$item_aff_model->saveandUnload();
		}
		
	}

	function getQtySet(){
		if(!$this->loaded())
			throw new \Exception("Item Model Must be Loaded");
		/*
		qty_set: {
				Values:{
				value:{
					name:'Default',
					qty:1,
					old_price:100,
					price:90,
					conditions:{
							custom_fields_condition_id:'custom_field_value_id'
						}
				}
			}
		},
		*/
		$qty_added=array();
		$qty_set_array = array();
		//load Associated Quantity Set
			$qty_set_model = $this->ref('xShop/QuantitySet');
			//foreach qtySet get all Condition
				foreach ($qty_set_model as $junk){
					if(!in_array($junk['qty'], $qty_added)){
						$qty_added[]= $junk['qty'];
					}else{
						continue;
					}
					$qty_set_array[$qty_set_model['id']]['name'] = $qty_set_model['name'];
					$qty_set_array[$qty_set_model['id']]['qty'] = $qty_set_model['qty'];
					$qty_set_array[$qty_set_model['id']]['old_price'] = $qty_set_model['old_price'];
					$qty_set_array[$qty_set_model['id']]['price'] = $qty_set_model['price'];
					$qty_set_array[$qty_set_model['id']]['conditions'] = array();
					
					//Load QtySet Condition Model
					$condition_model =$this->add('xShop/Model_QuantitySetCondition')->addCondition('quantityset_id',$qty_set_model['id']);
						//foreach condition 
						foreach ($condition_model as $junk) {
							$single_condition_array = array();
							$single_condition_array[$condition_model['customfield']] = $condition_model->ref('custom_field_value_id')->get('name');
							$qty_set_array[$qty_set_model['id']]['conditions']= array_merge($qty_set_array[$qty_set_model['id']]['conditions'], $single_condition_array);
						}
				}

		return $qty_set_array;		
	}

	function getBasicCartOptions(){
				//Get All Item Associated Custom Field
		$custom_filed_array = array();
		$custom_fields = $this->getStockEffectCustomFields();
		foreach ($custom_fields as $custom_field_id){
			$cf_model = $this->add('xShop/Model_CustomFields')->load($custom_field_id);
			$cf_value_array = $cf_model->getCustomValue($this->id);
			$custom_filed_array[$cf_model['name']] = array(
													'type'=>$cf_model['type'],
													'values' => $cf_value_array
												);
		}

		//Get All Item Qnatity Set 
		$qty_set_array = array();
		$qty_set_array = $this->getQtySet();

		$options = array();

		$options['item_id'] = $this->id;
		$options['qty_from_set_only'] = $this['qty_from_set_only'];
		$options['qty_set'] = $qty_set_array;
		$options['custom_fields'] = $custom_filed_array;
		return $options;
	}

	// function submit(){
	// 	return "dsfsfdsdF";
	// }

	function getAssociatedDepartment(){
		if(!$this->loaded())
			throw $this->exception('Item Model Must be Loaded');
			
		$associated_department = $this->ref('xShop/ItemDepartmentAssociation')->addCondition('is_active',true)->_dsql()->del('fields')->field('department_id')->getAll();
		return iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($associated_department)),false);
	}

	function associatedDepartments(){
		if(!$this->loaded())
			throw $this->exception('Item Model Must be Loaded');

		return $this->add('xHR/Model_Department')->addCondition('id',$this->getAssociatedDepartment());
	}

	function departmentalAssociations($department=false){
		$m= $this->ref('xShop/ItemDepartmentAssociation');
		if($department){
			$m->addCondition('department_id',$department->id);
			$m->tryLoadAny();
		}
		return $m;
	}

	function isMantainInventory(){
		return $this['mantain_inventory'];
	}

	function allowNegativeStock(){
		return $this['allow_negative_stock'];
	}

	function composition($department){
		$m = $this->add('xShop/Model_ItemComposition');
		$m->addCondition('item_id',$this->id);
		$m->addCondition('department_id',$department->id);

		return $m;
	}

	function getStockEffectAssociatedCustomFields($department_ids=null){
		$associate_customfields= $this->ref('xShop/ItemCustomFieldAssos');
		$associate_customfields->addCondition('is_active',true);
		$associate_customfields->addCondition('can_effect_stock',true);

		if($department_ids)
			$associate_customfields->addCondition('department_phase_id',$department_ids);

		$associate_customfields = $associate_customfields->_dsql()->del('fields')->field('customfield_id')->getAll();
		return $associate_customfields = iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($associate_customfields)),false);
		// return $associate_customfields;
	}

	function genericRedableCustomFieldAndValue($cf_value_json){
		// $cf_value_json = '{"5":{"2":"10","3":"12"}}';
							//{"Department_id":{"custom Field id":"Custom Field Value id"}}
		if(! (is_string($cf_value_json) && is_object(json_decode($cf_value_json)) && (json_last_error() == JSON_ERROR_NONE)) )
			return "";
		$array = json_decode($cf_value_json,true);
		$str = "";
		foreach ($array as $department) {
			if(!$department) continue;
			
			$i = 1;
			foreach ($department as $cf_id => $cf_value_id) {
				$cf_model = $this->add('xShop/Model_CustomFields')->tryLoad($cf_id);
				if($cf_model['type']!='line'){
					$cf_value_model = $this->add('xShop/Model_CustomFieldValue')->tryLoad($cf_value_id);
					$str .= " ".$cf_model['name']." :: ". ($cf_value_model['name']!=''?$cf_value_model['name']:'not-found-or-deleted');
				}else{
					$cf_value_model = $cf_value_id;
					if(!$cf_model->loaded())
						$str .= " cust-field-deleted :: ". $cf_value_model;
					else
						$str .= " ".$cf_model['name']." :: ". $cf_value_model;
				}
				if($i != count($department))
					$str.=",";
				$i++;
			}	
		}
		return $str;
	}

	function customFieldsRedableToId($cf_value_json){
		// $cf_value_json = {"Sides":"Single Side"}
						//{"Custom_field_name":"Selected custom Field Value"}
		if(!$this->loaded())
			throw new \Exception("Item Model Must be Loaded");
			
		if(! (is_string($cf_value_json) && is_object(json_decode($cf_value_json)) && (json_last_error() == JSON_ERROR_NONE)) )
			return "";
		//Load Sales Department
		$sales_department = $this->add('xHR/Model_Department')->loadSales();
		$cart_cf_array = json_decode($cf_value_json,true);
		//Load Item Associated Custom Fields

		$array = array();
		foreach ($cart_cf_array as $cf_name => $cf_value_name) {
			$cf = $this->add('xShop/Model_CustomFields')->addCondition('name',$cf_name)->tryLoadAny();
			$cf_asso = $this->add('xShop/Model_ItemCustomFieldAssos')
									->addCondition('item_id',$this['id'])
									->addCondition('department_phase_id',$sales_department['id'])
									->addCondition('customfield_id',$cf->id)
									->tryLoadAny();

			$cf_value = $cf->ref('xShop/CustomFieldValue')->addCondition('name',$cf_value_name)->tryLoadAny();
			$array[] = array($cf->id => $cf_value->id);
			
		}

		$json_array[$sales_department->id] = $array;
		
		//Get Custom Field Id
		//Get Custom Field Value Id
		//{"5":{"2":"10","3":"12"}}
		//and Make json
		return json_encode($json_array);
	}

	//Duplicate the Item
	//$create_default_design_also Means when Freelancer duplicate the Item(is_template true) and also create new design in CustomerDesign Table
	function duplicate($create_default_design_also=true){
		$duplicate_template = $this->add('xShop/Model_Item');
		$fields=$this->getActualFields();
		$fields = array_diff($fields,array('id','sku','designer_id','created_at'));
		
		foreach ($fields as $fld) {
			$duplicate_template[$fld] = $this[$fld];
		}

		$designer = $this->add('xShop/Model_MemberDetails');
		$designer->loadLoggedIn();
		
		$duplicate_template->save();
		$duplicate_template['name'] = $this['name'].'-Copy';
		$duplicate_template['designer_id'] = $designer->id;
		$duplicate_template['sku'] = $this['sku'].'-' . $duplicate_template->id;
		$duplicate_template['is_template'] = false;
		$duplicate_template['is_publish'] = false;
		$duplicate_template['duplicate_from_item_id'] = $this->id;
		$duplicate_template->save();

		if($create_default_design_also){
			$new_design = $this->add('xShop/Model_ItemMemberDesign');
			$new_design['member_id'] = $designer->id;
			$new_design['item_id'] = $duplicate_template->id;
			$new_design['designs'] = $duplicate_template['designs'];
			$new_design->save();
		}

		// //Specification and value Duplicate
		$old_specification = $this->add('xShop/Model_ItemSpecificationAssociation')->addCondition('item_id',$this->id);
		$new_asso = $old_specification->duplicate($duplicate_template['id']);

		//Item Department Association
		$old_dept_asso = $this->add('xShop/Model_ItemDepartmentAssociation')->addCondition('item_id',$this->id);
		$new_asso = $old_dept_asso->duplicate($duplicate_template['id']);
		 
		//Custom and value Field Duplicate
		$old_asso = $this->add('xShop/Model_ItemCustomFieldAssos')->addCondition('item_id',$this->id);
		foreach ($old_asso as $junk){
			$new_asso = $old_asso->duplicate($duplicate_template['id']);
			//New Custom Field Association with old Vlaues
			$old_custom_value = $this->add('xShop/Model_CustomFieldValue')->addCondition('itemcustomfiledasso_id',$old_asso['id']);
			foreach ($old_custom_value as $junk){
				$new_custom_value = $old_custom_value->duplicate($new_asso['id'],$duplicate_template['id']);
				$new_custom_value->unload();
				}
			$new_asso->unload();
		}

		// //Category Association Duplicate
		$cat_item_asso = $this->add('xShop/Model_CategoryItem')->addCondition('item_id',$this->id);
		$cat_item_asso->duplicate($duplicate_template['id']);
		
		//Image Dupliacte
		$image = $this->add('xShop/Model_ItemImages')->addCondition('customefieldvalue_id',Null)->addCondition('item_id',$this->id);
		$image->duplicate($duplicate_template['id']);

		$old_tax_asso = $this->add('xShop/Model_ItemTaxAssociation')->addCondition('item_id',$this->id);
		foreach ($old_tax_asso as $junk) {
			$old_tax_asso->duplicate($duplicate_template['id']);
		}
		
		//Duplicate Phrases

		// //Attachment Document Dupliacte
		// $docs = $this->add('xShop/Model_Attachments')->addCondition('item_id',$this->id);
		// $docs->duplicate($duplicate_template['id']);

		// //Deaprtment Association Duplicate
		// $department_ass_model = $this->add('xShop/Model_ItemDepartmentAssociation');
		// $department_ass_model->duplicate($this['id']);

		return $duplicate_template;
	}


	function redableSpecification($seprater="<br/>"){
		if(!$this->loaded())
			return false;
		$str = "";
		$specifications = $this->specification();
		foreach ($specifications as $specification) {
			$str .= $specification['name']." :: ".$specification['value'].$seprater;
		}
		return $str;

	}

	function validateStoreCustomFields($item_id,$custom_fields){
		if($this->loaded())
			$this->unload();

		$this->load($item_id);
		// if custom_fields empty
		if($custom_fields != ""){
			// check for Item PrePhases of Store
			$dept_store = $this->departmentalAssociations($this->add('xHR/Model_Department')->loadStore());
			// Item Associated with Store Department
			if($dept_store->loaded()){
				$cf_id_array = $this->getStockEffectAssociatedCustomFields($dept_store['department_id']);//return CustomField id	
				//if check of prePhase is True
				if(count($cf_id_array)){
					throw new \Exception("CustomFields Not Proper");
					//then throw exception
				}
			}else // Item Not Associated with Store Department
				return "{}";// Return Empty custom Field string
		}

		//if CustomField NotEmpty Validation check at FormField Item CustomButton
	}

	function stockEffectCustomFields(){
	 return $this->ref('xShop/ItemCustomFieldAssos')
				->addCondition('can_effect_stock',true)
				->addCondition('department_phase_id',null)->tryLoadAny();
	}

	function getStockEffectCustomFields($department_ids=null){
		if(!$this->loaded())
			return array();

		$stock_effect_custom_field =  $this->ref('xShop/ItemCustomFieldAssos')
				->addCondition('can_effect_stock',true)
				->addCondition('department_phase_id',null)->tryLoadAny();

		$stock_effect_custom_field = $stock_effect_custom_field->_dsql()->del('fields')->field('customfield_id')->getAll();
		
		return iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($stock_effect_custom_field)),false);
		// return $associate_customfields;
	}

	function images(){
		return	$this->add('xShop/Model_ItemImages')->addCondition('item_id',$this->id);
	}

	function loadBlogs(){
		
	}

	function applyTaxs(){
		$tax_assos = $this->add('xShop/Model_ItemTaxAssociation');
		$tax_assos->addCondition('item_id',$this->id);
		if($tax_assos->count()->getOne())
			return $tax_assos;

		return false;
	}

	// Called from xShop_page_designer_save

	function updateFirstImageFromDesign(){
		$item = $target= $this;
			
		$design = $target['designs'];
		if(!$design) return;
		
		$design = json_decode($design,true);		
		$cont = $this->add('xShop/Controller_DesignTemplate',array('item'=>$item,'design'=>$design,'page_name'=>$_GET['page_name']?:'Front Page','layout'=>$_GET['layout_name']?:'Main Layout'));
		$image_data =  $cont->show($type='png',$quality=3, $base64_encode=false, $return_data=true);

		$item_image = $this->ref('xShop/ItemImages')->tryLoadAny();		
		$destination = $item_image['item_image_id'];

		if($item_image->count()->getOne())
			$destination = getcwd().DS.$this->add('filestore/Model_File')->tryLoad($destination)->getPath();
		
		
		if(file_exists($destination) AND !is_dir($destination)){
			$fd = fopen($destination, 'w');
            fwrite($fd, $image_data);
            fclose($fd);
		}else{
			$image_id = $this->add('filestore/Model_File',['import_mode'=>'string','import_source'=>$image_data]);
			$image_id['original_filename'] = 'design_for_item_'. $this->id;
			$image_id->save();

			//First Time Save Image
			$item_image['item_image_id'] = $image_id->id;
			$item_image['item_id'] = $item->id;
			$item_image->save();
		}

	}

}	

