<?php

class Frontend extends ApiFrontend{
	/**
	 * stores currrent website model object
	 *
	 * @var Model_Epan
	 */
	public $current_website=null;
	/**
	 * Stores current page about to render
	 *
	 * @var Model_EpanPage
	 */
	public $current_page=null;
	/**
	 * Stores Website requested from GET[config['website_request_variable']]
	 *
	 * @var String
	 */
	public $website_requested=null;
	/**
	 * Stores Page requested from GET[config['page_request_variable']]
	 *
	 * @var String
	 */
	public $page_requested=null;
	/**
	 * Handels CMS mode,
	 * If set to true all editing features will be enabled in frontend side
	 *
	 * @var boolean
	 */
	public $edit_mode=false;

	/**
	 * Edit Template Mode
	 * sets to true if editing Template
	 */
	public $edit_template = false;

	/**
	 * $epan_plugins contains all plugins associated with this website/epan
	 * loaded in frontend
	 *
	 * @var array
	 */
	public $website_plugins=array();

	public $max_name_length=40;

	public $today;
	public $now;
	/*
	* @var Model_xShop_Configuration
	 */
	public $current_xshop_configuration=null;

	function init() {
		parent::init();
		
		$this->requires( 'atk', '4.2.0' );
		

		$this->addLocation(array(
			'js'=>'atk4/public/atk4/js'
			))->setParent( $this->pathfinder->base_location );

		$this->addLocation(array(
				'addons'=>array( 'epan-addons', 'epan-components', 'atk4-addons' ))
		)->setParent( $this->pathfinder->base_location );
	
		$this->add('performance/Controller_Profiler');

		$this->addLocation(array(
            'page'=>array('epan-components','epan-addons'),
            'js'=>array('templates/js'),
            'css'=>array('templates/js','templates/css'),
        ))->setParent($this->pathfinder->base_location);

		if ( !file_exists('config-default.php')) {
			// Not installed and installation required
			// TODO : check security issues
			$config['url_postfix']='';
			$config['url_prefix']='?page=';

			$this->setConfig($config);
			$this->add( 'jUI' );

			$this->js()
			// ->_load( 'atk4_univ' )
			->_load( 'ui.atk4_notify' )
			;
			
			$this->page = 'install';
		}else {
			// already installed connect to provided settings and go on
			$this->dbConnect();

			$this->add( 'jUI' );
			$this->api->template->appendHTML('js_include','<script src="templates/js/jquery-migrate-1.2.1.min.js"></script>'."\n");
			$this->api->template->appendHTML('js_include','<script src="templates/js/xepan-jquery.js"></script>'."\n");
			/**
			 * TODO: wrap in a IF(page does not contains owner_ / branch_ / system_ )
			 * only then you need to get all this, as you are looking front of a website
			 * -----------------------------------------------------------------------
			 * Get the request from browser query string and set various Api variables like
			 * current_website, current_page, website_requested and page_requested
			 * Once set that can be accessed all CMS vise like
			 * $this->api->current_website
			 */
			if ( true /*page does not contain owner_ / branch_ or system_ */ ) {
				$site_parameter= $this->getConfig( 'url_site_parameter' );
				$page_parameter= $this->getConfig( 'url_page_parameter' );

				$this->stickyGET( $site_parameter );
				$this->stickyGET( $page_parameter );

				$this->website_requested = $this->getConfig( 'default_site' );
				$this->api->memorize('website_requested',$this->website_requested);
				/**
				 * $this->page_requested finds and gets the requested page
				 * Always required in both multi site mode and single site mode
				 *
				 * @var String
				 */
				$this->page_requested=trim( $_GET[$page_parameter], '/' )
					?  trim( $_GET[$page_parameter], '/' )
					: $this->getConfig( 'default_page' );

				if ( $this->isAjaxOutput() or $_GET['cut_page'] ) {
					// set page_requested to referrer page not the page requested by
					// ajax request
					$this->add( 'Controller_AjaxRequest' );

				}


				
				$this->current_website = $this->add( 'Model_Epan' )->tryLoadBy( 'name', $this->website_requested );
				if ( $this->current_website->loaded() ) {
					$this->current_page = $this->current_website->ref( 'EpanPage' )
					->addCondition( 'name', $this->page_requested )
					->tryLoadAny();
				}else {
					$this->exec_plugins( 'error404', $this->website_requested );
				}

				$this->add( 'Controller_EpanCMSApp' )->frontEnd();
				
				
				// MULTISITE CONTROLER
				// $this->load_plugins();
				// $this->add( 'Controller_EpanCMSApp' )->frontEnd();
				// if ( $this->current_website->loaded() )
				// 	$this->exec_plugins( 'website-loaded', $this->api->current_website );
				// if ( $this->current_page->loaded() )
				// 	$this->exec_plugins( 'website-page-loaded', $this->api->page_requested );

			}
			
			date_default_timezone_set($this->current_website['time_zone']?:'UTC');
			$this->today = date('Y-m-d',strtotime($this->recall('current_date',date('Y-m-d'))));
        	$this->now = date('Y-m-d H:i:s',strtotime($this->recall('current_date',date('Y-m-d H:i:s'))));
			$this->current_employee = $this->add('xHR/Model_Employee');

			$auth=$this->add( 'BasicAuth' );
			$auth->setModel( 'Users', 'username', 'password' );
			$auth->usePasswordEncryption();
			$auth->addHook('loggedIn',function($auth,$user,$pass){
				$auth->model['last_login_date'] = $auth->api->now;
				$auth->model->save();
			});

			if($this->api->auth->isLoggedIn() AND $this->api->auth->model->ref('epan_id')->get('name')==$this->api->website_requested AND $this->api->auth->model['type'] >= 80 AND !$this->stickyGET('preview')){
				$this->edit_mode = true;
			}

			if($this->edit_mode AND $_GET['edit_template']){
				$this->edit_template = true;
				// $this->api->template->appendHTML('js_include','\nsfjdhkj;\n');
				$this->stickyGET('edit_template');
			}

			$this->load_plugins();

			// Global Template Setting
			if(in_array('shared', $this->defaultTemplate()) and $this->page == 'index'){
				
				$temp = array();
				$this->exec_plugins('beforeTemplateInit',$temp);

				if($this->edit_template){
					$this->current_template = $current_template = $this->add('Model_EpanTemplates')->load($_GET['edit_template']);
				}else{
					$this->current_template = $current_template = $this->current_page->ref('template_id');
				}

				if($current_template->loaded()){
					if(!$this->edit_template){
						// Remove contenteditable from template strings
						// In General Page View Mode
						$this->api->exec_plugins('content-fetched',$current_template);
						
					}

					$shared_template = file_get_contents('templates/shared.html');
					/*$content .= '<?$Content?>';*/
					if(!$this->edit_template){
						include_once (getcwd().'/lib/phpQuery.php');
						$pq = new \phpQuery();
						$doc = $pq->newDocument($current_template['content']);
						
						$content_divs = $doc['div:contains("~~Content~~")'];
						$i=0;
						foreach($content_divs as $temp){
							$i++;
						}

						if($i==0){
							$current_template['content'] .= "~~Content~~";
						}


						$current_template['content'] = str_replace("~~Content~~", '{$Content}', $current_template['content']);
						$shared_template = str_replace('{$Content}', $current_template['content'], $shared_template);	
					}else{
						$shared_template = str_replace('{$Content}', $current_template['content'], $shared_template);
						$shared_template .= '{$Content}';
					}

					// Saving since serverside components have been run already 
					// as plugin and they may have set some js_include ect in shared
					// But now shared template is about to load from string and 
					// old includes etc will be lost so ...
					$old_jui = $this->api->jui;
					$old_js_include = $this->template->tags['js_include'];
					$old_js_doc_ready = $this->template->tags['document_ready'];
					// echo "<pre>";
					// echo print_r($old_js_doc_ready,true);
					// echo "</pre>";
					// throw new Exception("sdf" , 1);

					$this->template->loadTemplateFromString($shared_template);
					$this->template->appendHTML('js_include',implode("\n", $old_js_include[1]));
					$this->template->appendHTML('document_ready',implode("\n",$old_js_doc_ready[1]));
					$this->template->trySet('template_css',$current_template['css']);
					$this->template->trySet('style',$current_template['body_attributes']);
					
					$this->api->jui  = $old_jui;
					
				}
				
				if ( $this->current_website->loaded() )
					$this->exec_plugins( 'website-model-loaded', $this->api->current_website );
				if ( $this->current_page->loaded() )
					$this->exec_plugins( 'website-page-model-loaded', $this->api->page_requested );
			
			}
			// unset($this->api->jui);
			// $this->add( 'jUI' );

			if(in_array('owner', $this->defaultTemplate())){
				$l=$this->add('Layout_Fluid');
			}

			// A lot of the functionality in Agile Toolkit requires jUI
			$this->js()
			// ->_load( 'ui.atk4_univ' )
			->_load( 'ui.atk4_notify' )
			;
			
			setlocale(LC_MONETARY, 'en_IN');
			$this->xpr->markPoint('Front-end init Finished');
		}
	}

