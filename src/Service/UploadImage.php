<?php

namespace App\Service;

use App\Entity\Product;
use App\Entity\Tag;
use App\Request\ProductRequest;
use Doctrine\ORM\EntityManagerInterface;

use League\Flysystem\FilesystemOperator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Vich\UploaderBundle\Entity\File;

class UploadImage
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var FilesystemOperator
     */
    private $filesystemOperator;


    public function __construct(
        EntityManagerInterface $entityManager,
        FilesystemOperator $filesystemOperator
    ) {
        $this->entityManager = $entityManager;
        $this->filesystemOperator = $filesystemOperator;
    }

    public function handle(UploadedFile $file): string
    {
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '-' . uniqid() . '.' .$file->getClientOriginalExtension();
        $this->filesystemOperator->write($_ENV['AWS_S3_DIRECTORY'] . $fileName , file_get_contents($file->getPathname()));

        return $fileName;
    }
}
