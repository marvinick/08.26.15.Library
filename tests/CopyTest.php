<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Copy.php";
    require_once "src/Book.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CopyTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Copy::deleteAll();
            Book::deleteAll();
        }

        function test_getId()
        {
            //arrange
            $title = "Donald";
            $id = null;
            $test_book = new Book($title, $id);
            $test_book->save();

            $count = 1;
            $book_id = $test_book->getId();
            $test_Copy = new Copy($count, $id, $book_id);
            $test_Copy->save();

            //act
            $result = $test_Copy->getId();

            //assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getBookId()
        {
            //arrange
            $title = "Donald";
            $id = null;
            $test_book = new Book ($title, $id);
            $test_book->save();

            $count = 1;
            $book_id = $test_book->getId();
            $test_copy = new Copy($count, $id, $book_id);
            $test_copy->save();

            //act
            $result = $test_copy->getBookId();

            //assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //arrange
            $title = "Donald";
            $id = null;
            $test_book = new Book ($title, $id);
            $test_book->save();

            $count = 1;
            $book_id = $test_book->getId();
            $test_copy = new Copy($count, $id, $book_id);

            //act
            $test_copy->save();

            //assert
            $result = Copy::getAll();
            $this->assertEquals($test_copy, $result[0]);
        }

        function test_getAll()
        {
            //arrange
            $title = "Donald";
            $id = null;
            $test_book = new Book($title, $id);
            $test_book->save();

            $count = 1;
            $book_id = $test_book->getId();
            $test_copy = new Copy($count, $id, $book_id);
            $test_copy->save();

            $count2 = 2;
            $test_copy2 = new Copy($count2, $id, $book_id);
            $test_copy2->save();

            //act
            $result = Copy::getAll();

            //assert
            $this->assertEquals([$test_copy, $test_copy2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $title = "Donald";
            $id = null;
            $test_book = new Book($title, $id);
            $test_book->save();

            $count = 1;
            $book_id = $test_book->getId();
            $test_copy = new Copy($count, $id, $book_id);
            $test_copy->save();

            $count2 = 2;
            $test_copy2 = new Copy($count2, $id, $book_id);
            $test_copy2->save();

            //Act
            Copy::deleteAll();

            //Assert
            $result = Copy::getAll();
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $title = "Donald";
            $id = null;
            $test_book = new Book($title, $id);
            $test_book->save();

            $count = 1;
            $book_id = $test_book->getId();
            $test_copy = new Copy($count, $id, $book_id);
            $test_copy->save();

            $count2 = 2;
            $test_copy2 = new Copy($count2, $id, $book_id);
            $test_copy2->save();

            //Act
            $id = $test_copy->getId();
            $result = Copy::find($id);

            //Assert
            $this->assertEquals($test_copy, $result);
        }

        function testAddPatron()
        {
            //arrange
            $count = 1;
            $id2 = 2;
            $book_id = 1;
            $test_copy = new Copy ($count, $id2, $book_id);
            $test_copy->save();

            $name = "Trump";
            $id = 1;
            $test_patron = new Patron($name, $id);
            $test_patron->save();

            //act
            $test_copy->addPatron($test_patron);

            //assert
            $this->assertEquals($test_copy->getPatrons(), [$test_patron]);
        }

        function testGetPatrons()
        {
            //arrange
            $count = 1;
            $id = 1;
            $book_id = 1;
            $test_copy = new Copy ($count, $id, $book_id);
            $test_copy->save();

            $name = "Trump";
            $id2 = 2;
            $test_patron = new Patron($name, $id2);
            $test_patron->save();

            $name2 = "Rosie";
            $id3 = 3;
            $test_patron2 = new Patron($name2, $id3);
            $test_patron2->save();

            //act
            $test_copy->addPatron($test_patron);
            $test_copy->addPatron($test_patron2);

            //assert
            $this->assertEquals($test_copy->getPatrons(), [$test_patron, $test_patron2]);
        }
    }
?>
