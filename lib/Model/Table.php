<?php

class Model_Table extends SQL_Model {

	function forceDelete($id=null){
		$this->delete($id);
	}
}
