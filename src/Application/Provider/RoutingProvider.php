<?php

namespace Application\Provider;

/**
 * Description of RoutingProvider
 *
 * @author rmncst
 */
class RoutingProvider implements \Pimple\ServiceProviderInterface 
{    
    
    public function register(\Pimple\Container $app) 
    {
        $this->registerServices($app);
        
        $this->CrudRoutes($app, 'controller.post', "/post");
        $this->CrudRoutes($app, 'controller.comentario', "/comentario");
        
        $app->get('/comentario/post/{postId}','controller.comentario:getAllByPost');
    }
    
    public function CrudRoutes(\Pimple\Container $app , string $controller, string $prefix)
    {
        $app->get($prefix.'/{id}',$controller.':get');
        $app->get($prefix , $controller.':getAll');
        $app->post($prefix ,$controller.':add');
        $app->put($prefix, $controller.':update');
        $app->delete($prefix, $controller.':delete');
    }
    
    public function registerServices(\Pimple\Container $app)
    {
        
        $app['controller.post'] = function () use($app)
        {
            return new \Controller\PostController($app);
        };
        
        $app['controller.comentario'] = function() use($app)
        {
            return new \Controller\ComentarioController($app);
        };
        
    }
    
    

}
