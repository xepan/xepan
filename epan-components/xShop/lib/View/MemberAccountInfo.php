<?php
namespace xShop;
class View_MemberAccountInfo extends \View{
	function init(){
		parent::init();

		$member = $this->add('xShop/Model_MemberDetails');
		if(!$member->loadLoggedIn()){
			$this->add('View_Error')->set('Not Authorized');
			return;
		}

		$this->app->pathfinder->base_location->addRelativeLocation(
		    'epan-components/xShop', array(
		        'php'=>'lib',
		        'template'=>'templates',
		        'css'=>'templates/css',
		        'js'=>'templates/js',
		    )
		);

		$member->addCondition('users_id',$this->api->auth->model->id);
		$member->setLimit(1);
		$member->tryLoadAny();

		$tab = $this->add('Tabs');
		$profile_tab = $tab->addTab('Profile Photo');
		$password_tab = $tab->addTab('Change Password');
		$address_tab = $tab->addTab('Address');	
		$deactive_tab = $tab->addTab('Deactive My Account');
	
	// //============================Profile Photo
	// 	$pf = $profile_tab->add('Form');
		$add_button = false;
		if(!$member['member_photo_id'])
			$add_button = true;

		$c = $profile_tab->add('CRUD',['allow_add'=>$add_button,'allow_del'=>false]);
		$c->frame_options = ['width'=>'500'];
		$c->setModel($member,['member_photo_id'],['member_photo']);

		if(!$c->isEditing()){
			$g = $c->grid;
			$g->addMethod('format_member_photo',function($g,$f){
				$g->current_row_html[$f]='<img width="200px" src="'.$g->model['member_photo'].'"></img>';
			});
			$g->addFormatter('member_photo','member_photo');
		}

	//============================Change Password
		$user = $this->add('Model_Users')->load($this->api->auth->model->id);
		$this->api->auth->addEncryptionHook($user);
		$password_tab->add('View_Info')->set(" User Name:: ".$user['email']);
		$change_pass_form = $password_tab->add('Form');
		$change_pass_form->addField('password','old_password')->validateNotNull();
		$change_pass_form->addField('password','new_password')->validateNotNull();
		$change_pass_form->addField('password','retype_password')->validateNotNull();
		$change_pass_form->addSubmit('Update');
		
		if($change_pass_form->isSubmitted()){
			if( $change_pass_form['new_password'] != $change_pass_form['retype_password'])
				$change_pass_form->displayError('new_password','Password not match');
			
			if(!$this->api->auth->verifyCredentials($user['username'],$change_pass_form['old_password']))
				$change_pass_form->displayError('old_password','Password not match');

			if($user->updatePassword($change_pass_form['new_password'])){
				$change_pass_form->js()->univ()->successMessage('Password Changed Successfully')->execute();
			}

		}

	//================================Address======================
		$form=$address_tab->add('Form');
		$form->setLayout(['view/form/member-address']);
		$form->setModel($member,array('address'/*,'billing_address','shipping_address'*/,'landmark','city','state','country','mobile_number','pincode'));
		$form->addSubmit('Update');
		$users=$this->add('Model_Users')->load($this->api->auth->model->id);
		if($form->isSubmitted()){
			$form->update();
			$this->js(null,$form->js()->univ()->successMessage('Update Information Successfully'))->reload()->execute();
		}
	

	//===========================Deactivate=====================
		$deactive_form = $deactive_tab->add('Form');
		$deactive_form->addField('password','password')->validateNotNull();
		$deactive_form->addSubmit('Confirm Deactivation');
		if($deactive_form->isSubmitted()){
			if($user['password'] != $deactive_form['password'])
				$deactive_form->displayError('password','Deactivation Failed');	
			if($member->deactivate())
				$user->deactivate()?$deactive_form->js(null,$form->js()->univ()->successMessage('Account Deactivate SuccessFully'))->redirect($this->api->url(null,array('page'=>'logout')))->execute():$deactive_form->js(null,$form->js()->univ()->successMessage('Account Deactivate SuccessFully'))->reload()->execute();
		}

	}
}