	function load_plugins() {

		$this->website_plugins_array=array();
		$this->website_plugins=array();

		$plugins = $this->add( 'Model_Plugins' );
		$marketplace_j = $plugins->join('epan_components_marketplace','component_id');
		$installed_j= $marketplace_j->leftJoin('epan_installed_components.component_id');
		
		$marketplace_j->addField('namespace');
		$installed_j->addField('epan_id');

		$plugins->setOrder('is_system');

		$plugins->_dsql()->where(
				$plugins->dsql()->orExpr()
					->where('epan_id', $this->api->current_website->id )
					->where($plugins->table.'.is_system', true )
				);

		foreach ( $plugins->getRows() as $plg ) {
			if ( !in_array( $plg_url=$plg['namespace'].'/Plugins_'.$plg['name'], $this->website_plugins_array ) ) {
				$p = $this->add( $plg['namespace'].'/Plugins_'.str_replace("_", "", $this->api->normalizeName($plg['name'] )));
				$this->website_plugins_array[] = $plg_url;
				$this->website_plugins[] = $p;
			}
		}
	}

	function event($event_hook, &$param){
		$this->exec_plugins($event_hook,$param);
	}

	function exec_plugins( $event_hook, &$param ) {
		if ( !is_array( $param ) )
			$param_array = array( &$param );
		else
			$param_array = $param;

		// if(empty($this->website_plugins))
		//  throw $this->exception("No Plugin loaded");

		foreach ( $this->website_plugins as $p ) {
			// echo $event_hook. " on ". $p ."<br/>";
			$p->hook( $event_hook, $param_array );
		}
		return;
	}

