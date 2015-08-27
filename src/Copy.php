<?php

    class Copy
    {
        private $amount;
        private $id;
        private $book_id;

        function __construct($amount, $id=null, $book_id)
        {
            $this->amount = $amount;
            $this->id= $id;
            $this->book_id = $book_id;
        }

        function setAmount($new_amount)
        {
            $this->amount = (string) $new_amount;
        }

        function getAmount()
        {
            return $this->amount;
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
            $GLOBALS['DB']->exec("INSERT INTO copies (amount, book_id) VALUES ({$this->getAmount()}, {$this->getBookId()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies;");
            $copies = array();
            foreach($returned_copies as $copy) {
                $amount = $copy['amount'];
                $id = $copy['id'];
                $book_id = $copy['book_id'];
                $new_copy = new Copy($amount, $id, $book_id);
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
