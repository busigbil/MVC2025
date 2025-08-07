<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LibraryController extends AbstractController
{
    #[Route("/library", name: 'library')]
    public function index(): Response
    {
        return $this->redirectToRoute('show_all');
    }

    #[Route("/library/create", name: "add_book_get", methods: ['GET'])]
    public function addBook(): Response
    {
        return $this->render('library/create.html.twig');
    }

    #[Route("/library/create", name: "add_book_post", methods: ['POST'])]
    public function addBookCallback(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();

        $book = new Book();
        $book->setTitle((string) $request->request->get('title'));
        $book->setIsbn((string) $request->request->get('isbn'));
        $book->setAuthor((string) $request->request->get('author'));
        $book->setImage((string) $request->request->get('image'));

        $entityManager->persist($book);

        $entityManager->flush();

        return $this->redirectToRoute('show_all');
    }

    #[Route("/library/show/{id}", name: "show_one", methods: ['GET'])]
    public function showBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository->find($id);

        if (!$book) {
            throw new Exception("No book found for id");
        }

        return $this->render(
            'library/display_one.html.twig',
            array('book' => $book)
        );
    }

    #[Route("/library/show", name: "show_all", methods: ['GET'])]
    public function showAllBooks(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository->findAll();

        return $this->render(
            'library/display_all.html.twig',
            array('books' => $books)
        );
    }

    #[Route("/library/update/{id}", name: "update_book_get", methods: ['GET'])]
    public function updateBook(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository->find($id);

        if (!$book) {
            throw new Exception("No book found for id");
        }

        return $this->render(
            'library/update.html.twig',
            array('book' => $book)
        );
    }

    #[Route("/library/update/{id}", name: "update_book_post", methods: ['POST'])]
    public function updateBookCallback(
        BookRepository $bookRepository,
        Request $request,
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $bookRepository->find($id);

        if (!$book) {
            throw new Exception("No book found for id");
        }

        $book->setTitle((string) $request->request->get('title'));
        $book->setIsbn((string) $request->request->get('isbn'));
        $book->setAuthor((string) $request->request->get('author'));
        $book->setImage((string) $request->request->get('image'));

        $entityManager->flush();

        return $this->redirectToRoute('show_all');
    }

    #[Route("/library/delete/{id}", name: "delete_book", methods: ['GET', 'POST'])]
    public function deleteBook(
        BookRepository $bookRepository,
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $bookRepository->find($id);

        if (!$book) {
            throw new Exception("No book found for id");
        }

        $title = $book->getTitle();

        $entityManager->remove($book);
        $entityManager->flush();

        $this->addFlash(
            'notice',
            $title . ' har tagits bort'
        );

        return $this->redirectToRoute('show_all');
    }

    #[Route("/api/library/books", name: 'json-books', methods: ['GET'], defaults: ['description' => 'Returnerar en JSON-struktur med samtliga böcker i biblioteket.'])]
    public function jsonBooks(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository->findAll();

        if (empty($books)) {
            throw $this->createNotFoundException(
                'No books found'
            );
        }

        $response = $this->json($books);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/library/book/{isbn<\d+>}", name: 'json-isbn', methods: ['GET'], defaults: ['description' => 'Returnerar en JSON-struktur för valt ISBN-nummer.', 'isbn' => '9789129691771'])]
    public function jsonIsbn(
        BookRepository $bookRepository,
        ManagerRegistry $doctrine,
        string $isbn
    ): Response {
        $book = $bookRepository->findOneBy(['isbn' => $isbn]);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for ISBN: '.$isbn
            );
        }

        $response = $this->json($book);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
