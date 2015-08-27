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
    }
?>
