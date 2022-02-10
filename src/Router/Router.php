<?php

namespace App\Router;

use App\Exceptions\NotFoundException;
use App\Utils\RegexpPathValidator;

class Router
{
    /**
     * @var string $method
     * @var string $uri
     *
     * @throws NotFoundException
     *
     * @return string
     */
	public static function execAction(string $method, string $uri): string
    {
		$matches = [];
		if (preg_match(RegexpPathValidator::NEW_RESOURCE_PATH, $uri, $matches)) {
			if ($method === 'GET') {
				$action = "new";
			} else {
				throw new NotFoundException();
			}
		} elseif (preg_match(RegexpPathValidator::EDIT_RESOURCE_PATH, $uri, $matches)) {
			if ($method === 'GET') {
				$action = "edit";
			} else {
                throw new NotFoundException();
			}
		} elseif (preg_match(RegexpPathValidator::RESOURCE_PATH, $uri, $matches)) {
			if ($method === 'GET') {
				$action = "show";
			} elseif ($method === 'POST') {
				$action = 'update';
			} elseif ($method === 'DELETE') {
				$action = 'destroy';
			} else {
                throw new NotFoundException();
			}
		} elseif (preg_match(RegexpPathValidator::RESOURCES_PATH, $uri, $matches)) {
			if ($method === 'GET') {
				$action = "index";
			} elseif ($method === 'POST') {
				$action = "create";
			} else {
                throw new NotFoundException();
			}
		} elseif ($uri === "/") {
			$matches[1] = "statics";
			$action     = "index";
		} else {
            throw new NotFoundException();
		}

		$resource = $matches[1];
		$id       = $matches[2] ?? null;

		$controllerName = "App\\Controllers\\" . ucfirst($resource) . "Controller";

		if (!class_exists($controllerName)) {
            throw new NotFoundException();
		}

		$controller = new $controllerName();

		return call_user_func_array([$controller, $action], ($id === null ? [] : [$id]));
	}
}