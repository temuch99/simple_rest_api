<?php

namespace App\Utils;

class RegexpPathValidator
{
    public const RESOURCES_PATH = "/([a-z]+)/";
    public const RESOURCE_PATH = "/([a-z]+)\/([0-9]+)/";
    public const NEW_RESOURCE_PATH = "/([a-z]+)\/new/";
    public const EDIT_RESOURCE_PATH = "/([a-z]+)\/([0-9]+)\/edit/";
}