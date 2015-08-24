<?php

class Grid extends Grid_Advanced{
	public $order=null;
    public $sno=1;
	public $sno_caption='s_no';

    public $show_epan=false;

	function init(){
		parent::init();

		$this->order= $this->addOrder();
        $this->addHook('formatRow',function($grid){
            if($grid->hasColumn('delete')){
                $grid->columns['delete']['descr']="";
            }
//            if($grid->hasColumn('edit')){                
//                $grid->current_row_html['edit']='<button type="button" class="atk-button-small pb_edit">fddf</button>';
//            }
        });
	}

    function _performDelete($id)
    {        
        if ($this->model) {
            if($this->model->hasMethod('forceDelete')){
                $this->model->load($id)->forceDelete();
            }
            else
                $this->model->delete($id);
        } else {
            $this->dq->where('id', $id)->delete();
        }
        if($this->api->db->inTransaction()) $this->api->db->commit();
    }

	function add_sno(){
		$this->addColumn('sno',$this->sno_caption);
		$this->order->move($this->sno_caption,'first');
        return $this;
	}

    function addSno(){
        return $this->add_sno();
    }

	function format_sno($field){
		$this->current_row[$field] = (($this->sno++) + ($_GET[$this->name.'_paginator_skip']?:0));
	}

	function init_boolean($field)
    {
        @$this->columns[$field]['thparam'] .= ' style="text-align: center"';
    }

    function format_boolean($field)
    {
        if ($this->current_row[$field] && $this->current_row[$field] !== 'N') {
            $this->current_row_html[$field] =
                '<div align=center>'.
                    '<span class="fa fa-circle" style="color:green"></span>'.
                '</div>';
        } else {
            $this->current_row_html[$field] = '<div align=center>'.
                    '<span class="fa fa-circle" style="color:red"></span>'.
                '</div>';
        }
    }

    function init_boolean_rev($field)
    {
        @$this->columns[$field]['thparam'] .= ' style="text-align: center"';
    }

    function format_boolean_rev($field)
    {
        if ($this->current_row[$field] && $this->current_row[$field] !== 'N') {
            $this->current_row_html[$field] = '<div align=center>'.
                    '<span class="fa fa-circle" style="color:red"></span>'.
                '</div>';
        } else {
            $this->current_row_html[$field] =
                '<div align=center>'.
                    '<span class="fa fa-circle" style="color:green"></span>'.
                '</div>';
        }
    }

    function format_image($field){
        $this->current_row_html[$field]='<a href="'.$this->current_row[$field].'" target="_blank">'.$this->current_row['name'].'</a>';
    }
    
    function format_imageThumbnail($field){
        $url = 'epan-components/xShop/templates/images/item_no_image.png';
        if($this->current_row[$field])
            $url = $this->current_row[$field];
        $this->current_row_html[$field]='<img class="img-thumbnail xepan-img-thumbnail" src="'.$url.'"></img>';
    }

    function addSelectable($field, $options=[])
    {
        $this->js_widget = null;
        $this->js(true)
            ->_load('ui.atk4_checkboxes')
            ->atk4_checkboxes(array('dst_field' => $field));
        $this->addColumn('checkbox', 'selected', $options);

        $this->addOrder()
            ->useArray($this->columns)
            ->move('selected', 'first')
            ->now();
    }

	function recursiveRender(){
		if($this->hasColumn('edit'))
			$this->order->move('edit','last');

		if($this->hasColumn('delete')){
			$this->order->move('delete','last');
        }
		
		if($this->order) $this->order->now();

        if(!$this->show_epan and $this->hasColumn('epan'))
            $this->removeColumn('epan');

		parent::recursiveRender();
	}

    function render(){
        if($this->load_footable){
            $this->js(true)->find('table')->_load('footable/footable.min')->footable();
        }
        parent::render();
    }

	// Overrided function from GridBasic.. to strip html tags from headers

	function addColumn($formatters, $name = null, $descr = null)
    {
        if ($name === null) {
            $name = $formatters;
            $formatters = 'text';
        }

        if ($descr === null) {
            $descr = ucwords(str_replace('_', ' ', $name));
        }
        $descr = $this->api->_($descr);

        $this->columns[$name] = array('type' => $formatters);

        if (is_array($descr)) {
            $this->columns[$name] = array_merge($this->columns[$name], $descr);
        } else {
            // $this->columns[$name]['descr'] = $descr; // Original Line
            if(($start_pos = strpos($descr, '<')) !==false ){
	            $this->columns[$name]['descr'] = substr($descr,0,$start_pos);
	            $this->columns[$name]['descr'] = $descr;
            }else
	            $this->columns[$name]['descr'] = $descr;
        }

        $this->last_column = $name;

        if (!is_string($formatters) && is_callable($formatters)) {
            $this->columns[$name]['fx'] = $formatters;
            return $this;
        }

        // TODO call addFormatter instead!
        $subtypes = explode(',', $formatters);
        foreach ($subtypes as $subtype) {
            if (strpos($subtype, '/')) {

                // add-on functionality:
                // http://agiletoolkit.org/codepad/gui/grid#codepad_gui_grid_view_example_7_ex
                if (!$this->elements[$subtype.'_'.$name]) {
                    $addon = $this->api->normalizeClassName($subtype, 'Controller_Grid_Format');
                    $this->elements[$subtype.'_'.$name] = $this->add($addon);
                }

                $addon = $this->getElement($subtype.'_'.$name);
                $addon->initField($name, $descr);
                return $addon;

            } elseif (!$this->hasMethod($m = 'init_'.$subtype)) {
                if (!$this->hasMethod($m = 'format_'.$subtype)) {
                    // exception if formatter doesn't exist
                    throw $this->exception('No such formatter')
                        ->addMoreInfo('formater', $subtype);
                }
            } else {
                // execute formatter init_*
                $this->$m($name, $descr);
            }
        }

        return $this;
    }

    // =========== Foo table section ==========
    public $load_footable=false;

    function fooHidePhone($column){
        $this->columns[$column]['thparam'] .= " data-hide='phone'";
        if(!$this->load_footable) $this->load_footable=true;
    }

    function fooHideTablet($column){
        $this->columns[$column]['thparam'] .= " data-hide='tablet'";
        if(!$this->load_footable) $this->load_footable=true;
    }

    function fooHideBoth($column){
        $this->columns[$column]['thparam'] .= " data-hide='phone,tablet'";
        if(!$this->load_footable) $this->load_footable=true;
    }

    function fooHideAlways($column){
        $this->columns[$column]['thparam'] .= " data-hide='all'";
        if(!$this->load_footable) $this->load_footable=true;
    }

    function fooToggler($column){
        $this->columns[$column]['thparam'] .= " data-toggle='true'";
    }

    function updateGrandTotals()
    {
        // get model
        $m = clone $this->getIterator();

        // create DSQL query for sum and count request
        $fields = array_keys($this->totals);

        // select as sub-query
        $sub_q = $m->_dsql()->del('limit')->del('order');

        // $q = $this->api->db->dsql();//->debug();
        // $q->table($sub_q->render(), 'grandTotals'); // alias is mandatory if you pass table as DSQL
        foreach ($fields as $field) {
            $sub_q->field($sub_q->sum($field), $field);
        }
        $sub_q->field($sub_q->count(), 'total_cnt');

        // execute DSQL
        $data = $sub_q->getHash();

        // parse results
        $this->total_rows = $data['total_cnt'];
        unset($data['total_cnt']);
        $this->totals = $data;
    }

}