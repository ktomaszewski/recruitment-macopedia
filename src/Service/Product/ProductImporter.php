<?php

declare(strict_types=1);

namespace Application\Service\Product;

use Application\Entity\Product;
use Application\Form\Product\Model\ProductImportModel;
use Application\Repository\ProductRepository;
use Application\Util\Storage;
use League\Csv\Reader;
use Psr\Log\LoggerInterface;
use SplFileInfo;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use function is_numeric;
use function iterator_to_array;

final class ProductImporter
{
    public function __construct(private Storage $storage, private ProductRepository $productRepository, private LoggerInterface $productImportLogger)
    {
    }

    /** @throws FileException */
    public function handleUploadedFile(ProductImportModel $productImportModel): File
    {
        return $this->moveUploadedFileToStorage($productImportModel->getFile());
    }

    /** @throws FileException */
    private function moveUploadedFileToStorage(UploadedFile $uploadedFile): File
    {
        return $uploadedFile->move($this->storage->getProductPath(), $uploadedFile->getClientOriginalName());
    }

    /** @return SplFileInfo[] */
    public function findFilesToImport(): array
    {
        return iterator_to_array((new Finder())
            ->files()
            ->name('*.csv')
            ->in($this->storage->getProductPath())
        );
    }

    public function importFromFile(SplFileInfo $splFileInfo): int
    {
        $importCounter = 0;
        foreach ($this->createReader($splFileInfo)->getRecords() as $record) {
            if ($this->importRecord($record)) {
                ++$importCounter;
            }
        }
        $this->removeImportedFile($splFileInfo);

        return $importCounter;
    }

    private function createReader(SplFileInfo $splFileInfo): Reader
    {
        return Reader::createFromPath($splFileInfo->getRealPath())->setDelimiter(';');
    }

    private function removeImportedFile(SplFileInfo $splFileInfo): void
    {
        (new Filesystem())->remove($splFileInfo->getRealPath());
    }

    /** @param mixed[] $record */
    private function importRecord(array $record): bool
    {
        $name = (string) ($record[0] ?? '');
        $id = (string) ($record[1] ?? '');
        if (!is_numeric($id)) {
            $this->productImportLogger->info('Found invalid id, skipping...', ['id' => $id]);
            return false;
        }

        $product = $this->productRepository->findOneById($id);
        if ($product) {
            $this->productImportLogger->info('Product already saved, skipping...', ['id' => $id]);
            return false;
        }

        $product = new Product($id, $name);
        $this->productRepository->save($product);

        return true;
    }
}
