<?php

namespace Controller;
    
/**
 * Description of ControllerBase
 *
 * @author rmncst
 */
class ControllerBase 
{
    /**
     *
     * @var \Pimple\Container
     */
    protected $_app;
    
    /**
     *
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $_repo;
    
    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;


    public function __construct(\Pimple\Container $app) {
        $this->_app = $app;
        $this->_em = $app['em'];
    }
    
    public function setRepository(string $repo)
    {
        $this->_repo = $this->_em->getRepository($repo);
    }
}
