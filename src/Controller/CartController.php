<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\ProductOrder;
use App\Entity\Products;
use App\Form\AddressType;
use App\Form\PaymentType;
use App\Repository\OrdersRepository;
use App\Repository\ProductOrderRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
        //Get the product with the id & set the quantity to 1
        $productOrder = new ProductOrder();
        $productOrder->setProduct($product);
        $productOrder->setQuantity(1);

        //Get the session
        $session = $request->getSession();

        //Set the cart
        $cart = [];

        //Get the cart in the session
        if ($session->has('cart')) {
            $cart = $session->get('cart');
        }

        //Verify if the product already exists --> add 1 to quantity
        $exist = false;
        foreach ($cart as $productOrderElem) {
            if ($productOrderElem->getProduct()->getId() == $product->getId()) {
                $exist = true;
                $productOrderElem->setQuantity($productOrderElem->getQuantity() + 1);
            }
        }
        //If the product doesn't exist --> add to the cart
        if (!$exist) {
            $cart[] = $productOrder;
        }

        //Set the variable $cart in the session
        $session->set('cart', $cart);
        return $this->redirectToRoute('cart_display');
    }

    #[Route('/', name: 'display')]
    public function index(Request $request): Response {
        //Get the cart in the session
        $cart = [];
        $session = $request->getSession();
        if ($session->has('cart')) {
            $cart = $session->get('cart');
        }

        //Get the total price by adding the price of each products & their quantity
        $price = 0;
        foreach ($cart as $oneP) {
            $price += $oneP->getProduct()->getPrice() * $oneP->getQuantity();
        }
        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'price' => $price,
        ]);
    }

    #[Route('/remove-product/{id}', name: 'remove_product', methods: ['POST'])]
    public function removeProduct(Products $product, Request $request) {
        //Get the cart from the session
        $session = $request->getSession();
        $cart = $session->get('cart');

        //Get the id of the product to delete in the cart session
        $delete = null;
        foreach ($cart as $key => $productOrder) {
            if ($product->getId() == $productOrder->getProduct()->getId()) {
                $delete = $key;
            }
        }
        //removal of the product in the $cart
        unset($cart[$delete]);

        //Set the session cart with new $cart
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
    #[IsGranted('ROLE_USER')]
    public function cartValidation(SessionInterface $session, Request $request, StatusRepository $statusRepository, EntityManagerInterface $entityManager) {
        //Get the session cart
        $session = $request->getSession();
        $cart = $session->get('cart');

        //Get the total price of the cart
        $price = 0;
        foreach ($cart as $oneP) {
            $price += $oneP->getProduct()->getPrice() * $oneP->getQuantity();
        }

        //Get the current User
        $user = $this->getUser();

        //Creation of the form to modify user address
        $addressForm = $this->createForm(AddressType::class, $user);
        $addressForm->handleRequest($request);

        //When form is submitted & valid --> Update of the user address
        if ($addressForm->isSubmitted() && $addressForm->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('cart_validation', [], Response::HTTP_SEE_OTHER);
        }

        //Create form to get the type of payment
        $paymentForm = $this->createForm(PaymentType::class);
        $paymentForm->handleRequest($request);

        //When form is submitted & valid --> Send the order & product Order in the db
        if ($paymentForm->isSubmitted() && $paymentForm->isValid()) {
            //Creation of a new Order
            $order = new Orders();

            //Get the data from the payement form
            //& set the payment type in the new order
            $payment = $paymentForm->getData('payment_type');

            foreach ($payment as $value) {
                $order->setPayment($value);
            }

            //Get the status to set it in the order
            //& set the status type in the new order
            $status = $statusRepository->findBy(['label' => 'Accepté']);

            foreach ($status as $array) {
                $order->setStatus($array);
            }

            //Set the date and the user of the Order
            $order->setDateOrder(new \DateTime());
            $order->setUser($user);

            //Send the order to db
            $entityManager->persist($order);
            $entityManager->flush();

            //Creation of a line of the order & sending in the db
            foreach ($cart as $po) {
                $productOrder = new ProductOrder();
                $productOrder->setQuantity($po->getQuantity());
                $productOrder->setProduct($po->getProduct());
                $productOrder->setPriceNow($po->getProduct()->getPrice());
                $productOrder->setOrders($order);

                $entityManager->merge($productOrder);
                $entityManager->flush();
            }

            //Remove the cart from the session as order is already done
            if ($session->has('cart')) {
                $session->remove('cart');
            }

            return $this->redirectToRoute('cart_receipt', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('cart/orderOption.html.twig', [
            'addressForm' => $addressForm->createView(),
            'paymentForm' => $paymentForm->createView(),
            'price' => $price,
            'cart' => $cart
        ]);
    }

    #[Route('/receipt/', name: 'receipt', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function cartreceipt(OrdersRepository $ordersRepository, ProductOrderRepository $productOrderRepository) {
        //Get the last order of the User in db
        $order = $ordersRepository->findBy([], ['id' => 'DESC'], ['limit' => 1]);

        //Change date format & Get total price of the order
        foreach ($order as $value) {
            $orderId = $value->getId();
            $dateToString = $value->getDateOrder()->format('d-m-Y');
            $orderLines = $productOrderRepository->findBy(['orders' => $orderId]);
            $totalPrice = 0;
            foreach ($orderLines as $line) {
                $totalPrice += $line->getPriceNow() * (float)$line->getQuantity();
            }
        }
        return $this->render('cart/receipt.html.twig', [
            'orderLines' => $orderLines,
            'order' => $value,
            'dateOrder' => $dateToString,
            'totalPrice' => $totalPrice
        ]);
    }
}
