<?php
namespace xShop;
class Model_MemberDetails extends \Model_Document{
	public $table="xshop_memberdetails";
	public $status=array();
	public $root_document_name="xShop\MemberDetails";
	
	function init(){
		parent::init();

		$this->hasOne('Users','users_id')->mandatory(true)->sortable(true);
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		
		$this->addField('organization_name')->sortable(true)->group('a~4');
		$this->addField('website')->sortable(true)->group('a~4');
		$this->addField('mobile_number')->sortable(true)->group('a~4');
		$this->addField('other_emails')->type('text')->group('a~4');
		// $this->addField('join_on')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));
		// $this->addField('verified_on')->type('datetime')->defaultValue(null);
		$this->addField('landmark')->sortable(true)->group('a~4');
		$this->addField('city')->sortable(true)->group('a~4');
		$this->addField('state')->sortable(true)->group('a~4');
		$this->addField('country')->sortable(true)->group('a~4');
		$this->addField('pincode')->sortable(true)->group('a~4')->type('int');
		
		$this->addField('address')->type('text')->group('a~4')->caption('Permanent Address');
		$this->addField('billing_address')->type('text')->group('a~4');
		$this->addField('shipping_address')->type('text')->group('a~4');
		$this->addField('tin_no')->group('a~4');
		$this->addField('pan_no')->group('a~4');

		$this->addField('is_active')->type('boolean')->defaultValue(true)->sortable(true)->group('a~1');
		$this->addField('is_organization')->type('boolean')->group('a~2');
		$this->add('filestore/Field_File','member_photo_id');
						
		// $this->hasMany('xShop/Order','member_id');
		$this->hasMany('xShop/DiscountVoucherUsed','member_id');
		$this->hasMany('xShop/ItemMemberDesign','member_id');
		$this->hasMany('xShop/MemberImages','member_id');

		$this->hasMany('xShop/Opportunity','customer_id');
		$this->hasMany('xShop/Quotation','customer_id');
		$this->hasMany('xShop/Order','member_id');
		$this->hasMany('xShop/ItemTemplate','designer_id');
		$this->hasMany('xShop/ItemTemplate','to_customer_id');
		$this->hasMany('xAccount/Account','customer_id');
		
		$this->addExpression('name')->set(function($m,$q){
			return $m->refSQL('users_id')->fieldQuery('name');
		});

		$this->addExpression('email')->set(function($m,$q){
			return $m->refSQL('users_id')->fieldQuery('email');
		});

		$this->addHook('beforeSave',$this);
		$this->addHook('beforeDelete',$this);

		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeDelete(){
		$opportunity = $this->ref('xShop/Opportunity')->count()->getOne();
		$quotation = $this->ref('xShop/Quotation')->count()->getOne();
		$order = $this->ref('xShop/Order')->count()->getOne();
		
		if($opportunity or $quotation or $order)
			throw $this->exception('Cannot Delete, Opportunity, Quotation or Order','Growl');

		$voucher_used = $this->ref('xShop/DiscountVoucherUsed')->count()->getOne();
		// $order_count=$this->ref('xShop/Order')->count()->getOne(); // Checked in Customer
		$member_count=$this->ref('xShop/MemberImages')->count()->getOne();
		$item_member_count=$this->ref('xShop/ItemMemberDesign')->count()->getOne();
		$str = 'Member Images ( '.$member_count .' ) ' .'Member Item Design ('.$item_member_count." ) ";
		if(/*$order_count or */ $member_count or $item_member_count or $voucher_used)
			throw $this->exception("Cannot Delete, First Delete ".$str,'Growl');
	}

	function forceDelete(){
		$this->ref('xShop/Opportunity')->each(function($opportunity){
			$opportunity->forceDelete();
		});

		$this->ref('xShop/Quotation')->each(function($quotation){
			$quotation->forceDelete();
		});

		$this->ref('xShop/Order')->each(function($order){
			$order->forceDelete();
		});


		$this->ref('xShop/DiscountVoucherUsed')->each(function($m){
			$m->setMemberEmpty();
		});

		$it = $this->add('xShop/Model_Item')
		->addCondition('designer_id',$this->id);
		foreach ($it as $ijunk) {
			$it->set('designer_id',null)->saveAndUnload();
		}

		$this->ref('xShop/ItemMemberDesign')->each(function($m){
			$m->forceDelete();
		});

		$this->ref('xShop/MemberImages')->each(function($m){
			$m->forceDelete();
		});

		$this->ref('xAccount/Account')->each(function($m){
			$m->set('customer_id',NULL)->saveAndUnload();
		});

		$this->delete();
	}


	function beforeSave(){
		$existing_check = $this->add('xShop/Model_MemberDetails');
		$existing_check->addCondition('users_id',$this['users_id']);
		$existing_check->addCondition('id','<>',$this->id);
		$existing_check->tryLoadAny();
		if(!isset($this->allow_re_adding_user) AND $this['user_id'] AND $existing_check->loaded())
			throw $this->exception('User is already member '. $this['user_id'],'ValidityCheck')->setField('users_id');
	}

	function Verify($emailId,$activation_code){
		// throw new \Exception("$emailId", 1);
		$member=$this->add('xShop/Model_MemberDetails');
		$member->addCondition('emailID',$emailId);
		$member->addCondition('activation_code',$activation_code);
		$member->tryLoadAny();
		if($member->loaded()){
			$member['is_verify']= true;
			$member->save();
			return true;
		}
		else
			return false;		
	}

	function is_registered($userName){
		$member=$this->add('xShop/Model_MemberDetails');
		$member->addCondition('emailID',$userName);
		$member->tryloadAny();
		if($member->loaded()){
			return true;
		}else{
			return false;
		}
	}


/** RAKESH WORK */
	function sendVerificationMail(){

		if(!$this->loaded()) throw $this->exception('Model Must Be Loaded Before Email Send');

		$this['activation_code'] = rand(10000,99999);
		$this->save();

		$epan=$this->add('Model_Epan');//load epan model
		$epan->tryLoadAny();
	
		$l=$this->api->locate('addons','xecommApp', 'location');
			$this->api->pathfinder->addLocation(
			$this->api->locate('addons','xecommApp'),
			array(
		  		'template'=>'templates',
		  		'css'=>'templates/css'
				)
			)->setParent($l);
			$tm=$this->add( 'TMail_Transport_PHPMailer' );
			$msg=$this->add( 'SMLite' );
			$msg->loadTemplate( 'mail/registrationMail' );

			//$msg->trySet('epan',$this->api->current_website['name']);		
			$enquiry_entries="some text related to register verification";
			$msg->trySetHTML('form_entries',$enquiry_entries);
			$msg->trySetHTML('activation_code',$this['activation_code']);

			$email_body=$msg->render();	

			$subject ="You Got a New Ecomm Customer";
				
			try{
			
				$tm->send($this['emailID'], $epan['email_username'], $subject, $email_body ,false,null);
			}catch( phpmailerException $e ) {
				// throw $e;
				$this->api->js(null,'$("#form-'.$_REQUEST['form_id'].'")[0].reset()')->univ()->errorMessage( $e->errorMessage() . " " . $epan['email_username'] )->execute();
			}catch( Exception $e ) {
				throw $e;
			}
	}

	function user($return_dummy=false){
		$user = $this->add('Model_Users')->addCondition('id',$this['users_id'])->tryLoadAny();
		if($user->loaded()) return $user;
		if($return_dummy) return new \Dummy();
		return false;
	}

	function is_current_user(){
		if($this['users_id'] == $this->api->auth->model->id)
			return true;
		return false;
	}

	function loadLoggedIn(){
		if($this->loaded()) $this->unload();
		if(!$this->api->auth->isLoggedIn()) return false;
		
		$this->addCondition('users_id',$this->api->auth->model->id);
		$this->tryLoadAny();
		if(!$this->loaded()) return false;
		return true;
	}

	function sendSubscribtionMail(){

		if(!$this->loaded()) throw $this->exception('Model Must Be Loaded Before Email Send');
		
		$l=$this->api->locate('addons','xecommApp', 'location');
			$this->api->pathfinder->addLocation(
			$this->api->locate('addons','xecommApp'),
			array(
		  		'template'=>'templates',
		  		'css'=>'templates/css'
				)
			)->setParent($l);
			$tm=$this->add( 'TMail_Transport_PHPMailer' );
			$msg=$this->add( 'SMLite' );
			$msg->loadTemplate( 'mail/subscribeMail' );

			//$msg->trySet('epan',$this->api->current_website['name']);		
			$enquiry_entries="some text related to register verification";
			$msg->trySetHTML('form_entries',$enquiry_entries);

			$email_body=$msg->render();	

			$subject ="Your Epan Got An Enquiry !!!";

			try{
				$tm->send( "", "info@epan.in", $subject, $email_body ,false,null);
			}catch( phpmailerException $e ) {
				// throw $e;
				$this->api->js($this->api->xecommauth->model->sendOrderDetail(),null,'$("#form-'.$_REQUEST['form_id'].'")[0].reset()')->univ()->errorMessage( $e->errorMessage() . " " . ""  )->execute();
			}catch( Exception $e ) {
				throw $e;
			}
	}

	

	function changePassword($old_passsword,$new_password){
		if(!$this->loaded())
			throw new \Exception('modal must be loaded at password change time');

		if($this['password']==$old_passsword){
			$this['password']=$new_password;
			$this->save();
			return true;
		}
		else{
			return false;
		}
	}

	function changeAddress($data){
		if(!$this->loaded())
			throw new \Exception('modal must be loaded at password change time');
		
		$this['address']=$data['street_address'];
		$this['landmark']=$data['landmark'];
		$this['city']=$data['city'];
		$this['state']=$data['state'];
		$this['country']=$data['country'];
		$this['pincode']=$data['pincode'];
		$this['mobile_number']=$data['mobile_number'];
		
		if($this->save())
			return true;
		else
			return false;
	}

	function updateInformation($info=array()){
		if(!$this->loaded())
			throw new \Exception("MemberDetails Model must be loaded before updatig information");
		
		$this['address']=$info['address'];				
		$this['shipping_address']=$info['address'];				
		$this['landmark']=$info['landmark'];
		$this['city']=$info['city'];
		$this['state']=$info['state'];
		$this['country']=$info['country'];
		$this['pincode']=$info['pincode'];
		$this['mobile_number']=$info['mobile_number'];

		$this->Update();
	}	

	function getAllDetail($user_id){
		$this->addCondition('users_id',$user_id);
		$this->tryLoadAny();
		return $this;
	}

	function is_verify($users_id){
		 $this->Load($users_id);
		 if($this['is_verify']==1){
		 return true;
		 }else 
		 	return false;
	}

	function deactivate(){
		if(!$this->loaded())
			return false;

		$this['is_active'] = false;
		$this->save();
		return true;
	}

}