<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Products;
use App\Form\BrandType;
use App\Form\CategoryType;
use App\Form\ProductType;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
/*#[IsGranted('ROLE_ADMIN')]*/

class AdminController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/category', name: 'category_index', methods: ['GET'])]
    public function category_index(CategoryRepository $categoryRepository): Response {
        return $this->render('admin/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/category/new', name: 'category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('admin_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/category/{id}', name: 'category_show', methods: ['GET'])]
    public function show(Category $category): Response {
        return $this->render('admin/category/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/category/{id}/edit', name: 'category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('admin_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/category/{id}', name: 'category_delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, EntityManagerInterface $entityManager): Response {
        if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_category_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/brand', name: 'brand_index', methods: ['GET'])]
    public function brand_index(BrandRepository $brandRepository): Response {
        return $this->render('admin/brand/index.html.twig', [
            'brands' => $brandRepository->findAll(),
        ]);
    }

    #[Route('/brand/new', name: 'brand_new', methods: ['GET', 'POST'])]
    public function brand_new(Request $request, EntityManagerInterface $entityManager): Response {
        $brand = new Brand();
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($brand);
            $entityManager->flush();

            return $this->redirectToRoute('admin_brand_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/brand/new.html.twig', [
            'brand' => $brand,
            'form' => $form,
        ]);
    }
    #[Route('/brand/{id}/edit', name: 'brand_edit', methods: ['GET', 'POST'])]
    public function brand_edit(Request $request, Brand $brand, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($brand);
            $entityManager->flush();

            return $this->redirectToRoute('admin_brand_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/brand/edit.html.twig', [
            'brand' => $brand,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/brand/{id}', name: 'brand_delete', methods: ['POST'])]
    public function brand_delete(Request $request, Brand $brand, EntityManagerInterface $entityManager): Response {
        if ($this->isCsrfTokenValid('delete' . $brand->getId(), $request->request->get('_token'))) {
            $entityManager->remove($brand);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_brand_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/product', name: 'product_index', methods: ['GET'])]
    public function product_index(ProductsRepository $productsRepository): Response {
        return $this->render('admin/product/index.html.twig', [
            'products' => $productsRepository->findAll(),
        ]);
    }
    #[Route('/product/new', name: 'product_new', methods: ['GET', 'POST'])]
    public function product_new(Request $request, EntityManagerInterface $entityManager): Response {
        $product = new Products();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('admin_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }
    #[Route('/product/{id}/edit', name: 'product_edit', methods: ['GET', 'POST'])]
    public function product_edit(Request $request, Products $products, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(ProductType::class, $products);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($products);
            $entityManager->flush();

            return $this->redirectToRoute('admin_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/product/edit.html.twig', [
            'product' => $products,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/product/{id}', name: 'product_delete', methods: ['POST'])]
    public function product_delete(Request $request, Products $products, EntityManagerInterface $entityManager): Response {
        if ($this->isCsrfTokenValid('delete' . $products->getId(), $request->request->get('_token'))) {
            $entityManager->remove($products);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
