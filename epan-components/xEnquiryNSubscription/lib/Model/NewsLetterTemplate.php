<?php

namespace xEnquiryNSubscription;


class Model_NewsLetterTemplate extends \Model_Document{
	public $table ='xenquirynsubscription_newsletter_templates';
	public $status = array();
	public $root_document_name = 'xEnquiryNSubscription\NewsLetterTemplate';
	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array()
			
		);


	public $title_field= 'title';
	
	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$f=$this->addField('title')->mandatory(true)->group('a1~6~NewsLetter Templates')->sortable(true)->display(array('grid'=>'shorttext'));
		$f->icon='fa fa-adn~red';
		$this->addField('description')->type('text');
		$this->addField('content')->type('text')->display(array('form'=>'RichText'))->mandatory(true);
		//$this->add('dynamic_model/Controller_AutoCreator');
	}

}