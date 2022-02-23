<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductListController extends AbstractController
{
    /*private $productRepository;

    public function __construct(ProductsRepository $productRepository) {
        $this->productRepository = $productRepository;
    }*/

    #[Route('/product/list/{currentPage}/{nbDisplayed}', name: 'product_list')]
    public function products(ProductsRepository $productsRepository, $currentPage, $nbDisplayed): Response {
        $nbProducts = $productsRepository->count([]);
        $nbPage = $nbProducts/$nbDisplayed;
        if ($nbProducts%$nbDisplayed !=0){
            $nbPage = (int) ($nbProducts/$nbDisplayed)+1;
        }
        $products = $productsRepository->findByPagination($currentPage, $nbDisplayed);

        return $this->render('product_list/index.html.twig', [
            'produits' => $products,
            'nbPage' => $nbPage,
            'currentPage' => $currentPage,
            'nbDisplayed' => $nbDisplayed
        ]);
    }
}
