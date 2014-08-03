<?php

require_once(__DIR__ . '/../config/init.php');
require_once(__DIR__ . '/data.php');
require_once(__DIR__ . '/output.php');

$request = new HttpRequest();
$response = new HttpResponse();

try {
  $path = $request->get('p');
  $controller_name = @$APP->paths[$path];
  if (!$controller_name) {
    throw new Exception("Not found");
  }
  $controller = new $controller_name();

  //
  // Call the controller
  //
  switch($request->method()) {
  case 'GET':
    $controller->doGET($request, $response);
    break;
  case 'POST':
    $controller->doGET($request, $response);
    break;
  case 'DELETE':
    $controller->doGET($request, $response);
    break;
  default:
    throw new Exception("Unsupported method: " . $request->method);
  }

  //
  // Check for a redirect
  //
  if ($response->redirect) {
    http_redirect($response->redirect, $response->redirect_code);
    exit;
  }

  // set HTTP headers
  header('Content-type: text/html; charset=utf8'); // force UTF-8 encoding
  if ($response->headers) {
    foreach ($response->headers as $name => $value) {
      header("$name: $value");
    }
  }

  // set HTTP status
  if ($response->status) {
    header("HTTP/1.1 $status");
  }

  // is the content already generated?
  if ($response->content) {
    print($response->content);
    exit;
  }

  // assign template parameters
  if ($response->parameters) {
    foreach ($response->parameters as $name => $value) {
      $APP->smarty->assign($name, $value);
    }
  }

  // render the response
  if ($response->template) {
    $APP->smarty->display($response->template . '.tpl');
  }

} catch (Exception $e) {
  print($e->getMessage());
}

exit;
