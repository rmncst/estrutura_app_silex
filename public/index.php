<?php

require __DIR__."/../vendor/autoload.php";

use Symfony\Component\HttpFoundation\Request;
use Application\Exception\SecurityException;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
$app->register(new Application\Provider\DoctrineOrmProvider());

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

$app->get('/path/to/action',function(Symfony\Component\HttpFoundation\Request $req){
    return ['uri' => $req->getPathInfo()];
});

$app->post('/decode',function (\Symfony\Component\HttpFoundation\Request $req){
   return ['decoded' => Firebase\JWT\JWT::decode($req->headers->get('Autorization'), 'example_key', array('HS256'))] ;
});

$app->get('/',function(){
    return 'Hellow Darkness My Old Friend !';
});

$app->get('/post', function() use ($app){
    $posts = $app['em']->getRepository('Data\Entity\Post')->findAll();
    $return = [];
    foreach ($posts as $post) 
    {
        $return[] = [
            'id' => $post->getId(),
            'titulo' => $post->getTitulo(),
            'texto' => $post->getTexto(),
            'autor' => $post->getAutor(),
        ];
    }
    
    return $return;
});

$app->post('/post' , function(Request $request, Silex\Application $app){
    $novoPost = new Data\Entity\Post();
    $novoPost->setAutor($request->get('autor'));
    $novoPost->setTexto($request->get('texto'));
    $novoPost->setTitulo($request->get('titulo'));
    
    $app['em']->persist($novoPost);
    $app['em']->flush();
    
    return 'Cadastro realizado com sucesso !';
})->before(function(Request $req){
    $var = $req->headers->get('Authorization');
    if($var == null)
    {
        throw new SecurityException();
    }
    
    Security\SecurityApp::VerifyJasonWebToken($var);
});

$app->get('/comentario/{postId}', function($postId , Silex\Application $app){
    $comenatarios = $app['em']->getRepository('Data\\Entity\\Comentario')->getComentariosPorPost($postId);
    $returns = [];
    
    foreach ($comenatarios as $value) {
        $returns[] = [
            'id' => $value->getId(),
            'autor' => $value->getAutor(),
            'texto' => $value->getTexto(),
            'datacomentario' => $value->getDataComentario()
        ];
    }
    
    return $returns;
});

$app->post('/comentario', function(Symfony\Component\HttpFoundation\Request $request, Silex\Application $app){
    $novoComentario = new Data\Entity\Comentario();
    $novoComentario->setAutor($request->get('autor'));
    $novoComentario->setDataComentario( new DateTime('NOW'));
    $post = $app['em']->getRepository('Data\\Entity\\Post')->find(['id' => $request->get('postid')]);
    $novoComentario->setIdPost($post);
    $novoComentario->setTexto($request->get('texto'));
    
    $app['em']->persist($novoComentario);
    $app['em']->flush();
    
    return 'Novo comentario inserido com sucesso, id: '. $novoComentario->getId();
});

$app->run();