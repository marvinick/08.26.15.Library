<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Author.php";

    $app = new Silex\Application();
    $server = 'mysql:host=localhost;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
      'twig.path' => array (
           __DIR__.'/../views'
      )
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('authors' => Author::getAll(), 'books'=> Book::getAll()));
    });

    $app->get("/authors", function() use ($app) {
    return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));
    });

    $app->get("/books", function() use ($app) {
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    $app->post("/authors", function() use ($app) {
    $name = $_POST['name'];
    $author = new Author($name);
    $author->save();
    return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));
    });

    $app->get("/authors/{id}", function($id) use ($app) {
        $author = Author::find($id);
        return $app['twig']->render('author.html.twig', array('author' => $author, 'books' => $author->getBooks(), 'all_books' => Book::getAll()));
    });

    $app->post("/books", function() use ($app) {
        $book = new Book($_POST['title']);
        $book->save();
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    $app->get("/books/{id}", function($id) use ($app) {
        $book = Book::find($id);
        return $app['twig']->render('book.html.twig', array('book' => $book, 'authors' => $book->getAuthors(), 'all_authors' => Author::getAll()));
    });

    $app->post("/add_books", function() use ($app) {
        $author = Author::find($_POST['author_id']);
        $book = Book::find($_POST['book_id']);
        $author->addBook($book);
        return $app['twig']->render('author.html.twig', array('author' => $author, 'authors' => Author::getAll(), 'books' => $author->getBooks(), 'all_books' => Book::getAll()));
    });

    $app->post("/add_authors", function() use ($app) {
        $author = Author::find($_POST['author_id']);
        $book = Book::find($_POST['book_id']);
        $book->addAuthor($author);
        return $app['twig']->render('book.html.twig', array('book' => $book, 'books' => Book::getAll(), 'authors' => $book->getAuthors(), 'all_authors' => Author::getAll()));
    });

    return $app
?>