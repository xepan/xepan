<?php

class page_componentBase_page_owner_main extends page_base_owner{
	public $toolbar;
	public $component_namespace;
	public $component_name;

	function init() {
		parent::init();


		$class = get_class( $this );
		preg_match( '/page_(.*)_page_(.*)/', $class, $match );

		$this->component_namespace = $match[1];
		$mp=$this->add('Model_MarketPlace')->loadBy('namespace',$this->component_namespace);
		$this->component_name = $mp['name'];

		$l=$this->api->locate( 'addons', $match[1], 'location' );
		$this->api->pathfinder->addLocation(
			$this->api->locate( 'addons', $match[1] ),
			array(
				'template'=>'templates',
				'css'=>'templates/css'
			)
		)->setParent( $l );

		$cols = $this->add( 'Columns' );
		$left = $cols->addColumn( 6 );
		$right = $cols->addColumn( 6 );

		$this->h1 = $h1=$left->add( 'H1' )->set( $this->component_name );

		$this->toolbar = $right->add( 'ButtonSet' )->addClass( 'pull-right' );

		$about_page= $right->add( "VirtualPage" );
		$about_page->set( function( $p )use( $match ) {
				$p->add( 'View', null, null, array( 'view/'.$match[1].'-about' ) );
			}
		);

		$uninstall_page= $right->add( "VirtualPage" );
		$uninstall_page->set( function( $p )use( $match ) {
				$p->add( 'View_Error')->set('Are you sure, you want to uninstall this application');
				$btn=$p->add('Button')->set('Yes');
				if($btn->isClicked()){
					$p->api->redirect($p->api->url($match[1].'_page_uninstall'));
				}
			}
		);

		$update_page= $right->add( "VirtualPage" );
		$update_page->set( function( $p )use( $match ) {
				$p->add( 'View_Info')->set('Are you sure, you want to update this application');
				$btn=$p->add('Button')->set('Yes');
				if($btn->isClicked()){
					$p->js()->univ()->frameURL( 'Update This Component', $p->api->url($p->api->url($match[1].'_page_owner_update')) )->execute();
					// $p->api->redirect($p->api->url($match[1].'_page_owner_update'));
				}
			}
		);

		$this->toolbar->addButton( 'Info' )->js( 'click', $this->js()->univ()->frameURL( 'About This Component', $about_page->getURL() ) );
		$this->toolbar->addButton( 'Update' )->js( 'click', $this->js()->univ()->frameURL( 'Update This Component', $update_page->getURL() ) );
		$this->toolbar->addButton( 'Uninstall' )->js( 'click', $this->js()->univ()->frameURL( 'Uninstall This Component', $uninstall_page->getURL() ) );

		if($this->api->isAjaxOutput() or $_GET['cut_page']){
			$h1->destroy();
			$this->toolbar->destroy();
		}

	}
}
