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
namespace TypetoKrish\Msg91Sms\Facade;

use Illuminate\Support\Facades\Facade;



class Msg91Sms extends Facade
{
    protected static function getFacadeAccessor() { 	
        return 'typetokrish.msg91api';
    }
}