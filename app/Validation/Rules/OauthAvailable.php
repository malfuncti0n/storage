<?php

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class OauthAvailable extends AbstractRule
{

    private $_oauthMethods=[
        'api',
        'facebook',
        'twitter',
        'google'
    ];

    public function validate($input)
    {
        return in_array($input,$this->_oauthMethods) > 0;
    }
}
