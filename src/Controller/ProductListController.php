<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\SearchEngineType;
use App\Form\SearchType;
use App\Repository\CategoryRepository;
use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductListController extends AbstractController
{
    /*private $productRepository;

    public function __construct(ProductsRepository $productRepository) {
        $this->productRepository = $productRepository;
    }*/

    #[Route('/product/list/{idCat}/{currentPage}/{nbDisplayed}', name: 'product_list', requirements: ['idCat' => '\d+'])]
    public function products(ProductsRepository $productsRepository, $currentPage, $nbDisplayed, $idCat, CategoryRepository $categoryRepository, Request $request): Response {
        $form = $this->createForm(SearchEngineType::class);
        $form->handleRequest($request);

        $nbProducts = $productsRepository->countByCat($idCat);
        $nbPage = $nbProducts/$nbDisplayed;

        if ($nbProducts%$nbDisplayed !=0){
            $nbPage = (int) ($nbProducts/$nbDisplayed)+1;
        }

        $products = $productsRepository->findByPagination($idCat, $currentPage, $nbDisplayed);
        $categories = $categoryRepository->findByParentNull();


        $productFiltered = '';
        if ($form->isSubmitted() && $form->isValid()) {
            $filter = $form->getData();
            $productFiltered = $productsRepository->search($filter);
        }

        return $this->render('product_list/index.html.twig', [
            'produits' => $products,
            'nbPage' => $nbPage,
            'currentPage' => $currentPage,
            'nbDisplayed' => $nbDisplayed,
            'idCat'=> $idCat,
            'categories'=>$categories,
            'form'=>$form->createView(),
            'productFiltered'=>$productFiltered
        ]);
    }

    #[Route('/product/all', name: 'product_all')]
    public function allProducts(Request $request): Response {

//$productSearched= $request->request->get('search_bar')['searchBar'];
        return $this->render('product_list/allProducts.html.twig', [
            //'productSearched'=>$productSearched,
        ]);
    }

}
