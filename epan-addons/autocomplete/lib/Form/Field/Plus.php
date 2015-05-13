<?php
namespace autocomplete;

class Form_Field_Plus extends Form_Field_Basic
{
    function setModel($model)
    {
        parent::setModel($model);
        $self = $this;

        $f = $this->other_field;

        // Add buttonset to name field
        $bs = $f->afterField()->add('ButtonSet');

        // Add button - open dialog for adding new element
        $bs->add('Button')
            ->set('+')
            ->add('VirtualPage')
            ->bindEvent('Add New Record', 'click')
                ->set(function($page)use($self) {
                    $form = $page->add('Form_Stacked');
                    $form->setModel($self->model);
                    $form->addSubmit('Add And Select');
                    if ($form->isSubmitted()) {
                        $form->update();
                        $js = array();
                        $js[] = $self->js()->val($form->model[$self->id_field]);
                        $js[] = $self->other_field->js()->val($form->model[$self->title_field]);
                        $form->js(null, $js)->univ()->closeDialog()->execute();
                    }
                    $form->add('Controller_FormBeautifier');
                });
    }
}