	function defaultTemplate() {
		if ( strpos( str_replace( "/", "_", $_GET['page'] ), 'owner_' )!==false ) {
			return array( 'owner' );
		}

		return array( 'shared' );
	}

	function xcopy($source, $dest) {

		if(!file_exists($dest)) mkdir($dest, 0777);
		foreach (
		  $iterator = new RecursiveIteratorIterator(
		  new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
		  RecursiveIteratorIterator::SELF_FIRST) as $item) {
		  if ($item->isDir()) {
		    mkdir($dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
		  } else {
		    copy($item, $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
		  }
		}
	}

	function rrmdir($dir) {
	   if (is_dir($dir)) {
	    	$objects = scandir($dir);
	    	foreach ($objects as $object) {
	    		if ($object != "." && $object != "..") {
	        		if (filetype($dir."/".$object) == "dir") $this->rrmdir($dir."/".$object); else unlink($dir."/".$object);
	    		}
	    	}
	    	reset($objects);
	    	rmdir($dir);
	   	}
	}

	function getxEpanVersion(){
		return file_get_contents('version');
	}


	function addSharedLocations($path_finder, $base_directory){
		
	}

	function setDate($date){
        $this->api->memorize('current_date',$date);
        $this->now = date('Y-m-d H:i:s',strtotime($date));
        $this->today = date('Y-m-d',strtotime($date));
    }

    function nextDate($date=null){
        if(!$date) $date = $this->api->today;
        $date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . " +1 DAY"));    
        return $date;
    }

