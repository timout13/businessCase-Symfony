<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\ProductOrder;
use App\Entity\Products;
use App\Entity\Status;
use App\Entity\User;
use App\Form\AddressType;
use App\Form\PaymentType;
use App\Form\QuantityOrderType;
use App\Form\UserType;
use App\Repository\OrdersRepository;
use App\Repository\ProductOrderRepository;
use App\Repository\StatusRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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

    #[Route('/validation', name: 'validation', methods: ['GET', 'POST'])]
    public function cartValidation(SessionInterface $session, Request $request, StatusRepository $statusRepository, EntityManagerInterface $entityManager) {
        $session = $request->getSession();
        $cart = $session->get('cart');

        $user = $this->getUser();
        $addressForm = $this->createForm(AddressType::class, $user);
        $addressForm->handleRequest($request);

        if ($addressForm->isSubmitted() && $addressForm->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('cart_validation', [], Response::HTTP_SEE_OTHER);
        }

        $paymentForm = $this->createForm(PaymentType::class);
        $paymentForm->handleRequest($request);

        if ($paymentForm->isSubmitted() && $paymentForm->isValid()) {
            $payment = $paymentForm->getData('payment_type');
            $order = new Orders();
            $status = $statusRepository->findBy(['label' => 'Accepté']);

            foreach ($payment as $value) {
                $order->setPayment($value);
            }

            foreach ($status as $array) {
                $order->setStatus($array);
            }

            $order->setDateOrder(new \DateTime());
            $order->setUser($user);
            $entityManager->persist($order);
            $entityManager->flush();

            foreach ($cart as $po) {
                $productOrder = new ProductOrder();
                $productOrder->setQuantity($po->getQuantity());
                $productOrder->setProduct($po->getProduct());
                $productOrder->setPriceNow($po->getProduct()->getPrice());
                $productOrder->setOrders($order);

                $entityManager->merge($productOrder);
                $entityManager->flush();
            }
            if ($session->has('cart')) {
                $session->remove('cart');
            }
            return $this->redirectToRoute('cart_receipt', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('cart/orderOption.html.twig', [
            'addressForm' => $addressForm->createView(),
            'paymentForm' => $paymentForm->createView(),
        ]);
    }

    #[Route('/summary', name: 'summary', methods: ['GET', 'POST'])]
    public function cartSummary(SessionInterface $session, Request $request, UserInterface $user, EntityManagerInterface $entityManager) {

        return $this->render('cart/orderOption.html.twig', [
        ]);
    }

    #[Route('/receipt/', name: 'receipt', methods: ['GET', 'POST'])]
    public function cartreceipt(OrdersRepository $ordersRepository, ProductOrderRepository $productOrderRepository) {
        $order=$ordersRepository->findBy([],['id'=>'DESC'],['limit'=>1]);
        foreach ($order as $value){
            $orderId = $value->getId();
            $dateToString = $value->getDateOrder()->format('Y-m-d H:i:s');
            $orderLines=$productOrderRepository->findBy(['orders'=>$orderId]);
        }
        return $this->render('cart/receipt.html.twig', [
            'orderLines'=>$orderLines,
            'order'=>$value,
            'dateOrder'=>$dateToString
        ]);
    }
}
