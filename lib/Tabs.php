<?php
class Tabs extends View_Tabs_jUItabs {


function addTabURL($page,$title=null){
        if(is_null($title)){
            $title=ucwords(preg_replace('/[_\/\.]+/',' ',$page));
        }
        $this->tab_template->setHTML(array(
                    'url'=>$this->api->url($page,array('cut_page'=>1)),
                    'tab_name'=>$title,
                    'tab_id'=>basename($page),
                    ));
        $this->template->appendHTML('tabs',$this->tab_template->render());
        return $this;
    }
}