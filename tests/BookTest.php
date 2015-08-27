<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    //require_once "src/Copy.php";
    require_once "src/Book.php";
    require_once "src/Author.php";

    $server = 'mysql:host=localhost; dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            //Copy::deleteAll();
            Book::deleteAll();
            Author::deleteAll();
        }

        function testGetTitle()
        {
            //arrange
            $title = "Dummies";
            $id = null;
            $test_book = new Book($title, $id);

            //act
            $result = $test_book->getTitle();

            //assert
            $this->assertEquals($title, $result);
        }

        function testGetId()
        {
            //arrange
            $title = "Dummies";
            $id = 1;
            $test_book = new Book($title, $id);

            //act
            $result = $test_book->getId();

            //assert
            $this->assertEquals($id, $result);
        }

        function testSave()
        {
            //arrange
            $title = "Dummies";
            $id = 1;
            $test_book = new Book($title);

            //act
            $test_book->save();

            //asssert
            $result = Book::getAll();
            $this->assertEquals($test_book, $result[0]);
        }

        function testGetAll()
        {
            //arrange
            $title = "Dummies";
            $id = 1;
            $test_book = new Book($title, $id);
            $test_book->save();

            $title2 = "Smarties";
            $id2 =  2;
            $test_book2 = new Book($title2, $id2);
            $test_book2->save();

            //act
            $result = Book::getAll();

            //assert
            $this->assertEquals([$test_book, $test_book2], $result);
        }

        function test_deleteAll()
        {
            //arrange
            $title = "Dummies";
            $id = 1;
            $test_book = new Book($title, $id);
            $test_book->save();

            $title2 = "Smarties";
            $id2 = 2;
            $test_book2 = new Book($title2, $id2);
            $test_book2->save();

            //act
            Book::deleteAll();

            //assert
            $result = Book::getAll();
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //arrange
            $title = "Dummies";
            $id = 1;
            $test_book = new Book($title, $id);
            $test_book->save();

            $title2 = "Smarties";
            $id2 = 2;
            $test_book2 = new Book($title2, $id2);
            $test_book2->save();

            //act
            $id = $test_book->getId();
            $result = Book::find($id);

            //assert
            $this->assertEquals($test_book, $result);
        }

        function testUpdate()
        {
            //arrange
            $id = 1;
            $title = "Donald";
            $test_book = new Book($title, $id);
            $test_book->save();

            $new_title = "Duck";

            //act
            $test_book->update($new_title);

            //assert
            $this->assertEquals("Duck", $test_book->getTitle());
        }

        function testDeleteBook()
        {
            $title = "Dummies";
            $id = 1;
            $test_book = new Book($title, $id);
            $test_book->save();

            $title2 = "Smarties";
            $id2 = 2;
            $test_book2 = new Book($title2, $id2);
            $test_book2->save();

            //act
            $test_book->delete();

            //assert
            $this->assertEquals([$test_book2], Book::getAll());
        }

        function testAddAuthor()
        {
            //arrange
            $title = "Lord of the Rings";
            $id = 1;
            $test_book = new Book($title, $id);
            $test_book->save();

            $name = "J.R.R. Tolkein";
            $id2 = 2;
            $test_author = new Author($name, $id2);
            $test_author->save();

            //act
            $test_book->addAuthor($test_author);

            //assert
            $this->assertEquals($test_book->getAuthors(), [$test_author]);
        }

        function testGetAuthors()
        {
            //arrange
            $title = "Lord of the Rings";
            $id = 1;
            $test_book = new Book($title, $id);
            $test_book->save();

            $name = "J.R.R. Tolkein";
            $id2 = 2;
            $test_author = new Author($name, $id2);
            $test_author->save();

            $name2 = "Mickey Mouse";
            $id3 = 3;
            $test_author2 = new Author($name2, $id3);
            $test_author2->save();

            //act
            $test_book->addAuthor($test_author);
            $test_book->addAuthor($test_author2);

            //assert
            $this->assertEquals($test_book->getAuthors(), [$test_author, $test_author2]);
        }

    }

?>
