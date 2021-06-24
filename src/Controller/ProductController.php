<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'product_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //? Pictures Uploading ?//
            // Get uploaded pictures
            $pictures = $form->get('pictures')->getData();

            // Loop on pictures
            foreach($pictures as $picture) {
                // Generate a new file name
                $file = md5(uniqid()) . '.' .$picture->guessExtension();

                // Copy the file in the "uploads" folder
                $picture->move(
                    $this->getParameter('pictures_directory'),
                    $file
                );

                // Store picture in database (nameless)
                $pic = new Picture();
                $pic->setUrl($file);
                $product->addPicture($pic);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}/edit', name: 'product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //? Pictures Uploading ?//
            // Get uploaded pictures
            $pictures = $form->get('picture')->getData();

            // Loop on pictures
            foreach($pictures as $picture) {
                // Generate a new file name
                $file = md5(uniqid()) . '.' .$picture->guessExtension();

                // Copy the file in the "uploads" folder
                $picture->move(
                    $this->getParameter('pictures_directory'),
                    $file
                );

                // Store picture in database (nameless)
                $pic = new Picture();
                $pic->setUrl($file);
                $product->addPicture($pic);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index');
    }

    //? To delete a picture 
    #[Route('/delete/picture/{id}', name: 'product_delete_picture', methods: ['GET'])]
    public function deletePicture(Picture $picture, Request $request) {
        $data = json_decode($request->getContent(), true);

        //TODO = Deploy CSRF vs JWT
        // Check if token is valid
        // if($this->isCsrfTokenValid('delete'.$picture->getId(), $data['_token'])) {
            // Get the name of the picture
            $url = $picture->getUrl();

            // Delete the file
            unlink($this->getParameter('pictures_directory').'/'.$url);            

            // Delete the entry in the database
            $entityManager= $this->getDoctrine()->getManager();
            $entityManager->remove($picture);
            $entityManager->flush();

            // Return a JSON response
            // return new JsonResponse(['success' => 1]);

            // TODO = Delete and Display PlaceHolders (no file stored)
        // } else {
            // return new JsonResponse(['error' => 'Invalid Token'], 400);
        // }
            
        // TODO = REDIRECT TO PRDUCT VIEW
        return new Response("Coucou!");

        // TODO = UPDATE ENTITIES (Picture Relation to Product, delete product_picture)
    }
}
