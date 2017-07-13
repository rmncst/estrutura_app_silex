<?php

namespace Controller;


use Application\Exception\InvalidCredentialsException;
use Doctrine\DBAL\Schema\SchemaException;
use Security\SecurityApp;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of AutenticacaoController
 *
 * @author rmncst
 */
class AutenticateController extends ControllerBase {
    
    public function __construct(\Pimple\Container $app)
    {
        parent::__construct($app);
    }
    
    public function login()
    {
        return $this->render('autenticate/login.twig', ['name' => 'Darkness', 'var' ]);
    }

    public function loginAutenticate(Request $req)
    {
        $username = $req->get('username');
        $password = $req->get('password');

        if($username !== null && $password !== null)
        {
            if($username == "root" && $password == "pass")
            {
                return $this->render('master.twig', ['message' => 'You win !']);
            }
            else
            {
                throw new InvalidCredentialsException("Credenciais inválidas");
            }
        }
        else
        {
            throw new SchemaException("Campo 'username' e 'password' são obrigatórios!");
        }
    }
}
