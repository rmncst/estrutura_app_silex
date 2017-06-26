<?php

require __DIR__."/../vendor/autoload.php";

$app = new Silex\Application();
$app->register(new Application\Provider\DoctrineOrmProvider());
$app->view(function(array $response) use ($app){
    return $app->json($response);
});
$app->error(function(\Exception $erro){
    return new \Symfony\Component\HttpFoundation\Response('Oops, erro: '. $erro->getMessage(),500);
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

$app->post('/post' , function(Symfony\Component\HttpFoundation\Request $request, Silex\Application $app){
    $novoPost = new Data\Entity\Post();
    $novoPost->setAutor($request->get('autor'));
    $novoPost->setTexto($request->get('texto'));
    $novoPost->setTitulo($request->get('titulo'));
    
    $app['em']->persist($novoPost);
    $app['em']->flush();
    
    return 'Cadastro realizado com sucesso !';
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