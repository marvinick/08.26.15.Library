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
        $book = Book::find($_POST['book_id']);
        $author = Author::find($_POST['author_id']);
        $book->addAuthor($author);
        return $app['twig']->render('book.html.twig', array('book' => $book, 'books' => Book::getAll(), 'authors' => $book->getAuthors(), 'all_authors' => Author::getAll()));
    });

    $app->get('/author_results', function() use ($app) {
        $author_matching_search = array();
        $authors = Author::getAll();
        $name = $_GET['name'];
        ucfirst($name);
        foreach ($authors as $author) {
            if ($author->getName() == $name)
             {
                 array_push($author_matching_search, $author);
             }
        }
        return $app['twig']->render('results.html.twig', array('matched_authors' => $author_matching_search));
    });

    $app->get('/book_results', function() use ($app) {
        $book_matching_search = array();
        $books = Book::getAll();
        $title = $_GET['title'];
        ucfirst($title);
        foreach ($books as $book) {
            if ($book->getTitle() == $title)
             {
                 array_push($book_matching_search, $book);
             }
        }
        return $app['twig']->render('result_book.html.twig', array('matched_books' => $book_matching_search));
    });

    $app->get("/books/{id}/edit", function($id) use ($app) {
        $book = Book::find($id);
        return $app['twig']->render('edit_book.html.twig', array('book' => $book));
    });

    $app->patch("/books/{id}", function($id) use ($app) {
        $title = $_POST['title'];
        $book = Book::find($id);
        $book->update($title);
        return $app['twig']->render('book.html.twig', array('book' => $book, 'books' => Book::getAll(), 'authors' => $book->getAuthors(), 'all_authors' => Author::getAll()));
    });

    return $app
?>
