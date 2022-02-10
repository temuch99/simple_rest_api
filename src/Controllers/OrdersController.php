<?php

namespace App\Controllers;

use App\Exceptions\EntityException;
use App\Exceptions\RequestException;
use App\Utils\RegexpTypeValidator;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class OrdersController extends ApplicationController
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
        $orders = $this->orderModel->findAll();

        return $this->twig->render("Orders/index.html.twig", [
            "orders" => $orders,
        ]);
    }

    /**
     * @param int $id
     *
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws EntityException
     * @throws LoaderError
     *
     * @return string
     */
    public function show(int $id): string
    {
        $order = $this->orderModel->find($id);

        if (!$order) {
            throw new EntityException();
        }

        return $this->twig->render("Orders/show.html.twig", [
            "order" => $order,
        ]);
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     *
     * @return string
     */
    public function new(): string
    {
        $products = $this->productModel->findAll();

        return $this->twig->render("Orders/new.html.twig", [
            "products" => $products,
        ]);
    }

    /**
     * @throws RuntimeError
     * @throws LoaderError
     * @throws EntityException
     * @throws RequestException
     * @throws SyntaxError
     *
     * @return string|void
     */
    public function create()
    {
        foreach (["product", "name", "phone"] as $var) {
            if (!array_key_exists($var, $_POST)) {
                throw new RequestException();
            }
        }

        $name       = (string) preg_replace(RegexpTypeValidator::STRING, '', $_POST['name']);
        $phone      = (string) preg_replace(RegexpTypeValidator::PHONE, '', $_POST['phone']);
        $product_id = preg_replace(RegexpTypeValidator::INT, '', $_POST['product']);

        $product = $this->productModel->find($product_id);

        if (!$product) {
            throw new EntityException();
        }

        $response = $this->orderModel->create([
            ':name'       => $name,
            ':phone'      => $phone,
            ':product_id' => $product_id,
        ]);

        if ($response === 0) {
            $products = $this->productModel->findAll();

            return $this->twig->render("Orders/new.html.twig", [
                "products" => $products,
                "errors"   => [
                    "order cannot be created"
                ],
            ]);
        }

        header("Location: /orders");
        die();
    }

    /**
     * @param int $id
     *
     * @return string
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws EntityException
     *
     * @throws LoaderError
     */
    public function edit(int $id): string
    {
        $order    = $this->orderModel->find($id);
        $products = $this->productModel->findAll();

        if (!$order) {
            throw new EntityException();
        }

        return $this->twig->render("Orders/edit.html.twig", [
            "order"    => $order,
            "products" => $products,
        ]);
    }

    /**
     * @param int $id
     *
     * @throws SyntaxError
     * @throws RequestException
     * @throws LoaderError
     * @throws EntityException
     * @throws RuntimeError
     *
     * @return string|void
     */
    public function update(int $id)
    {
        foreach (["product", "name", "phone"] as $var) {
            if (!array_key_exists($var, $_POST)) {
                throw new RequestException();
            }
        }

        $name       = (string) preg_replace(RegexpTypeValidator::STRING, '', $_POST['name']);
        $phone      = (string) preg_replace(RegexpTypeValidator::PHONE, '', $_POST['phone']);
        $product_id = (int) preg_replace(RegexpTypeValidator::INT, '', $_POST['product']);

        $product = $this->productModel->find($product_id);

        if (!$product) {
            throw new EntityException();
        }

        $response = $this->orderModel->update([
            ':name'       => $name,
            ':phone'      => $phone,
            ':product_id' => $product_id,
            ':id'         => $id,
        ]);

        if ($response === 0) {
            $order    = $this->orderModel->find($id);
            $products = $this->productModel->findAll();

            return $this->twig->render("Orders/edit.html.twig", [
                "order"    => $order,
                "products" => $products,
                "errors"   => [
                    "order cannot be updated"
                ],
            ]);
        }

        header("Location: /orders");
        die();
    }

    /**
     * @param int $id
     *
     * @throws EntityException
     *
     * @return void
     */
    public function destroy(int $id)
    {
        $order = $this->orderModel->find($id);

        if (!$order) {
            throw new EntityException();
        }

        $this->orderModel->delete($id);

        header("Location: /orders");
        die();
    }
}
