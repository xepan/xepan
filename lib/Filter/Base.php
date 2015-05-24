<?php

class Filter_Base extends Filter
{

    // icons
    public $submit_icon = 'ui-icon-search';
    public $cancel_icon = 'ui-icon-cancel';

    // field
    public $search_field;

    // buttonset
    public $bset_class = 'ButtonSet';
    public $bset_position = 'after'; // after|before
    protected $bset;

    // cancel button
    public $show_cancel = true; // show cancel button? (true|false)

    /**
     * Initialization
     *
     * @return void
     */
    function init()
    {
        parent::init();

        // template fixes
        $this->addClass('atk-form atk-form-stacked atk-form-compact atk-move-right');
        $this->template->trySet('fieldset', 'atk-row');
        $this->template->tryDel('button_row');

        // $this->addClass('atk-col-3');
    }

    function recursiveRender(){
        // cancel button
        if($this->show_cancel && $this->recall($this->search_field->short_name)) {
            $this->add('View',null,'cancel_button')
                ->setClass('atk-cell')
                ->add('HtmlElement')
                ->setElement('A')
                ->setAttr('href','javascript:void(0)')
                ->setClass('atk-button')
                ->setHtml('<span class="icon-cancel atk-swatch-red"></span>')
                ->js('click', array(
                    $this->search_field->js()->val(null),
                    $this->js()->submit()
                ));
        }

        // search button
        $this->search_btn = $this->add('HtmlElement',null,'form_buttons')
            ->setElement('A')
            ->setAttr('href','javascript:void(0)')
            ->setClass('atk-button')
            ->setHtml('<span class="icon-search"></span>')
            ->js('click', $this->js()->submit());

        parent::recursiveRender();
    }

    /**
     * Set fields on which filtering will be done
     *
     * @param string|array $fields
     * @return QuickSearch $this
     */
    function useFields($fields)
    {
        if(is_string($fields)) {
            $fields = explode(',', $fields);
        }
        $this->fields = $fields;
        return $this;
    }

    function defaultTemplate(){
        return array('view/form/xquicksearch');
        return array('form/quicksearch');
        return array('form_horizontal');
        return array('form_empty');
    }
}
