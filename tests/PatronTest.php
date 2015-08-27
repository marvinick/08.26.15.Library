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
    }

?>
