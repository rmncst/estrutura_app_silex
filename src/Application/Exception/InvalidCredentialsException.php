<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Exception;

/**
 * Description of InvalidCredentialsException
 *
 * @author rmncst
 */
class InvalidCredentialsException extends \Exception  {
    
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null) 
    {
        parent::__construct($message,$code, $previous);
    }
}
