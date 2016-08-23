### Simple TextMessage wrapper for MSG91 API (Laravel 5)
Send text message through msg91.com api service from your laravel application .

http://msg91.com/



## Installation

1. Download the package
2. Configure your composer.json and add this package 
3. Add an entry in composer.json , autoload the package.


"autoload": {

        "classmap": [
            "database"
        ],
        "psr-4": {
            "App\\": "app/",
			"TypetoKrish\\Msg91Sms\\": "vendor/typetokrish/msg91sms/src"
        }
    },
	
	
	
4. Do composer dump-autoload
5. In you Config/app.php, add the following service and facade 
in Provider array : 

TypetoKrish\Msg91Sms\Provider\Msg91SmsServiceProvider::class,

in Alias array : 

'TextMessage'=>TypetoKrish\Msg91Sms\Facade\Msg91Sms::class,

### usage

To send SMS from controller , load the TextMessage facade using :
use TextMessage;

Now inside a function , use the send() function on TextMessage instance .



public function index()

{
		$api	=	TextMessage::instance();
		
		$api->authKey('your_auth_key');  // get one key from Msg91
		
		$api->route(1);		// 1 for promo, 4 for transactional//
		
		$api->sender('TYPETK');
		
		$api->country(91);	//Set country code, 0: for international, 1 for US
		  
		$numbers=array('919999999999','919999999999'); //array of receiver number with country code//		
		$message	=	'Hello Test message send';
		
		if($api->send($message,$numbers)){
			echo 'Message ID :'.$api->getMessageId();   //get message id on success//
			$api->trace();
		}else{
			$api->getError();    // get error message//
			$api->trace();      //print communication trace//
		}
		
		
        return null;
}




#### Supported functions

schedule($date);  // Schedule message for future : $date in Y-m-d H:i:s format

flash(); // set message as flash

noFlash();  // no flash message

unicode(); // send message as unicode

nounicode(); // default : no unicod text

authKey($key) ; // set auth key : $key - string

route($rt);  // set message route, $rt- 1:promo, 2 transactional

sender($str); //set sender Id , $str- string

country($code); // set country code, 0 for internaitonal

Refer : http://help.msg91.com/article/76-how-to-send-sms-worldwide

getMessageId();  //get message id after successful submission

getError(); //last error occured

trace(); //print the details of api calling and response


  
