<?php

namespace App\Controllers;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class StaticsController extends ApplicationController
{
    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     *
     * @return string
     */
	public function index(): string
	{
		return $this->twig->render("Statics/index.html.twig");
	}
}