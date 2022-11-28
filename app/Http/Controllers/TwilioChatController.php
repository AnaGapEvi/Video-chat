<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Rest\Client;

class TwilioChatController extends Controller
{
    private $twilio_account_sid;
    private $twilio_api_key;
    private $twilio_api_secret;
    private $service_sid;
    private $identity;

    public function __construct()
    {
        $this->twilio_account_sid = config('services.twilio')['sid'];
        $this->twilio_api_key = config('services.twilio')['key'];
        $this->twilio_api_secret = config('services.twilio')['secret'];
        $this->service_sid = config('services.twilio')['grant'];
        $this->identity = '';
    }

    public function getToken(Request $request)
    {
        $this->identity = $request->identity;
        $token = new AccessToken(
            $this->twilio_account_sid,
            $this->twilio_api_key,
            $this->twilio_api_secret,
            3600,
            $this->identity
        );

        $chat_grant = new ChatGrant();
        $chat_grant->setServiceSid($this->service_sid);

        $token->addGrant($chat_grant);

        echo $token->toJWT();
    }
}
