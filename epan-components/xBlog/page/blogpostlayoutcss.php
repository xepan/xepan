<?php

class page_xBlog_page_blogpostlayoutcss extends Page {
	function init(){
		parent::init();
		
		$css_name = $this->api->stickyGET('xblog_post_layout').".css";
		$css_file = getcwd().DS.'epans'.DS.$this->api->current_website['name'].DS.$css_name;
		$css_file_orig = getcwd().DS.'epan-components'.DS.'xBlog'.DS.'templates'.DS.'css'.DS.$css_name;
		
		if(!file_exists($css_file)){
			$css_content_orig = file_get_contents($css_file_orig);
			// throw new \Exception($css_content_orig);
			file_put_contents($css_file, $css_content_orig);			
		}

		$css_content = file_get_contents($css_file);

		$form = $this->add('Form');
		$form->addField('text','css')->addClass('post-customcss')->set($css_content);
		$form->addSubmit('UPDATE');

		if($form->isSubmitted()){
			$user_css = 'epans'.DS.$this->api->current_website['name'].DS.$css_name;
			$new_css_content = $form['css'];
			file_put_contents($user_css, $new_css_content);
			$form->js(
				null,
				$form->js()->_selector('#xblog-post-customcss-link')->attr('href',$user_css."?".rand(1000,9999))
				)->univ()->closeDialog()->execute();
		}

	}
}