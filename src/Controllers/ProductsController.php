<?php

namespace App\Controllers;

use App\Exceptions\EntityException;
use App\Exceptions\RequestException;
use App\Utils\Regexp;
use App\Utils\RegexpTypeValidator;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ProductsController extends ApplicationController
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
        $products = $this->productModel->findAll();

        return $this->twig->render("Products/index.html.twig", [
            "products" => $products,
            "errors"  => [],
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
        $product = $this->productModel->find($id);

        if (!$product) {
            throw new EntityException();
        }

        return $this->twig->render("Products/show.html.twig", [
            "product" => $product,
            "errors"  => [],
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
        return $this->twig->render("Products/new.html.twig", [
            "errors" => [],
        ]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * @throws RequestException
     *
     * @return string|void
     */
    public function create()
    {
        if (!array_key_exists('title', $_POST)) {
            throw new RequestException();
        }

        $title = (string) preg_replace(RegexpTypeValidator::STRING, '', $_POST['title']);

        $response = $this->productModel->create([
            ':title' => $title
        ]);

        if ($response === 0) {
            return $this->twig->render("Products/new.html.twig", [
                "errors" => [
                    "product cannot be created"
                ],
            ]);
        }

        $products = $this->productModel->findAll();

        header("Location: /products");
        die();
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
    public function edit(int $id): string
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            throw new EntityException();
        }

        return $this->twig->render("Products/edit.html.twig", [
            "product" => $product,
            "errors"  => [],
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
        if (!array_key_exists('title', $_POST)) {
            throw new RequestException();
        }

        $title = (string) preg_replace(RegexpTypeValidator::STRING, '', $_POST['title']);

        $product = $this->productModel->find($id);

        if (!$product) {
            throw new EntityException();
        }

        $response = $this->productModel->update([
            ':title' => $title,
            ':id'    => $id,
        ]);

        if ($response === 0) {
            return $this->twig->render("edit.html.twig", [
                "product" => $product,
                "errors"  => [
                    "product cannot be updated"
                ],
            ]);
        }

        header("Location: /products");
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
        $product = $this->productModel->find($id);

        if (!$product) {
            throw new EntityException();
        }

        $this->productModel->delete($id);

        header("Location: /products");
        die();
    }
}
