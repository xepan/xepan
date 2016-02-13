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

      //Check Member Auth
      $member = $this->add('xShop/Model_MemberDetails');
      $member->loadLoggedIn();

      //Creating Column
      $col = $this->add('Columns');
      $cat_col = $col->addColumn(4);
      $image_col = $col->addColumn(8);

      //Category Crud and It's Model
      $cat_crud = $cat_col->add('CRUD',array('entity_name'=>'Category'));
      $cat_crud->frame_options = ['width'=>'500'];
      $cat_model = $this->add('xShop/Model_ImageLibraryCategory')->addCondition('is_library',false)->addCondition('member_id',$member->id);
      $cat_crud->setModel($cat_model,array('name'));
      
      if(!$cat_crud->isEditing()){
        $g = $cat_crud->grid;
        $g->addMethod('format_width',function($g,$f){
          $g->current_row_html[$f] = '<div style="white-space:normal !important;">'.$g->current_row[$f]."</div>";
        });
        $g->addFormatter('name','width');
      }

      //Member Images
      //Setting up Model according to the Category id
      $image_model = $image_col->add('xShop/Model_MemberImages');
      $image_model->addCondition('member_id',$member->id);
      $image_model->setOrder('id','desc');
      if($cat_id = $this->api->stickyGET('cat_id')){
        $image_model->addCondition('category_id',$cat_id);        
      }

      //Member Image Crud
      $crud = $image_col->add('CRUD',array('entity_name'=>'Image','allow_edit'=>false,'grid_class'=>'xGrid','grid_options'=>array('grid_template'=>'view/xShop-DesignerItemImages','grid_template_path'=>'epan-components/xShop')));
      $crud->frame_options = ['width'=>'500'];
      $item_images_lister = $crud->setModel($image_model,array('category_id','member_id','image_id','image'),array('member_id','image_id','image'));
      $crud->grid->addQuickSearch(array('image_id','image'));
      $crud->grid->addPaginator(12);

      $img_url = $this->api->url(null,['cut_object'=>$image_col->name]);
      $cat_url = $this->api->url(null,['cut_object'=>$cat_col->name]);

      //Jquery For Filter the images
      $cat_col->on('click','tr',function($js,$data)use($image_col,$img_url,$cat_col){
        return [
            $cat_col->js()->children('td')->find('.atk-swatch-green')->removeClass('atk-swatch-green'),
            $image_col->js()->reload(['cat_id'=>$data['id']],null,$img_url),
            $js->children('td:first-child ')->addClass('atk-swatch-green'),
          ] ;
      });

      //All Category Filter 
      $all_cat_btn = $crud->grid->addButton('All Category');
      $self = $this;

      $all_cat_btn->on('click',function($js,$data)use($cat_col,$cat_url,$image_col,$img_url,$self){
        $self->api->stickyForget('cat_id');
        return [
            $image_col->js()->reload(['cat_id'=>0],null,$img_url),
            $cat_col->js()->find('.atk-swatch-green')->removeClass('atk-swatch-green')
          ]; 
      });
  }

  function page_previous_upload(){
      $this->add('View')->set('Previous Upload Images');
  }

  function page_image_library(){
    $image_model = $this->add('xShop/Model_MemberImages');
    $image_model->addCondition('category_id','>',0);
    $image_model->setOrder('id','desc');

    $crud = $this->add('CRUD',array('allow_edit'=>false,'allow_del'=>false,'allow_add'=>false,'grid_class'=>'xGrid','grid_options'=>array('grid_template'=>'view/xShop-DesignerItemImages','grid_template_path'=>'epan-components/xShop')));
    $crud->setModel($image_model);
    $crud->grid->addQuickSearch(array('image_id','image','category','category_id','alt_text','title'));
  }


}