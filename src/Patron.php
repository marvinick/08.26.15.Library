 <?php

    class Patron
    {
        private $name;
        private $id;

        function __construct($name, $id=null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO patrons (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons;");
            $patrons = array();

            foreach($returned_patrons as $patron) {
              $name = $patron['name'];
              $id = $patron['id'];
              $new_patron = new Patron ($name, $id);
              array_push($patrons, $new_patron);
            }
            return $patrons;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons;");
        }

        static function find($search_id)
        {
            $found_patron = null;
            $patrons = Patron::getAll();
            foreach($patrons as $patron) {
                $patron_id = $patron->getId();
                if($patron_id == $search_id) {
                    $found_patron = $patron;
                }
            }
            return $found_patron;
        }

        function addCopy($copy)
        {
            $GLOBALS['DB']->exec("INSERT INTO checkouts (patron_id, copy_id) VALUES ({$this->getId()}, {$copy->getId()});");
        }

        function getCopies()
        {
            $patron_id = $this->getId();
            $returned_copies = $GLOBALS['DB']->query("SELECT copies.* FROM patrons JOIN checkouts ON (patrons.id = checkouts.patron_id) JOIN copies ON(checkouts.copy_id = copies.id) WHERE patrons.id = {$patron_id}");

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
    }
  ?>
