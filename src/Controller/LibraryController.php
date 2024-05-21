<?php

namespace App\Controller;

use App\Entity\Library;
use App\Repository\LibraryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 */
class LibraryController extends AbstractController
{
    #[Route("/library", name: "library")]
    public function library(): Response
    {
        return $this->render('library.html.twig', [
            'controller_name' => 'LibraryController',
        ]);
    }

    #[Route("/library/show", name: "libraryShowAll")]
    public function showAllProduct(LibraryRepository $libraryRepository): Response
    {
        $library = $libraryRepository->findAll();
        $data = [
            "library" => $library
        ];

        return $this->render("libraryshow.html.twig", $data);
    }


    #[Route("/library/create", name: "libraryCreateView", methods: ["GET"])]
    public function libraryCreateView(ManagerRegistry $doctrine): Response
    {
        #$entityManager = $doctrine->getManager();

        #$book = new Library();

        #$entityManager->persist($book);
        #$entityManager->flush();

        return $this->render("librarycreate.html.twig");
    }

    #[Route("/library/create", name: "libraryCreate", methods: ["POST"])]
    public function libraryCreate(ManagerRegistry $doctrine, Request $request): Response
    {
        $isbn = $request->request->get("isbn");
        $title = $request->request->get("title");
        $author = $request->request->get("author");
        $image_name = null;
        $image = $request->files->get('file');
        if ($image) {
            $image_name = $image->getClientOriginalName();
            $file = $image->move("../public/img", $image->getClientOriginalName());
        }

        $entityManager = $doctrine->getManager();

        $book = new Library();

        $book->setIsbn($isbn);
        $book->setAuthor($author);
        $book->setTitle($title);
        $book->setImgName($image_name ?? "");

        $entityManager->persist($book);
        $entityManager->flush();
        return $this->redirectToRoute("libraryShowAll");
    }

    #[Route("/library/update", name: "libraryUpdate", methods: ["GET"])]
    public function libraryUpdate(ManagerRegistry $doctrine, Request $request): Response
    {
        return new Response("test123");
    } 
}
