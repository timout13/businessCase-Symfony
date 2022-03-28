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
    public function addToCart(Products $product, Request $request) {
        $productOrder = new ProductOrder();
        $productOrder->setProduct($product);
        $productOrder->setQuantity(1);

        $session = $request->getSession();

        $cart=[];

        if ($session->has('cart')){
            $cart = $session->get('cart');
        }

        $exist = false;
        foreach ($cart as $productOrderElem){
            /*dump('produit');
            dump($product->getId());
            dump('produits dans ma session panier');
            dump($productOrderElem->getProduct()->getId());
            dump('expression entre les deux');
            dd($productOrderElem->getProduct() == $product);*/
            if ($productOrderElem->getProduct()->getId() == $product->getId()){
                $exist = true;
                $productOrderElem->setQuantity($productOrderElem->getQuantity() + 1);
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