    function previousDate($date=null){
        if(!$date) $date = $this->api->today;
        $date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . " -1 DAY"));    
        return $date;
    }

    function monthFirstDate($date=null){
        if(!$date) $date = $this->api->now;

        return date('Y-m-01',strtotime($date));
    }

    function monthLastDate($date=null){
        if(!$date) $date = $this->api->now;

        return date('Y-m-t',strtotime($date));
    }

    function nextMonth($date=null){
        if(!$date) $date=$this->api->today;

        return date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . " +1 MONTH"));
    }

    function previousMonth($date=null){
        if(!$date) $date=$this->api->today;

        return date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . " -1 MONTH"));
    }

    function nextYear($date=null){
        if(!$date) $date=$this->api->today;

        return date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . " +1 YEAR"));
    }

    function previousYear($date=null){
        if(!$date) $date=$this->api->today;

        return date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . " -1 YEAR"));
    }

    function getFinancialYear($date=null,$start_end = 'both'){
        if(!$date) $date = $this->api->now;
        $month = date('m',strtotime($date));
        $year = date('Y',strtotime($date));
        if($month >=1 AND $month <=3  ){
            $f_year_start = $year-1;
            $f_year_end = $year;
        }
        else{
            $f_year_start = $year;
            $f_year_end = $year+1;
        }

        if(strpos($start_end, 'start') !==false){
            return $f_year_start.'-04-01';
        }
        if(strpos($start_end, 'end') !==false){
            return $f_year_end.'-03-31';
        }

        return array(
                'start_date'=>$f_year_start.'-04-01',
                'end_date'=>$f_year_end.'-03-31'
            );

    }

    function getFinancialQuarter($date=null,$start_end = 'both'){
        if(!$date) $date = $this->api->today;

        $month = date('m',strtotime($date));
        $year = date('Y',strtotime($date));
        
        switch ($month) {
            case 1:
            case 2:
            case 3:
                $q_month_start='-01-01';
                $q_month_end='-03-31';
                break;
            case 4:
            case 5:
            case 6:
                $q_month_start='-04-01';
                $q_month_end='-06-30';
                break;
            case 7:
            case 8:
            case 9:
                $q_month_start='-07-01';
                $q_month_end='-09-30';
                break;
            case 10:
            case 11:
            case 12:
                $q_month_start='-10-01';
                $q_month_end='-12-31';
                break;
        }

        
        if(strpos($start_end, 'start') !== false){
            return $year.$q_month_start;
        }
        if(strpos($start_end, 'end') !== false){
            return $year.$q_month_end;
        }

        return array(
                'start_date'=>$year.$q_month_start,
                'end_date'=>$year.$q_month_end
            );

    }

    function my_date_diff($d1, $d2){
        $d1 = (is_string($d1) ? strtotime($d1) : $d1);
        $d2 = (is_string($d2) ? strtotime($d2) : $d2);

        $diff_secs = abs($d1 - $d2);
        $base_year = min(date("Y", $d1), date("Y", $d2));

        $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
        return array(
        "years" => date("Y", $diff) - $base_year,
        "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
        "months" => date("n", $diff) - 1,
        "days_total" => floor($diff_secs / (3600 * 24)),
        "days" => date("j", $diff) - 1,
        "hours_total" => floor($diff_secs / 3600),
        "hours" => date("G", $diff),
        "minutes_total" => floor($diff_secs / 60),
        "minutes" => (int) date("i", $diff),
        "seconds_total" => $diff_secs,
        "seconds" => (int) date("s", $diff)
        );
    }

}
