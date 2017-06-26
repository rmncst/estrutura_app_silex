<?php

use Application\Provider\DoctrineOrmProvider;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once __DIR__."/../vendor/autoload.php";


$paths = array( realpath(__DIR__."/../src/Data/Entity") );
$reader = new AnnotationReader();
$driver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver($reader, $paths);

$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../src/Data/Entity"), true);
$config->setMetadataDriverImpl( $driver );

$entityManager= EntityManager::create(array('dbname' => 'webapidb',
                                            'user' => 'webapiuser',
                                            'password' => 'webapipass',
                                            'host' => '127.0.0.1',
                                            'driver' => 'pdo_mysql'), $config);

return ConsoleRunner::createHelperSet(DoctrineOrmProvider::bootstrapCliConnetion());


