<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Copy.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CopyTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Copy::deleteAll();
        }

        function test_getId()
        {
            //arrange
            $count = 1;
            $id = 1;
            $test_Copy = new Copy($count, $id);

            //act
            $result = $test_Copy->getId();

            //assert
            $this->assertEquals(1, $result);
        }

        function test_save()
        {
            //arrange
            $count = 1;
            $test_copy = new Copy($count);

            //act
            $test_copy->save();

            //assert
            $result = Copy::getAll();
            $this->assertEquals($test_copy, $result[0]);
        }

        function test_getAll()
        {
            //arrange
            $count = 1;
            $count2 = 2;
            $test_copy = new Copy($count);
            $test_copy->save();
            $test_copy2 = new Copy($count2);
            $test_copy2->save();

            //act
            $result = Copy::getAll();

            //assert
            $this->assertEquals([$test_copy, $test_copy2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $count = 1;
            $count2 = 2;
            $test_copy = new Copy($count);
            $test_copy->save();
            $test_copy2 = new Copy($count2);
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
            $count = 1;
            $count2 = 2;
            $test_copy = new Copy($count);
            $test_copy->save();
            $test_copy2 = new Copy($count2);
            $test_copy2->save();

            //Act
            $id = $test_copy->getId();
            $result = Copy::find($id);

            //Assert
            $this->assertEquals($test_copy, $result);
        }
    }
?>
