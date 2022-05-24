<?php

namespace App\Config;

class API
{
    public $request = null;
    public $id = null;
    public $routes = array();
    public $request_route = null;

    public function startHeaderAndRouter()
    {
        $this->header();
        $this->routing();
    }

    public function header(): void
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
        header("Access-Control-Max-Age: 36000");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }

    public function routing(): void
    {
        $app_url = $_ENV['APP_URL'];
        $app_url = explode('/', $app_url);

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode('/', $uri);
        $uri = array_slice($uri, count($app_url), count($uri) - count($app_url));

        //Does it exists in array keys?
        if (!array_key_exists($uri[0], $this->routes)) {
            header("HTTP/1.1 404 Not Found");
            exit();
        }

        //ID after link 
        if (isset($uri[1])) {
            $this->id = (int) $uri[1];
        }

        $request = $_SERVER["REQUEST_METHOD"];
        $this->request = $request;
        $this->request_route = $uri[0];
    }

    //Response Header
    public function headerResponse(array $response): void
    {
        header($response['status_code_header']);
        if ($response['body']) {
            echo json_encode($response['body']);
        }
    }

    //Response OK
    public function responseOk($result): array
    {
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = $result;
        return $response;
    }

    //Response Created
    public function responseCreated($result): array
    {
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = $result;
        return $response;
    }

    public function notFound404(): array
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }

    public function badRequest400(): array
    {
        $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
        $response['body'] = null;
        return $response;
    }

    public function invalidInput($error_message)
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = ['error' => $error_message];
        return $response;
    }
}
