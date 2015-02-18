<?php
namespace xHR;

class Model_Post extends \Model_Table{
	public $table="xhr_posts";
	function init(){
		parent::init();
		$this->hasOne('xHR/Model_Department','department_id');
		$this->hasOne('xHR/Model_Post','parent_post_id');

		$this->addField('name')->caption('Post');
		$this->addField('is_active')->type('boolean')->defaultValue(true);
		
		$this->hasMany('xHR/Post','parent_post_id',null,'SubPosts');
		$this->hasMany('xHR/SalaryTemplate','post_id');
		$this->hasMany('xHR/Employee','post_id');
		$this->hasMany('xHR/DocumentAcl','post_id');
		
		$this->addHook('beforeSave',$this);
		$this->addHook('beforeDelete',$this);
		
		$this->add('Controller_Validator');
		$this->is(array(
							'name|to_trim|required',
							)
					);
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeSave($m){
		// todo checking SKU value must be unique
		$post_old=$this->add('xHR/Model_Post');
		if($this->loaded())
			$post_old->addCondition('id','<>',$this->id);
		$post_old->tryLoadAny();

		if($post_old['name'] == $this['name'])
			throw $this->exception('Post is Allready Exist','Growl')->setField('name');
	}

	function beforeDelete($m){
		$emp_count = $m->ref('xHR/Employee')->count()->getOne();
		
		if($emp_count){
			$this->api->js(true)->univ()->errorMessage('Cannot Delete,first delete Employees')->execute();	
		}
	}
	
	function getSiblings(){
		$posts_ids= $this->add('xHR/Model_Post')->addCondition('parent_post_id',$this['parent_post_id'])->_dsql()->del('fields')->field('id')->getAll();
		return iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($posts_ids)),false);
	}

	function getDescendants($ids=null){
		if($ids==null) $ids=array($this->id);
		$posts_ids = $this->add('xHR/Model_Post')->addCondition('parent_post_id',$ids)->_dsql()->del('fields')->field('id')->getAll();
		$posts_ids = iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($posts_ids)),false);
		if(count($posts_ids))
			return array_merge($posts_ids,$this->getDescendants($posts_ids));
		else
			return $posts_ids;
	}

	function documentAcls(){
		return $this->ref('xHR/DocumentAcl');
	}

}