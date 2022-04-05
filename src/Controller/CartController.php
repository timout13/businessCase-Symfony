<?php

namespace App\Controller;

use App\Entity\ProductOrder;
use App\Entity\Products;
use App\Entity\User;
use App\Form\QuantityOrderType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController
{

    #[Route('/{id}', name: 'add', requirements: ['id' => '\d+'])]
    public function addToCart(Products $product, Request $request) {
        $productOrder = new ProductOrder();
        $productOrder->setProduct($product);
        $productOrder->setQuantity(1);

        $session = $request->getSession();

        $cart = [];

        if ($session->has('cart')) {
            $cart = $session->get('cart');
        }

        $exist = false;
        foreach ($cart as $productOrderElem) {
            /*dump('produit');
            dump($product->getId());
            dump('produits dans ma session panier');
            dump($productOrderElem->getProduct()->getId());
            dump('expression entre les deux');
            dd($productOrderElem->getProduct() == $product);*/
            if ($productOrderElem->getProduct()->getId() == $product->getId()) {
                $exist = true;
                $productOrderElem->setQuantity($productOrderElem->getQuantity() + 1);
            }
        }
        if (!$exist) {
            $cart[] = $productOrder;
        }

        $session->set('cart', $cart);
        return $this->redirectToRoute('cart_display');
    }

    #[Route('/', name: 'display')]
    public function index(Request $request): Response {
        $cart = [];
        $session = $request->getSession();

        if ($session->has('cart')) {
            $cart = $session->get('cart');
        }

        $price = 0;

        foreach ($cart as $oneP) {
            $price += $oneP->getProduct()->getPrice() * $oneP->getQuantity();
        }

        // Calculer le prix total

        // Afficher mon panier
        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'price' => $price,

        ]);
    }

    #[Route('/remove-product/{id}', name: 'remove_product')]
    public function removeProduct(Products $product, Request $request) {
        $session = $request->getSession();
        $cart = $session->get('cart');
        $delete = null;
        foreach ($cart as $key => $productOrder) {
            if ($product->getId() == $productOrder->getProduct()->getId()) {
                $delete = $key;
            }
        }

        unset($cart[$delete]);

        $session->set('cart', $cart);


        return $this->redirectToRoute('cart_display');
    }

    #[Route('/{operator}/{id}', 'addremoveone')]
    public function incrementQuantityProduct(Products $product, Request $request, $operator) {
        $session = $request->getSession();
        $cart = $session->get('cart');

        foreach ($cart as $po) {
            if ($po->getProduct()->getId() == $product->getId()) {
                if ($operator == 'plus') {
                    $po->setQuantity($po->getQuantity() + 1);
                } elseif ($operator == 'minus') {
                    if ($po->getQuantity() > 1) {
                        $po->setQuantity($po->getQuantity() - 1);
                    } else {
                        $delete = null;
                        foreach ($cart as $key => $productOrder) {
                            if ($product->getId() == $productOrder->getProduct()->getId()) {
                                $delete = $key;
                            }
                        }
                        unset($cart[$delete]);
                    }
                }
            }
        }
        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_display');
    }

    #[Route('/validation', name: 'validation')]
    public function cartValidation(SessionInterface $session, Request $request,User $user, EntityManagerInterface $entityManager) {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        }
        return $this->render('cart/orderOption.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
}
