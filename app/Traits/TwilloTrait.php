<?php

namespace App\Traits;

use Twilio\Rest\Client;

trait TwilloTrait
{

    public function sendSms($receiver_number, $message)
    {
        $sid = config('services.twillo.account_sid');
        $token = config('services.twillo.token');
        $my_phone = config('services.twillo.my_phone');
        $client = new Client($sid, $token);

        $client->messages->create(
        // The number you'd like to send the message to
            "+".$receiver_number,
            [
                // A Twilio phone number you purchased at https://console.twilio.com
                'from' => $my_phone,
                // The body of the text message you'd like to send
                'body' => $message
            ]
        );

    }
}
