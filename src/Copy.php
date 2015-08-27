<?php

    class Copy
    {
        private $count;
        private $id;
        private $book_id;

        function __construct($count, $id = null, $book_id)
        {
            $this->count = $count;
            $this->id = $id;
            $this->book_id = $book_id;
        }

        function setCount($new_count)
        {
            $this->count = (string) $new_count;
        }

        function getCount()
        {
            return $this->count;
        }

        function getId()
        {
            return $this->id;
        }

        function getBookId()
        {
            return $this->book_id;
        }

        function save()
        {
              $GLOBALS['DB']->exec("INSERT INTO copies (count, book_id) VALUES ( {$this->getCount()}, {$this->getBookId()} );");
              $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies;");
            $copies = array();
            foreach($returned_copies as $copy) {
                $count = $copy['count'];
                $id = $copy['id'];
                $book_id = $copy['book_id'];
                $new_copy = new Copy($count, $id, $book_id);
                array_push($copies, $new_copy);
            }
            return $copies;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM copies;");
        }

        static function find($search_id)
        {
            $found_copy = null;
            $copies= Copy::getAll();
            foreach($copies as $copy) {
                $copy_id = $copy->getId();
                if ($copy_id == $search_id) {
                    $found_copy = $copy;
                }
            }
            return $found_copy;
        }

        function addPatron($patron)
        {
            $GLOBALS['DB']->exec("INSERT INTO checkouts (patron_id, copy_id) VALUES ({$patron->getId()}, {$this->getId()});");
        }

        function getPatrons()
        {
            $copy_id = $this->getId();
            $returned_patrons = $GLOBALS['DB']->query("SELECT patrons.* FROM copies JOIN checkouts ON (copies.id = checkouts.copy_id) JOIN patrons ON(checkouts.patron_id = patrons.id) WHERE copies.id = {$copy_id}");

            $patrons = array();
            foreach($returned_patrons as $patron) {
                $name = $patron['name'];
                $id = $patron['id'];
                $new_patron = new Patron($name, $id);
                array_push($patrons, $new_patron);
            }
            return $patrons;
        }

    }
?>
