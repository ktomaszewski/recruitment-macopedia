<?php

declare(strict_types=1);

namespace Application\Service\Product;

use Application\Form\Product\Model\ProductImportModel;
use Application\Util\Storage;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class ProductImporter
{
    public function __construct(private Storage $storage)
    {
    }

    /** @throws FileException */
    public function importFile(ProductImportModel $productImportModel): File
    {
        return $this->moveFileToStorage($productImportModel->getFile());
    }

    /** @throws FileException */
    private function moveFileToStorage(UploadedFile $uploadedFile): File
    {
        return $uploadedFile->move($this->storage->getProductPath(), $uploadedFile->getClientOriginalName());
    }
}
