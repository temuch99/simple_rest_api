<?php

ini_set('display_errors', 1);

require('vendor/autoload.php');

use App\Exceptions\EntityException;
use App\Exceptions\NotFoundException;
use App\Exceptions\RequestException;
use App\Router\Router;

$method = $_SERVER['REQUEST_METHOD'];
$uri    = $_SERVER['REQUEST_URI'];


 try {
	echo Router::execAction($method, $uri);
 } catch (EntityException $e) {
 	echo "<h1>422 ERROR</h1>";
 } catch (NotFoundException $e) {
     echo "<h1>404 ERROR</h1>";
 } catch (RequestException $e) {
     echo "<h1>400 ERROR</h1>";
 } catch (\Exception $e) {
     echo "<h1>418 ERROR</h1>";
 }