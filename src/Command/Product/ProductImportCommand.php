<?php

declare(strict_types=1);

namespace Application\Command\Product;

use Application\Service\Product\ProductImporter;
use League\Csv\InvalidArgument;
use SplFileInfo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function count;
use function sprintf;

final class ProductImportCommand extends Command
{
    public function __construct(private ProductImporter $productImporter)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:product:import')
            ->setDescription('Imports (saves to database) products from uploaded files');
    }

    /** @throws InvalidArgument */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filesToImport = $this->findFilesToImport($output);
        if (!$filesToImport) {
            $output->writeln('No files found!');
            return Command::SUCCESS;
        }

        $importedProductsCounter = 0;
        foreach ($filesToImport as $file) {
            $importedProductsCounter += $this->productImporter->importFromFile($file);
        }
        $output->writeln(sprintf('Done, %d products imported!', $importedProductsCounter));

        return Command::SUCCESS;
    }

    /** @return SplFileInfo[] */
    private function findFilesToImport(OutputInterface $output): array
    {
        $output->write('Searching for files ... ');
        $filesToImport = $this->productImporter->findFilesToImport();
        $output->writeln(count($filesToImport) . ' found!');

        return $filesToImport;
    }
}
