<?php

namespace App\Controllers;

use App\Models\Order;
use App\Models\Product;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

/**
 * Controller realize RESTful API for resources
 */
abstract class ApplicationController
{
    /**
     * @var Environment
     */
    protected $twig;

    /**
     * @var Order
     */
    protected $orderModel;

    /**
     * @var Product
     */
    protected $productModel;

    public function __construct()
    {
        $this->orderModel   = new Order();
        $this->productModel = new Product();
        $loader             = new FilesystemLoader("src/Views");
        $this->twig         = new Environment($loader);
    }
}
