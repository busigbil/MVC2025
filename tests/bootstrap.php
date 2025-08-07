<?php

use Symfony\Component\Dotenv\Dotenv;
use Doctrine\ORM\Tools\SchemaTool;

require dirname(__DIR__).'/vendor/autoload.php';

// Prepare for test-db
if (file_exists(dirname(__DIR__).'/.env.test')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env.test');
} else {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

$kernel = new \App\Kernel('test', true);
$kernel->boot();

$entityManager = $kernel->getContainer()->get('doctrine')->getManager();

$metadata = $entityManager->getMetadataFactory()->getAllMetadata();

if (!empty($metadata)) {
    $schemaTool = new SchemaTool($entityManager);
    $schemaTool->dropDatabase();
    $schemaTool->createSchema($metadata);
}
