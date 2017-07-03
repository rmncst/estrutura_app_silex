<?php

require __DIR__."/../vendor/autoload.php";

use Application\Exception\SecurityException;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
$app->register(new Application\Provider\DoctrineOrmProvider());
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Application\Provider\RoutingProvider());


$app->view(function(array $response) use ($app){
    return $app->json($response);
});

$app->error(function(\Exception $erro){
    return new Response('Oops, erro: '. $erro->getMessage(),500);
});

$app->error(function (SecurityException $erro){
    return new Response('Você é um intruso, '. $erro->getMessage(),404);
});

$app->post('/login', function(\Symfony\Component\HttpFoundation\Request $req)
{ 
    if($req->get('username') == 'root' && $req->get('password') == 'pass')
    {
        $jwt = Security\SecurityApp::EncodeJasonWebToken(['username' => $req->get('username')]);
        return $jwt;
    }
    else
    {
        throw new Application\Exception\SecurityException("Credenciais inválidas !");
    }
});

$app->get('/',function(){
    return 'Hellow Darkness My Old Friend !';
});

$app->run();