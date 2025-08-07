<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

/**
 * Test cases for class LibraryController.
 */
class LibraryControllerTest extends WebTestCase
{
    private static EntityManagerInterface $entityManager;
    protected static ?int $bookId = null;

    /**
     * Initialize database schema once before test class is run.
     * Create a book that can be used in all tests.
     */
    public static function setUpBeforeClass(): void
    {
        $client = static::createClient();
        self::$entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $metadata = self::$entityManager->getMetadataFactory()->getAllMetadata();
        if (!empty($metadata)) {
            $schemaTool = new SchemaTool(self::$entityManager);
            $schemaTool->dropSchema($metadata);
            $schemaTool->createSchema($metadata);
        }

        $book = new Book();
        $book->setTitle('Shared Test Book');
        $book->setIsbn('9789100194888');
        $book->setAuthor('Test Author');
        $book->setImage('cover.png');

        self::$entityManager->persist($book);
        self::$entityManager->flush();

        self::$bookId = $book->getId();
    }

    /**
     * Test instantiation of class
     */
    public function testInstantiateLibraryController(): void
    {
        $controller = new LibraryController();
        $this->assertInstanceOf("\App\Controller\LibraryController", $controller);
    }

    /**
     * Test route /api/library/books
     */
    public function testControllerJsonBooks(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/library/books');
        $this->assertResponseIsSuccessful();
    }

    /**
     * Test route /api/library/book/{isbn<\d+>}
     */
    public function testControllerJsonIsbn(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/library/book/9789100194888');
        $this->assertResponseIsSuccessful();
    }

    /**
     * Test route /library
     */
    public function testControllerIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/library');
        $this->assertResponseRedirects('/library/show');
    }

    /**
     * Test route /library/create
     */
    public function testControllerAddBook(): void
    {
        $client = static::createClient();
        $client->request('GET', '/library/create');
        $this->assertResponseIsSuccessful();
    }

    /**
     * Test route /library/create
     */
    public function testControllerAddBookCallback(): void
    {
        $client = static::createClient();

        // Act — send POST request to your route
        $client->request('POST', '/library/create', [
            'title'  => 'Test Book',
            'isbn'   => '1234567890',
            'author' => 'Test Author',
            'image'  => 'cover.png',
        ]);

        // Assert — response should redirect
        $this->assertResponseRedirects('/library/show');
    }

    /**
     * Test route /library/show/{id}
     */
    public function testControllerShowBook(): void
    {
        $client = static::createClient();
        $client->request('GET', '/library/show/' . self::$bookId);
        $this->assertResponseIsSuccessful();
    }

    /**
     * Test route /library/show
     */
    public function testControllerShowAll(): void
    {
        $client = static::createClient();
        $client->request('GET', '/library/show');
        $this->assertResponseIsSuccessful();
    }

    /**
     * Test route /library/update/{id}
     */
    public function testControllerUpdateBook(): void
    {
        $client = static::createClient();
        $client->request('GET', '/library/update/1');
        $this->assertResponseIsSuccessful();
    }

    /**
     * Test route /library/update/{id}
     */
    public function testControllerUpdateBookCallback(): void
    {
        $client = static::createClient();
        $client->request('POST', '/library/update/2');
        $this->assertResponseRedirects('/library/show');
    }

    /**
     * Test route /library/delete/{id}
     */
    public function testControllerDeleteBook(): void
    {
        $client = static::createClient();
        $client->request('POST', '/library/delete/1');
        $this->assertResponseRedirects('/library/show');
    }
}
