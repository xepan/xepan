<?php

namespace xEnquiryNSubscription;


class Model_NewsLetterCategory extends \Model_Document{
	public $table ='xenquirynsubscription_newslettercategory';
	public $status = array();
	public $root_document_name = 'xEnquiryNSubscription\NewsLetterCategory';
	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array()
			
		);



	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$f=$this->addField('name')->mandatory(true)->group('a1~6~NewsLetter Category')->sortable(true)->display(array('grid'=>'shorttext'));
		$f->icon='fa fa-adn~red';

		$this->addExpression('newsletters')->set(function($m,$q){
			return $m->refSQL('xEnquiryNSubscription/NewsLetter')->count();
		});

		$this->hasMany('xEnquiryNSubscription/NewsLetter','category_id');

		$this->addHook('beforeDelete',$this);

		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeDelete(){
		if($this->ref('xEnquiryNSubscription/NewsLetter')->count()->getOne() > 0)
			throw $this->exception('Category contains Newsletters','Growl');
	}

}