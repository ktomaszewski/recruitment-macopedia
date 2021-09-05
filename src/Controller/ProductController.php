<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\Product\ProductImportType;
use Application\Service\Product\ProductImporter;
use Application\Util\Flash;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(path: '/product')]
final class ProductController extends AbstractController
{
    public function __construct(private TranslatorInterface $translator, private ProductImporter $productImporter)
    {
    }

    /**
     * @throws FileException
     */
    #[Route(path: '/import', name: 'app_product_import', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function import(Request $request): Response
    {
        $form = $this->createForm(ProductImportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productImporter->handleUploadedFile($form->getData());
            $this->addFlash(Flash::SUCCESS, $this->translator->trans('import.success', [], 'product'));

            return $this->redirectToRoute('app_product_import');
        }

        return $this->render('product/import.html.twig', ['form' => $form->createView()]);
    }
}
