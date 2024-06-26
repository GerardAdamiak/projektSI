<?php

// src/Command/ListTablesContentsCommand.php

namespace App\Command;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ListTablesContentsCommand extends Command
{
    protected static $defaultName = 'app:list-tables-contents';

    public function __construct(private readonly Connection $connection)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Lists all tables in the database and their contents.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $schemaManager = $this->connection->createSchemaManager();
        $tables = $schemaManager->listTableNames();

        if (empty($tables)) {
            $io->warning('No tables found in the database.');

            return Command::SUCCESS;
        }

        foreach ($tables as $table) {
            $io->title("Table: $table");
            $rows = $this->connection->fetchAllAssociative("SELECT * FROM $table");

            if (empty($rows)) {
                $io->warning("No data found in table $table.");
            } else {
                $headers = array_keys($rows[0]);
                $io->table($headers, $rows);
            }
        }

        return Command::SUCCESS;
    }
}
