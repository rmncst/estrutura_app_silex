<?php
namespace Security;

use Firebase\JWT\JWT;
use Application;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SecurityApp
 *
 * @author rmncst
 */
class SecurityApp 
{    
    const KEY = 'example_key';    
    const ALGO = 'HS256';
    
    public static function EncodeJasonWebToken(array $token)
    {
        $jwt = JWT::encode($token, self::KEY , self::ALGO);
        
        return $jwt;       
    }
    
    
    public static function DecodeJasonWebToken(array $token)
    {
        $jwt = JWT::decode($token, self::KEY);
        
        return $jwt;       
    }
    
    public static function VerifyJasonWebToken($token)
    {
        try
        {
            JWT::decode($token, self::KEY , array(self::ALGO));
            return true;
        } 
        catch (\Exception $ex) 
        {
            throw new Application\Exception\SecurityException($ex->getMessage());            
        }         
    }
    
    public static function EncodePassword(string $password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
    
    public static function VerifyPassword(string $passord)
    {
        return password_verify($passord, PASSWORD_BCRYPT, [self::ALGO]);
    }
}
