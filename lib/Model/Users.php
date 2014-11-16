<?php
class Model_Users extends Model_Table {
	var $table= "users";
	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id')->mandatory(true);
		//$this->addCondition('epan_id',$this->api->current_website->id);
		
		$this->addField('name');
		$this->addField('email');
		$this->addField('username')->group('a/6');
		$this->addField('password')->type('password')->group('a/6');
		$this->addField('created_at')->type('date')->defaultValue(date('Y-m-d'));
		// $this->addField('is_systemuser')->type('boolean')->defaultValue(false);
		// $this->addField('is_frontenduser')->type('boolean')->defaultValue(false);
		// $this->addField('is_backenduser')->type('boolean')->defaultValue(false);
		$this->addField('type')->setValueList(array(100=>'SuperUser',80=>'BackEndUser',50=>'FrontEndUser'))->defaultValue(0);
		$this->addField('is_active')->type('boolean')->defaultValue(false);
		$this->addField('activation_code')->group('b/3');
		$this->addField('last_login_date')->type('date')->group('b/9');

		$this->addHook('beforeDelete',$this);
		$this->addHook('beforeSave',$this);
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeSave(){
		// Check username for THIS EPAN
		$old_user = $this->add('Model_Users');
		$old_user->addCondition('username',$this['username']);
		
		if(isset($this->api->current_website))
			$old_user->addCondition('epan_id',$this->api->current_website->id);
		if($this->loaded()){
			$old_user->addCondition('id','<>',$this->id);
		}
		$old_user->tryLoadAny();
		if($old_user->loaded()){
			// throw $this->exception("This username is allready taken, Chose Another");
			$this->api->js()->univ()->errorMessage('This username is allready taken, Chose Another')->execute();
		}
	}

	function beforeDelete(){
		if($this['username'] == $this->ref('epan_id')->get('name'))
			throw $this->exception("You Can't delete it, it is default username");
			
	}

	function sendVerificationMail($email=null,$type=null,$activation_code=null){
		
		if(!$this->loaded()){
			$this->addCondition('email',$email);
			$this->tryLoadAny();
		}	

		$this['email'] = $email;
		$this['activation_code'] = $activation_code;
		$this->save();
		$type = null;

			$tm=$this->add( 'TMail_Transport_PHPMailer' );

			$subject =$this->api->current_website['user_registration_email_subject'];
			$email_body=$this->api->current_website['user_registration_email_message_body'];	
			$email_body=str_replace("{{name}}", $this['name'], $email_body);
			$email_body=str_replace("{{email}}", $this['email'], $email_body);
			$email_body=str_replace("{{user_name}}", $this['username'], $email_body);
			$email_body=str_replace("{{password}}", $this['password'], $email_body);
			$email_body=str_replace("{{activation_code}}", $this['activation_code'], $email_body);
 			
 			$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
			$host     = $_SERVER['HTTP_HOST'];
			$script   = $_SERVER['SCRIPT_NAME'];
			$params   = $_SERVER['QUERY_STRING'];
			$currentUrl = $protocol. '://' .$host;	 		

			$email_body=str_replace("{{click_here_to_activate}}", 
											"<a href=\"".$currentUrl.str_replace("&new_registration=1","", $this->api->url(null,array(
													'activation_code'=>$this['activation_code'],
													'activate_email'=>$this['email'],
													'verify_account'=>1
												)))."\">Click Here to Activate Your Account</a>",$email_body);				
			try{
				$tm->send( $this['email'], $this->api->current_website['email_username'], $subject, $email_body ,false,null);
				return true;
			}catch( phpmailerException $e ) {
				$this->api->js()->univ()->errorMessage( $e->errorMessage() . " "  )->execute();
			}catch( Exception $e ) {
				throw $e;
			}
	}

	function verifyAccount($email, $activation_code){
								
		$this->addCondition('email',$email);
		$this->tryLoadAny();
		if($this['activation_code']==$activation_code){
			$this['is_active']=true;
			$this->update();
			return true;
		}else
			return false;
	}		

}
