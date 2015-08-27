<?php

    // /**
    // * @backupGlobals disabled
    // * @backupStaticAttributes disabled
    // */

    // require_once "src/Copy.php";
    // require_once "src/Book.php";
    // //require_once "src/Author.php";

    // $server = 'mysql:host=localhost;dbname=;library_test';
    // $username = 'root';
    // $password = 'root';
    // $DB = new PDO($server, $username, $password);

    // class CopyTest extends PHPUnit_Framework_TestCase
    // {
    //     protected function tearDown()
    //     {
    //         Copy::deleteAll();
    //         Book::deleteAll();
    //         Author::deleteAll();
    //     }

    //     function test_getId()
    //     {
    //         //arrange
    //         $title = "Donald";
    //         $id = null;
    //         $test_book = new Book($title, $id);
    //         $test_book->save();

    //         $amount = 1;
    //         $book_id = $test_book->getId();
    //         $test_copy = new Copy($amount, $id, $book_id);
    //         $test_copy->save();

    //         //act
    //         $result = $test_copy->getId();

    //         //assert
    //         $this->assertEquals(true, is_numeric($result));
    //     }


    //     function test_getBookId()
    //     {
    //         //arrange
    //         $title = "Donald";
    //         $id = null;
    //         $test_book = new Book($title, $id);
    //         $test_book->save();

    //         $amount = 1;
    //         $book_id = $test_book->getId();
    //         $test_copy = new Copy($amount, $id, $book_id);
    //         $test_copy->save();

    //         //act
    //         $result = $test_copy->getBookId();

    //         //assert
    //         $this->assertEquals(true, is_numeric($result));
    //     }

    //     function test_save()
    //     {
    //         //arrange
    //         $title = "Donald";
    //         $id = null;
    //         $test_book = new Book($title, $id);
    //         $test_book->save();

    //         $amount = 1;
    //         $book_id = $test_book->getId();
    //         $test_copy = new Copy($amount, $id, $book_id);

    //         //act
    //         $test_copy->save();

    //         //assert
    //         $result = Copy::getAll();
    //         $this->assertEquals($test_copy, $result[0]);
    //     }

    //     function getAll()
    //     {
    //         //arrange
    //         $title = "Donald";
    //         $id = null;
    //         $test_book = new Book($title, $id);
    //         $test_book->save();

    //         $amount = 1;
    //         $book_id = $test_book->getId();
    //         $test_copy = new Copy($amount, $id, $book_id);
    //         $test_copy->save();

    //         $amount = 2;
    //         $test_copy = new Copy($amount, $id, $book_id);
    //         $test_copy->save();

    //         //act
    //         $result = Copy::getAll;

    //         //assert
    //         $this->assertEquals([$test_copy, $test_copy2], $result);

    //     }

    //     function test_deleteAll()
    //     {
    //         //arrange
    //         $title = "Donald";
    //         $id = null;
    //         $test_book = new Book($title, $id);
    //         $test_book->save();

    //         $amount = 1;
    //         $book_id = $test_book->getId();
    //         $test_copy = new Copy($amount, $id, $book_id);
    //         $test_copy->save();

    //         $amount = 2;
    //         $test_copy = new Copy($amount, $id, $book_id);
    //         $test_copy->save();

    //         //act
    //         Copy::deleteAll();

    //         //assert
    //         $result = Copy::getAll();
    //         $this->assertEquals([], $result);
    //     }
    // }
?>
