<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private $productRepository;

    public function __construct(ProductsRepository $productRepository) {
        $this->productRepository = $productRepository;
    }

    #[Route('/', name: 'default')]
    public function index(): Response {
        $produits = $this->productRepository->findAll();
        return $this->render('default/index.html.twig', [
            'produits' => $produits,
        ]);
    }

    #[Route('/products', name: 'products')]
    public function products(): Response {
        $produits = $this->productRepository->findAll();
        return $this->render('default/products.html.twig', [
            'produits' => $produits,
        ]);
    }

    #[Route('/detail/{id}', name: 'detail')]
    public function getOne(Products $product) {
        return $this->render('default/detail.html.twig', ['produit' => $product]);
    }

    #[Route('/mentionslegales', name: 'mentions-legales')]
    public function legalMention() {
        return $this->render('default/mentionsLegales.html.twig');
    }

    #[Route('/cgv', name: 'cgv')]
    public function cgv() {
        return $this->render('default/cgv.html.twig');
    }
}
