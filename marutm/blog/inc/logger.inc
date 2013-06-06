<?php
	class logger {
	protected $userid;
	protected $func;
	protected $log_file;
	protected $debug_mode;
	
	public function __construct($log_file = _LOG_FILE) {
		// $this->func = common::getParam("func");
		$this->log_file = $log_file;
		//$this->client_info = $_SERVER['REMOTE_ADDR'].' '.@$_COOKIE['userid'];
		
		if(_DEBUG_MODE == "debug")			$this->debug_mode = E_USER_DEBUG; 	
		else if(_DEBUG_MODE == "notice")	$this->debug_mode = E_USER_NOTICE;
		else if(_DEBUG_MODE == "warning")	$this->debug_mode = E_USER_WARNING;
		else if(_DEBUG_MODE == "error")		$this->debug_mode = E_USER_ERROR;
	}

	public function getMessage($error_msg,$backtrace,$type,$userid) {
		return date('Y-m-d H:i:s')." [".@$_SERVER['REMOTE_ADDR'].($userid ? $userid." " : "")."] ".$type." : ".($this->func ? $this->func." " : "" ).$backtrace[0]['file']." on line ".$backtrace[0]['line']." : ".$error_msg."\n";
	}

	public function warning($error_msg,$userid = '') {
		// if($this->debug_mode >= E_USER_WARNING) error_log($this->getMessage($error_msg,debug_backtrace(),"WARNING",$userid),3,$this->log_file);		
	}

	public function notice($error_msg,$userid = '') {
		// if($this->debug_mode >= E_USER_NOTICE) error_log($this->getMessage($error_msg,debug_backtrace(),"NOTICE",$userid),3,$this->log_file);		
	}

	public function error($error_msg,$userid = '') {
		// if($this->debug_mode >= E_USER_ERROR) error_log($this->getMessage($error_msg,debug_backtrace(),"ERROR",$userid),3,$this->log_file);
	}
	
	public function debug($error_msg,$userid = '') {
		// if($this->debug_mode >= E_USER_DEBUG) error_log($this->getMessage($error_msg,debug_backtrace(),"DEBUG",$userid),3,$this->log_file);	
	}
}
?>