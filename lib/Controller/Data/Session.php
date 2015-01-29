<?php // vim:ts=4:sw=4:et:fdm=marker
/*
 * Undocumented
 *
 * @link http://agiletoolkit.org/
*//*
==ATK4===================================================
   This file is part of Agile Toolkit 4
    http://agiletoolkit.org/

   (c) 2008-2013 Agile Toolkit Limited <info@agiletoolkit.org>
   Distributed under Affero General Public License v3 and
   commercial license.

   See LICENSE or LICENSE_COM for more information
 =====================================================ATK4=*/
/*
Implements connectivity between Model and Session
*/
class Controller_Data_Session extends Controller_Data_Array {

    function setSource($model, $data) {
        $this->api->initializeSession();
        if($data===undefined || $data === null) {
            $data='-';
        }

        if(!$_SESSION['ctl_data'][$data]) {
            $_SESSION['ctl_data'][$data]=array();
        }
        if(!$_SESSION['ctl_data'][$data][$model->table]) {
            $_SESSION['ctl_data'][$data][$model->table]=array();
        }

        $model->_table[$this->short_name] =& $_SESSION['ctl_data'][$data][$model->table];
    }

    function save($model, $id, $data) {
        $oldId = $id;
        if (is_null($id)) { // insert
            $newId = $data[$model->id_field] ? : $this->generateNewId($model);
            if (isset($model->_table[$this->short_name][$newId])) {
                throw $this->exception('This id is already used. Load the model before')
                    ->addMoreInfo('id', $data[$model->id_field]);
            }
        } else { // update
            $data = array_merge($model->_table[$this->short_name][$oldId], $data);
            // unset($model->_table[$this->short_name][$oldId]);
            $newId = $data[$model->id_field];
        }
        $data[$model->id_field] = $newId;
        $model->_table[$this->short_name][$newId] = $data;
        $model->data = $data;
        return $newId;
    }

}
