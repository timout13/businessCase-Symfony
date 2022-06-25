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
    #[Route('/product/list/{idCat}/{currentPage}/{nbDisplayed}', name: 'product_list', requirements: ['idCat' => '\d+'])]
    public function products(ProductsRepository $productsRepository, $currentPage, $nbDisplayed, $idCat, CategoryRepository $categoryRepository, Request $request): Response {
        $objName[]= '';
        $form = $this->createForm(SearchEngineType::class,$objName,['catId'=>$idCat]);
        $form->handleRequest($request);

        $nbProducts = $productsRepository->countByCat($idCat);
        $nbPage = $nbProducts/$nbDisplayed;

        if ($nbProducts%$nbDisplayed !=0){
            $nbPage = (int) ($nbProducts/$nbDisplayed)+1;
        }
        $categories = $categoryRepository->findByParentNull();

        $catName=$categoryRepository->findBy(['id'=>$idCat]);

        $test= $form->getData();
        $products= '';
        if ($form->isSubmitted() && $form->isValid()) {
            $filter = $form->getData();

            $products = $productsRepository->search($filter, $currentPage, $nbDisplayed);

        } else{
            $products = $productsRepository->findByPagination($idCat, $currentPage, $nbDisplayed);
        }

        return $this->render('product_list/index.html.twig', [
            'produits' => $products,
            'nbPage' => $nbPage,
            'currentPage' => $currentPage,
            'nbDisplayed' => $nbDisplayed,
            'idCat'=> $idCat,
            'categories'=>$categories,
            'form'=>$form->createView(),
        ]);
    }

    #[Route('/product/all', name: 'product_all')]
    public function allProducts(Request $request, ProductsRepository $productsRepository): Response {
        $products = $productsRepository->findAll();
        return $this->render('product_list/allProducts.html.twig', @
            ['products'=>$products,]
        );
    }

}
