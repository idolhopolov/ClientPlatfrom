<?php

declare(strict_types=1);

namespace App\UserInterface\Film\CLI;

use App\Application\Common\Command\Bus\Impl\CommandBus;
use App\Application\Film\Command\CreateFilm\CreateFilmCommand;
use App\Application\Film\Command\Input\DTO\FilmPayload;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:film:import',
    description: 'import film list'
)]
class ImportFilmList extends Command
{
    private const CSV_HEADER_LIST = ['name'];

    public function __construct(private readonly CommandBus $bus)
    {
        parent::__construct();
    }

    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $reader = Reader::createFromPath($input->getArgument('path'));
        $reader->setHeaderOffset(0);
        $records = $reader->getRecords(self::CSV_HEADER_LIST);
        foreach ($records as $offset => $record) {
            try {
                $this->bus->handle(new CreateFilmCommand(new FilmPayload($record['name'])));
            } catch (\Throwable $exception) {
                $output->writeln("{$record['name']} can not be imported due to {$exception->getMessage()}");
            }
        }

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this->addArgument('path', InputArgument::REQUIRED);
    }
}