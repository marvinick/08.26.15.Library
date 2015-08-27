<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Patron.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class PatronTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Patron::deleteAll();
        }

        function testGetName()
        {
            //arrange
            $name = "Donald";
            $id = null;
            $test_patron = new Patron ($name, $id);

            //act
            $result = $test_patron->getId();

            //assert
            $this->assertEquals($id, $result);
        }

        function testGetId()
        {
            //arrange
            $name = "Donald";
            $id = 1;
            $test_patron = new Patron($name, $id);

            //act
            $result = $test_patron->getId();

            //assert
            $this->assertEquals($id, $result);
        }

        function testSave()
        {
            //arrange
            $name = "Donald";
            $id = 1;
            $test_patron = new Patron($name);

            //act
            $test_patron->save();

            //assert
            $result = Patron::getAll();
            $this->assertEquals($test_patron, $result[0]);
        }

        function testGetAll()
        {
            //arrange
            $name = "Donald";
            $id = 1;
            $test_patron = new Patron($name, $id);
            $test_patron->save();

            $name2 = "Duck";
            $id2 = 2;
            $test_patron2 = new Patron($name2, $id2);
            $test_patron2->save();

            //act
            $result = Patron::getAll();

            //assert
            $this->assertEquals([$test_patron, $test_patron2], $result);
        }

        function test_deleteAll()
        {
            //arrange
            $name = "Donald";
            $id = 1;
            $test_patron = new Patron($name, $id);
            $test_patron->save();

            $name2 = "Duck";
            $id2 = 2;
            $test_patron2 = new Patron($name2, $id2);
            $test_patron2->save();

            //act
            Patron::deleteAll();

            //assert
            $result = Patron::getAll();
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //assert
            $name = "Donald";
            $id = 1;
            $test_patron = new Patron($name, $id);
            $test_patron->save();

            $name2 = "Duck";
            $id2 = 2;
            $test_patron2 = new Patron($name2, $id2);
            $test_patron2->save();

            //act
            $id = $test_patron->getId();
            $result = Patron::find($id);

            //assert
            $this->assertEquals($test_patron, $result);
        }

        function testAddCopy()
        {
            //arrange
            $name = "Trump";
            $id = 1;
            $test_patron = new Patron($name, $id);
            $test_patron->save();

            $count = 1;
            $id2 = 2;
            $book_id = 1;
            $test_copy = new Copy ($count, $id2, $book_id);
            $test_copy->save();

            //act
            $test_patron->addCopy($test_copy);

            //assert
            $this->assertEquals($test_patron->getCopies(), [$test_copy]);
        }

        function testGetCopies()
        {
            //arrange
            $name = "Trump";
            $id = 1;
            $test_patron = new Patron($name, $id);
            $test_patron->save();

            $count = 1;
            $id2 = 2;
            $book_id = 1;
            $test_copy = new Copy ($count, $id2, $book_id);
            $test_copy->save();

            $count2 = 2;
            $id3 = 3;
            $book_id2 = 3;
            $test_copy2 = new Copy ($count2, $id3, $book_id2);
            $test_copy2->save();

            //act
            $test_patron->addCopy($test_copy);
            $test_patron->addCopy($test_copy2);

            //assert
            $this->assertEquals($test_patron->getCopies(), [$test_copy, $test_copy2]);
        }

    }

?>
