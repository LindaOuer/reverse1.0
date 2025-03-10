<?php

namespace App\Command;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Table;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:drop-foreign-keys',
    description: 'Drops all foreign keys from the database.',
)]
class DropForeignKeysCommand extends Command
{
    private Connection $connection;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->connection = $entityManager->getConnection();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $schemaManager = $this->connection->createSchemaManager();
        $tables = $schemaManager->listTables();

        // Count relations for each table
        $tableRelationsCount = [];
        foreach ($tables as $table) {
            $foreignKeys = $this->getForeignKeys([$table->getName()]);
            $relationCount = count($foreignKeys);
            $tableRelationsCount[$table->getName()] = $relationCount;
        }

        // Sort tables by their relation count in ascending order
        usort($tables, function (Table $a, Table $b) use ($tableRelationsCount) {
            return $tableRelationsCount[$a->getName()] <=> $tableRelationsCount[$b->getName()];
        });

        // Generate entities in sorted order
        foreach ($tables as $table) {

            $tableName = $table->getName();
            var_dump($tableName);
            $foreignKeys = $schemaManager->listTableForeignKeys($tableName);

            if (empty($foreignKeys)) {
                $output->writeln("<comment>No foreign keys found in $tableName</comment>");
                continue;
            }

            foreach ($foreignKeys as $foreignKey) {
                $fkName = $foreignKey->getName();
                $sql = "ALTER TABLE `$tableName` DROP FOREIGN KEY `$fkName`";

                try {
                    $this->connection->executeQuery($sql);
                    $output->writeln("<info>Dropped foreign key $fkName from $tableName</info>");
                } catch (\Exception $e) {
                    $output->writeln("<error>Failed to drop $fkName from $tableName: " . $e->getMessage() . "</error>");
                }
            }
        }

        $output->writeln('<info>All foreign keys have been dropped successfully.</info>');
        return Command::SUCCESS;
    }

    /**
     * Retrieves foreign key constraints from the database.
     *
     * @param array $tables List of table names.
     * @return array Associative array of foreign keys.
     */
    public function getForeignKeys(array $tables): array
    {
        $foreignKeys = [];

        // Create the schema manager
        $schemaManager = $this->connection->createSchemaManager();

        // List all tables using the schema manager
        $dbTables = $schemaManager->listTables();

        foreach ($tables as $tableName) {
            // Check if the table exists in the list of tables
            if (in_array($tableName, array_map(fn($table) => $table->getName(), $dbTables))) {
                // Run a custom SQL query to retrieve foreign keys from the INFORMATION_SCHEMA (MySQL example)
                $sql = "
                SELECT 
                    COLUMN_NAME, 
                    REFERENCED_TABLE_NAME, 
                    REFERENCED_COLUMN_NAME
                FROM 
                    INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                WHERE 
                    TABLE_NAME = :tableName AND 
                    REFERENCED_TABLE_NAME IS NOT NULL
            ";

                // Prepare the query
                $stmt = $this->connection->prepare($sql);
                $stmt->bindValue(':tableName', $tableName);

                // Execute the query and fetch the results
                $fks = $stmt->executeQuery()->fetchAllAssociative();

                // Store foreign keys in the array
                foreach ($fks as $fk) {
                    $foreignKeys[$fk['COLUMN_NAME']] = [
                        'referencedTable' => $fk['REFERENCED_TABLE_NAME'],
                        'referencedColumn' => $fk['REFERENCED_COLUMN_NAME']
                    ];
                }
            }
        }

        return $foreignKeys;
    }
}
