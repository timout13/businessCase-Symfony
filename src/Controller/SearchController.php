<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /*public function navSearchBar(ProductsRepository $productsRepository, Request $request): Response
    {
        $form= $this->createForm(SearchType::class);
        $form->handleRequest($request);
        $productFiltered = '';
        if ($form->isSubmitted() && $form->isValid()) {
            $filter = $form->getData();
            $productFiltered = $productsRepository->search($filter);
        }
        return $this->render('parts/header.html.twig', [
            'controller_name' => 'SearchController',
            'formSearch'=>$form->createView(),
            'filteredProducts' => $productFiltered
        ]);
    }*/
}
