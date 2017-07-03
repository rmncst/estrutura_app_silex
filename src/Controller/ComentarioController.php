<?php

namespace Controller;

/**
 * Description of ComentarioController
 *
 * @author rmncst
 */
class ComentarioController extends ControllerBase
{   
    public function __construct(\Pimple\Container $app) 
    {
        parent::__construct($app);
        parent::setRepository('Data\Entity\Comentario');
    }
    
    public function getAll()
    {
        $coments = $this->_repo->findAll();
        $results = [];
        
        foreach ($coments as $value) {
            $results[] = [
                'id' => $value->getId(),
                'id_post' => $value->getIdPost(),
                'autor' => $value->getAutor(),
                'data_comentario' => $value->getDataComentario(),
                'texto' => $value->getTexto()
            ];
        }
        
        return $results;
    }


    public function getAllByPost($postId)
    {
        $comenatarios = $this->_repo->getComentariosPorPost($postId);
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
    }
    
    public function add(\Symfony\Component\HttpFoundation\Request $request)
    {
        $novoComentario = new \Data\Entity\Comentario();
        $novoComentario->setAutor($request->get('autor'));
        $novoComentario->setDataComentario(new \DateTime('NOW'));
        $post = $this->_em->getRepository('Data\\Entity\\Post')->find(['id' => $request->get('postid')]);
        $novoComentario->setIdPost($post);
        $novoComentario->setTexto($request->get('texto'));

        $this->_em->persist($novoComentario);
        $this->_em->flush();

        return [ 'msg' => 'Novo comentario inserido com sucesso' , 'data' => $novoComentario ];
    }
}
