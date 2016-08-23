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


namespace TypetoKrish\Msg91Sms\Provider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use TypetoKrish\Msg91Sms\ApiCaller;
class Msg91SmsServiceProvider extends ServiceProvider
{
	
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
       
		//nothing to do here //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
	echo 'register';	
		$this->app->bind('typetokrish.msg91api',function($app){		
		echo 'return';	
			return new ApiCaller();
		});
        
    }
	
	
}
