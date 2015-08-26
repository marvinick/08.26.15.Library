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
            //Book::deleteAll();
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
            $id = 1;
            $test_author = new Author($name);

            //act
            $test_author->save();

            //assert
            $result = Author::getAll();
            $this->assertEquals($test_author, $result[0]);
        }

        function testGetAll()
        {
            //arrange
            $name = "Donald";
            $id = 1;
            $test_author = new Author($name, $id);
            $test_author->save();

            $name2 = "Duck";
            $id2 = 2;
            $test_author2 = new Author($name2, $id2);
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
            $id = 1;
            $test_author = new Author($name, $id);
            $test_author->save();

            $name2 = "Duck";
            $id2 = 2;
            $test_author2 = new Author($name2, $id2);
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
            $id = 1;
            $test_author = new Author($name, $id);
            $test_author->save();

            $name2 = "Duck";
            $id2 = 2;
            $test_author2 = new Author($name2, $id2);
            $test_author2->save();

            //act
            $id = $test_author->getId();
            $result = Author::find($id);

            //assert
            $this->assertEquals($test_author, $result);
        }

        function testUpdate()
        {
            //arrange
            $id = 1;
            $name = 'Micah';
            $test_author = new Author($name, $id);
            $test_author->save();

            $new_name = 'Marvin';

            //act
            $test_author->update($new_name);

            //assert
            $this->assertEquals("Marvin", $test_author->getName());
        }

        function testDeleteAuthor()
        {
            //arrange
            $id = 1;
            $name = 'Micah';
            $test_author = new Author($name, $id);
            $test_author->save();

            $id2 = 2;
            $name2 = "Duck";
            $test_author2 = new Author($name2, $id2);
            $test_author2->save();

            //act
            $test_author->delete();

            //assert
            $this->assertEquals([$test_author2], Author::getAll());
        }
    }
?>
