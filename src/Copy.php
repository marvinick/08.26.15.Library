<?php

    class Copy
    {
        private $count;
        // private $id;

        function __construct($count)
        {
            $this->count = $count;
            // $this->id = $id;
        }

        function setCount($new_count)
        {
            $this->count = (string) $new_count;
        }

        function getCount()
        {
            return $this->count;
        }

        function save()
        {
              $GLOBALS['DB']->exec("INSERT INTO copies (count) VALUES ('{$this->getCount()}');");
        }

        static function getAll()
        {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies;");
            $copies = array();
            foreach($returned_copies as $copy) {
                $count = $copy['count'];
                $new_copy = new Copy($count);
                array_push($copies, $new_copy);
            }
            return $copies;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM copies;");
        }

    }
?>
