<?php

/*
	Package Name : typetoKrish/MSG91TextMessageApi
	Plugin URI: https://github.com/typetokrish
	Description: Laravel 5 Service Provider for Sending TextMessage through MSG91 API
	Version: 1.0
	Author: Kiran Krishnan
	Author URI: https://github.com/typetokrish
	License: GPL2
  
*/

namespace TypetoKrish\Msg91Sms;


class ApiCaller 
{
   
	
	public static $instance;
	
	private $authKey;
	
	private $mobiles;
	
	private $sender; 
	
	private $message;
	
	private $route;
	
	private $country;
	
	private $flash;
	
	private $unicode;
	
	private $ignoreNdnc;
	
	private $schtime;
	
	
	private $response;
	
	private $trace;
	
	private $error;
	
	
	public function __construct(){
		$this->authKey	='';
		$this->mobiles	=	array();
		$this->sender	= 'MSGIND';
		$this->route	=	4;
		$this->country	=	0;
		$this->flash	=	0;
		$this->unicode	=	0;
		$this->schtime	=	'';
		$this->response	=	'json';	
		$this->trace=array();
		$this->error='';
	}
	/*
	 * Set flash SMS
	 args : nil
	 return true;
	*/
	function flash(){
		$this->flash=1;
		return true;
	}
	/*
	 * Set no flash SMS
	 args : nil
	 return true;
	*/
	function noFlash(){
		$this->flash=0;
		return true;
	}
	/*
	 * Set Unicode SMS
	 args : nil
	 return true;
	*/
	function unicode(){
		$this->unicode=1;
		return true;
	}
	/*
	 * Set no unicode for SMS
	 args : nil
	 return true;
	*/
	function noUnicode(){
		$this->unicode=0;
		return true;
	}
	/*
	 * Set Scheduled SmS
	 args : Date time : Y-m-d h:i:s
	 return true;
	*/
	function schedule($time){
		$this->schtime=$time;
		return true;
	}
	/*
	 * Set Route
	 args : mode (1:promotional, 4:transactional)
	 return true;
	*/
	function route($route=4){
		$this->route=$route;
		return true;
	}
	/*
	 * Set Sender Id
	 args : String
	 return true;
	*/
	function sender($sender){
		$this->sender=$sender;
		return true;
	}
	/*
	 * Set Country
	 args : int (0 international, 1 Usa, 91 India)
	 return true;
	*/
	function country($country){
		$this->country=$country;
		return true;
	}
	/*
	 * Set Auth Key
	 args : String
	 return true;
	*/
	function authKey($authKey){
		$this->authKey=$authKey;
		return true;
	}
	/*
	 * Get Singleton Instance 
	 args : nil
	 return true;
	*/
	
	public static function instance(){
		if(self::$instance===null){
			self::$instance= new ApiCaller();
		}
		return self::$instance;
	}
	/*
	 * Send SMS
	 args : string,array( Message , list of number)
	 return true on success, false on failure;
	*/
	function send($message,$mobiles){
		
		//Process SMS sending //
		try{	
			$this->messageId='';
			$this->trace[]='preparing send parameters';
			$this->mobiles=$mobiles;
			$this->message =$message;		
			/*
			 * Prepare SMS sending Params to URL
			*/
			$params	=	'authkey='.$this->authKey.'&mobiles='.implode(',',$this->mobiles).'&message='.urlencode($this->message).'&sender='.$this->sender.'&route='.$this->route.'&country='.$this->country.'&flash='.$this->flash.'&unicode='.$this->unicode.'&response='.$this->response;
			//Schedule if time given//
			if(trim($this->schtime)!=''){
				$params.='&schtime='.$this->schtime;
			}
			$this->trace[]='Paramters : '.$params;
			$this->trace[]='Sending..';
			
			/*
			 * Execute a GET through CURL
			*/
			$curl	=	curl_init();
			curl_setopt_array($curl, [
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'https://control.msg91.com/api/sendhttp.php?'.$params,
				CURLOPT_SSL_VERIFYHOST=>false,
				CURLOPT_SSL_VERIFYPEER=> false			
				]);
			$result	=	curl_exec($curl);
			$response=json_decode($result);
			
			$this->trace[]='Response from Api : '.$result;
			if($response->type=='success'){  //On success//
				$this->trace[]='Successful posting ';
				$this->error='';
				$this->messageId= $response->message;
				return true;
			}else{			//error	
				$this->trace[]='Error in sending : '.$response->message;
				$this->error=$response->message;
				return false;
			}
		}catch(Exception $c){
			//SOm error occured//
			$this->trace[]= $c->getMessage();
			$this->error=$c->getMessage();
			return false;
		}
		return false;
		
	}
	/*
	 * Get error from api
	 args : nil
	 return : string
	*/
	function getError(){
		return $this->error;
	}
	/*
	 * print the process 
	 args nil
	 return nil
	*/
	function trace(){
		foreach($this->trace as $mesg){
			echo '<br><em>'.$mesg."</em>";
		}
	}
	/*
	 Get message id on success
	 Args nil
	 return string
	*/
	function getMessageId(){
		return $this->messageId;
	}
	
	
}
