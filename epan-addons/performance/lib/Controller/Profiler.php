<?php


namespace performance;

class Controller_Profiler extends \AbstractController{
	public $profiler_Start=null;
	private $last_time=null;
	private $marks=array();

	public $mute=true;

	function init(){
		parent::init();
		$this->api->xpr = $this;
		$this->last_time = $this->profiler_Start = time()+microtime();
		$this->marks['Profiler Added'] = $GLOBALS['global_start'] - $this->profiler_Start;
		$this->markPoint('Start');
	}

	function markPoint($name){
		$this_time = ($name=='Start')?$this->profiler_Start:(time()+microtime());
		$this->marks[$name] = ($this_time - $this->last_time);
		$this->last_time = $this_time;
	}

	function dump(){
		if($this->mute) return;
		$this->markPoint('dump');
		$total_time = (time()+microtime()- $this->profiler_Start);

		foreach ($this->marks as $point => $time) {
			$this->marks[$point]= $time ." [".round($time/$total_time*100.0,2)."]";
		}
		echo "<pre>";
		var_dump($this->marks);
		echo "<b>Total </b>: ". $total_time;
		echo "</pre>";
	}
}