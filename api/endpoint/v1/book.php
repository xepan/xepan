<?php
class endpoint_v1_book extends Endpoint_REST {
    public $model_class = 'xShop/Item';

    function get_abcd(){
    	return "OK";
    }

}