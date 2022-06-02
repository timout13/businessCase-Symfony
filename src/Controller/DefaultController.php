<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ContactFormType;
use App\Form\SearchBarType;
use App\Form\SearchEngineType;
use App\Form\SearchType;
use App\Repository\CategoryRepository;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private $productRepository;
    private $categoryRepository;

    public function __construct(ProductsRepository $productRepository, CategoryRepository $categoryRepository) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    #[Route('/', name: 'default')]
    public function index(): Response {
        $produits = $this->productRepository->findAll();
        //$categories = $this->categoryRepository->findByParentNull();
        return $this->render('default/index.html.twig', [
            'produits' => $produits,
            //'categories' => $categories
        ]);
    }

    public function displayCatNav(SessionInterface $session, Request $request, ProductsRepository $productsRepository): Response {
        $categories = $this->categoryRepository->findByParentNull();
        $cart = $session->get('cart', []);
        $cart_notif=0;
        $searchProduct='';
        $form = $this->createForm(SearchBarType::class);
        $form->handleRequest($request);
        foreach ($cart as $value){
            $cart_notif += $value->getQuantity();
        }
        $productSearched='';
        if ($form->isSubmitted() && $form->isValid()) {
            $filter = $form->getData();
            $productSearched = $productsRepository->search($filter);
            return  $this->redirectToRoute('product_all');
        }
        return $this->render('parts/header.html.twig', [
            'categories' => $categories,
            'cart_notif'=> $cart_notif,
            'formSearch'=>$form->createView(),

        ]);
    }


    #[Route('/product/list/detail/{id}', name: 'detail')]
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

    #[Route('/contact', name: 'contact')]
    public function contact(Request $request) {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('contact', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('default/contact.html.twig',
        ['form'=>$form->createView(),]);
    }

    /*#[Route('/register', name: 'register')]
    public function register() {
        return $this->render('default/register.html.twig');
    }*/
}
