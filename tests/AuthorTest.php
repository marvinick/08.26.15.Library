<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";


    $server = 'mysql:host=localhost; dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Author::deleteAll();
        }

        function testGetName()
        {
            //arrange
            $name = "Donald";
            $id = null;
            $test_author = new Author($name, $id);

            //act
            $result = $test_author->getId();

            //assert
            $this->assertEquals($id, $result);
        }

        function testGetId()
        {
            //arrange
            $name = "Donald";
            $id = 1;
            $test_author = new Author($name, $id);

            //act
            $result = $test_author->getId();

            //assert
            $this->assertEquals($id, $result);
        }

        function testSave()
        {
            //arrange
            $name = "Donald";
            $test_author = new Author($name);
            $test_author->save();

            //act
            $result = Author::getAll();

            //assert
            $this->assertEquals($test_author, $result[0]);
        }

        function testGetAll()
        {
            //arrange
            $name = "Donald";
            $id = null;
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "Duck";
            $test_author2 = new Author($name2);
            $test_author2->save();

            //act
            $result = Author::getAll();

            //assert
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function test_deleteAll()
        {
            //arrange
            $name = "Donald";
            $id = null;
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "Duck";
            $test_author2 = new Author($name2);
            $test_author2->save();

            //act
            Author::deleteAll();

            //assert
            $result = Author::getAll();
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //assert
            $name = "Donald";
            $id = null;
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "Duck";
            $test_author2 = new Author($name2);
            $test_author2->save();

            //act
            $id = $test_author->getId();
            $result = Author::find($id);

            //assert
            $this->assertEquals($test_author, $result);
        }

    }
?>
