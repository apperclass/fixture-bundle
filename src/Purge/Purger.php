<?php

namespace Apperclass\Bundle\FixtureBundle\Purge;

use Apperclass\Bundle\FixtureBundle\Exception\PurgeException;
use Doctrine\ORM\EntityManager;

class Purger
{
    protected $entityManager;


    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * purge
     */
    public function purge()
    {
        $connection = $this->entityManager->getConnection();
        $schemaManager = $connection->getSchemaManager();
        $tables = $schemaManager->listTables();
        $dbPlatform = $connection->getDatabasePlatform();

        $connection->beginTransaction();

        try{

            foreach($tables as $table) {

                if($dbPlatform->getName() !== 'sqlite') {
                    $connection->query('SET FOREIGN_KEY_CHECKS=0');
                }

                $q = $dbPlatform->getTruncateTableSql($table->getName());
                $connection->executeUpdate($q);

                if($dbPlatform->getName() !== 'sqlite') {
                    $connection->query('SET FOREIGN_KEY_CHECKS=1');
                }
            }

            $connection->commit();

        }catch (\Exception $e) {

            $connection->rollback();
            throw new PurgeException('Something went wrong while purge. Rollback.', 0 , $e);
        }
    }
}
