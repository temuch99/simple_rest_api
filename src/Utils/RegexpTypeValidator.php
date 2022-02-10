<?php

namespace App\Utils;

class RegexpTypeValidator
{
    public const STRING = "/[^a-zA-Z0-9]/";
    public const PHONE = "/[^0-9-+]/";
    public const INT = "/[^0-9]/";
}