<?php

class page_xShop_page_designer_itemimages extends Page {

	function page_index(){
		// parent::init();  
       // $this->add('View')->set('Member Images');
       $tabs = $this->add('Tabs');
       $tabs->addTabUrl('./upload','Your Library');
       // $tabs->addTabUrl('./previous_upload','Previuos Upload');
       $tabs->addTabUrl('./image_library','Image Library');
	}

  function page_upload(){

      $member = $this->add('xShop/Model_MemberDetails');
      $member->loadLoggedIn();

      $image_model = $this->add('xShop/Model_MemberImages');
      $image_model->addCondition('member_id',$member->id);
      $image_model->setOrder('id','desc');
      //Form
      // $form = $this->add('Form');
      // $form->addSubmit('upload');
      
      // // $item_images_lister = $this->add('xShop/View_Lister_DesignerItemImages');
      // $form->setModel($image_model,array('member_id','image_id'));
      
      $crud = $this->add('CRUD',array('allow_edit'=>false,'grid_class'=>'xGrid','grid_options'=>array('grid_template'=>'view/xShop-DesignerItemImages','grid_template_path'=>'epan-components/xShop')));
      $item_images_lister = $crud->setModel($image_model,array('member_id','image_id','image'));
      $crud->grid->addQuickSearch(array('image_id','image'));
      // if($form->isSubmitted()){
      //   $form->update();
      //   $form->js(true,$item_images_lister->js()->reload())->univ()->successMessage('Upload Successfully')->execute();
      // }
            
      //Lister
      // $item_images_lister->addClass('xshop-designer-image-lister');
      // $item_images_lister->setModel($image_model);
  }

  function page_previous_upload(){
      $this->add('View')->set('Previous Upload Images');
  }

  function page_image_library(){
      $this->add('View')->set('Library Images');

  }


}