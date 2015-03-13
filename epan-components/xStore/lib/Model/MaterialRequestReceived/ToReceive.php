<?php

namespace xStore;

class Model_MaterialRequestReceived_ToReceive extends Model_MaterialRequestReceived_Approved {
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard(approve) this post can see'),
			'can_receive'=>array('caption'=>'Can this post receive Jobcard(approve)'),

		);
}	