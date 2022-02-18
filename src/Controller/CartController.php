<?php

namespace App\Controller;

use App\Entity\ProductOrder;
use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController
{

    #[Route('/{id}', name: 'add', requirements: ['id'=> '\d+'])]
    public function addToCart(Products $products, Request $request) {
        $productOrder = new ProductOrder();
        $productOrder->setProduct($products);
        $productOrder->setQuantity(1);

        $session = $request->getSession();

        $cart=[];

        if ($session->has('cart')){
            $cart = $session->get('cart');
        }

        $exist = false;
        foreach ($cart as $productOrder){
            if ($productOrder->getProduct() == $products){
                $exist = true;
                $productOrder->setQuantity($productOrder->getQuantity() + 1);
            }
        }
        if (!$exist){
            $cart[]= $productOrder;
        }

        $session->set('cart', $cart);
        return $this->redirectToRoute('cart_display');
    }
    #[Route('/', name: 'display')]
    public function index(Request $request): Response {
        $cart = $request->getSession()->get('cart');
        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
        ]);
    }
}
