<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ContactFormType;
use App\Form\SearchBarType;
use App\Form\SearchEngineType;
use App\Form\SearchType;
use App\Form\UserType;
use App\Repository\CategoryRepository;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
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
        return $this->render('default/index.html.twig', [
            'produits' => $produits,
        ]);
    }

    public function displayCatNav(SessionInterface $session, Request $request, ProductsRepository $productsRepository): Response {
        $categories = $this->categoryRepository->findByParentNull();
        $cart = $session->get('cart', []);
        $cart_notif = 0;
        $searchProduct = null;
        $form = $this->createForm(SearchBarType::class, $searchProduct);
        $form->handleRequest($request);
        foreach ($cart as $value) {
            $cart_notif += $value->getQuantity();
        }

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form);

            $productSearched = '';
            $filter = $form->getData();

            $productSearched = $productsRepository->search($filter);
            return $this->redirectToRoute('product_all');
        }
        return $this->render('parts/header.html.twig', [
            'categories' => $categories,
            'cart_notif' => $cart_notif,
            'formSearch' => $form->createView(),

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
            ['form' => $form->createView(),]);
    }

    #[Route('/account', name: 'account')]
    public function account() {
        return $this->render('default/account.html.twig');
    }

    #[Route('/account/detail', name: 'account_detail')]
    public function detail_account(EntityManagerInterface $entityManager, Request $request) {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('validation', [], Response::HTTP_SEE_OTHER);

        }
        return $this->render('default/account_detail.html.twig',
            [
                'user' => $user,
                'form' => $form->createView()
            ],

        );
    }

    #[Route('/account/order', name: 'account_order')]
    public function order_account() {
        return $this->render('default/account_order.html.twig');
    }
}
