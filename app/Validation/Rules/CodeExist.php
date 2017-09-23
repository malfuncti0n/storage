<?php

namespace App\Validation\Rules;

use App\Models\User;
use Respect\Validation\Rules\AbstractRule;

class CodeExist extends AbstractRule
{
    public function validate($input)
    {
        return is_in > 0;
    }
}
