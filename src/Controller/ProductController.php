<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\Product\ProductImportType;
use Application\Service\Product\ProductImporter;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

#[Route(path: '/product')]
final class ProductController
{
    public function __construct(
        private RouterInterface $router,
        private Environment $twigEnvironment,
        private FormFactoryInterface $formFactory,
        private ProductImporter $productImporter
    )
    {
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     * @throws FileException
     */
    #[Route(path: '/import', name: 'app_product_import', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function import(Request $request): Response
    {
        $form = $this->formFactory->create(ProductImportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productImporter->importFile($form->getData());

            return new RedirectResponse($this->router->generate('app_product_import'), Response::HTTP_FOUND);
        }

        return new Response($this->twigEnvironment->render('product/import.html.twig', ['form' => $form->createView()]));
    }
}
