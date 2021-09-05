<?php

declare(strict_types=1);

namespace Application\Form\Product\Model;

use Application\Util\MimeType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

final class ProductImportModel
{
    #[Assert\File(mimeTypes: MimeType::ALL_CSV, mimeTypesMessage: 'product.import.file.mime_type')]
    private ?UploadedFile $file;

    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    public function setFile(?UploadedFile $file): void
    {
        $this->file = $file;
    }
}
