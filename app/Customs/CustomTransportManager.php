<?php
namespace App\Customs;

use Illuminate\Mail\TransportManager;
use DB; //my models are located in app\models

class CustomTransportManager extends TransportManager {

    /**
     * Create a new manager instance.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
        $mail = DB::table('mail_system')->first();
        if( $mail ){

            $this->app['config']['mail'] = [
                'driver'        => 'smtp',
                'host'          => 'smtp.gmail.com',
                'port'          => 587,
                'from'          => [
	                'address'   => $mail->email,
	                'name'      => $mail->email
                ],
                'encryption'    => 'tls',
                'username'      => $mail->email,
                'password'      => $mail->password,
                'sendmail'      => '/usr/sbin/sendmail -bs',
                'markdown'       => [
								        'theme' => 'default',

								        'paths' => [
								            resource_path('views/vendor/mail'),
								        ],
							        ],
           ];
       }

    }
}