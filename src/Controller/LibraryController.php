<?php

namespace App\Controller;

use App\Kernel;
use App\Entity\Library;
use App\Repository\LibraryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Filesystem\Filesystem;

use function PHPUnit\Framework\isNull;

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
        return $this->render("librarycreate.html.twig");
    }

    #[Route("/library/create", name: "libraryCreate", methods: ["POST"])]
    public function libraryCreate(ManagerRegistry $doctrine, Request $request): Response
    {
        /** @var string $isbn */
        $isbn = $request->request->get("isbn");

        /** @var string $title */
        $title = $request->request->get("title");

        /** @var string $author */
        $author = $request->request->get("author");

        /** @var string $imageName */
        $imageName = "";

        /** @var UploadedFile $image */
        $image = $request->files->get('file');

        if ($image instanceof UploadedFile) {
            $imageName = $image->getClientOriginalName();
            $image->move("../public/img", $image->getClientOriginalName());
        }
        $entityManager = $doctrine->getManager();
        $book = new Library();

        $book->setIsbn($isbn);
        $book->setAuthor($author);
        $book->setTitle($title);
        $book->setImgName($imageName);

        $entityManager->persist($book);
        $entityManager->flush();
        return $this->redirectToRoute("libraryShowAll");
    }

    #[Route("/library/update/view", name: "libraryUpdateView", methods: ["GET"])]
    public function libraryUpdateView(LibraryRepository $libraryRepository, ManagerRegistry $doctrine, Request $request): Response
    {
        $bookId = $request->query->get("id");
        if ($bookId === null) {
            return $this->redirectToRoute("libraryShowAll");
        }
        $book = $libraryRepository->find("$bookId");
        $data = [
            "book" => $book
        ];
        return $this->render("libraryUpdateView.html.twig", $data);
    }

    #[Route("/library/update", name: "libraryUpdate", methods: ["POST"])]
    public function libraryUpdate(ManagerRegistry $doctrine, Request $request, Kernel $kernel): Response
    {
        /** @var integer $bookId */
        $bookId = $request->request->get("id");

        /** @var string $isbn */
        $isbn = $request->request->get("isbn");

        /** @var string $title */
        $title = $request->request->get("title");

        /** @var string $author */
        $author = $request->request->get("author");

        /** @var string $imageName */
        $imageName = $request->request->get("image");

        /** @var  UploadedFile $image */
        $image = $request->files->get('file');

        $entityManager = $doctrine->getManager();
        /** @var Library $book */
        $book = $entityManager->getRepository(Library::class)->find($bookId);

        if ($image instanceof UploadedFile) {
            if ($image->getClientOriginalName() != $book->getImgName()) {
                $filesystem = new Filesystem();
                $path = $kernel->getProjectDir() . "/public/img/" . $imageName;
                $filesystem->remove($path);
                $imageName = $image->getClientOriginalName();
                $image->move("../public/img", $image->getClientOriginalName());
            }
        }

        $book->setIsbn($isbn);
        $book->setAuthor($author);
        $book->setTitle($title);
        $book->setImgName($imageName);
        $entityManager->persist($book);
        $entityManager->flush();
        return $this->redirectToRoute("libraryUpdateView", ["id" => $bookId]);
    }

    #[Route("/library/delete", name: "libraryDelete", methods: ["POST"])]
    public function libraryDelete(ManagerRegistry $doctrine, Request $request): Response
    {
        $bookId = $request->request->get("id");
        $entityManager = $doctrine->getManager();
        /** @var Library $book */
        $book = $entityManager->getRepository(Library::class)->find($bookId);

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute("libraryShowAll");
    }
}
