<?php

    class Copy
    {
        private $count;
        private $id;

        function __construct($count, $id = null)
        {
            $this->count = $count;
            $this->id = $id;
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

        function save()
        {
              $GLOBALS['DB']->exec("INSERT INTO copies (count) VALUES ('{$this->getCount()}');");
              $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies;");
            $copies = array();
            foreach($returned_copies as $copy) {
                $count = $copy['count'];
                $id = $copy['id'];
                $new_copy = new Copy($count, $id);
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

    }
?>
