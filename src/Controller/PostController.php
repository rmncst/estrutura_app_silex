<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * Description of PostController
 *
 * @author rmncst
 */
class PostController extends ControllerBase
{   
    public function __construct(\Pimple\Container $app) 
    {
        parent::__construct($app);
        parent::setRepository('Data\Entity\Post');
    }

    public function getAll()
    {
        $posts =  $this->_repo->findAll();
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
    }
        
    public function get($id)
    {
        $post =  $this->_repo->find($id);
        $return = [];
        $return[] = [
            'id' => $post->getId(),
            'titulo' => $post->getTitulo(),
            'texto' => $post->getTexto(),
            'autor' => $post->getAutor(),
        ];
        

        return $return;        
    }
    
    public function add(Request $request)
    {
        $novoPost = new \Data\Entity\Post();
        $novoPost->setAutor($request->get('autor'));
        $novoPost->setTexto($request->get('texto'));
        $novoPost->setTitulo($request->get('titulo'));

        $this->_em->persist($novoPost);
        $this->_em->flush();

        return [ msg => 'Cadastro realizado com sucesso !' , data => $novoPost];
    }
}
