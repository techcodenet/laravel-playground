<?php

namespace App;

use App\Node;

class Stats {
    // There's "C like" array in PHP of fixed size - that no one seems to use?!?
    protected $letters           = [];
    protected $previous_letter   = '';
    protected $letter_count      = 0;

    public function __construct($string=''){
        if(!empty($string)){
            $str_array  = str_split( $string );

            foreach($str_array as $char){
                $this->add_letter($char);
            }
        }
    }

    public function add_letter($char){
        if(!isset($this->letters[$char])){
            $this->letters[$char] = new Node( $char, $this->previous_letter, $this->letter_count );
        }
        else {
            $this->letters[$char]->seen($this->previous_letter, $this->letter_count);
        }

        if(!empty($this->previous_letter)){
            $this->letters[$this->previous_letter]->youre_before($char);
        }

        $this->previous_letter = $char;
        $this->letter_count++;
    }

    public function dump(){
        $out = [];
        foreach($this->letters as $letter){
            $out[$letter->letter()] = $letter->dump();
        }
        return $out;
    }

    /*

        http://stackoverflow.com/questions/203336/creating-the-singleton-design-pattern-in-php5



    /**
     * Call this method to get singleton
     *
    public static function instance(){
        static $instance = false;
        if( $instance === false ){
            // Late static binding (PHP 5.3+)
            $instance = new static();
        }
        return $instance;
    }

     /**
      * Make constructor private, so nobody can call "new Class".
      *
    private function __construct() {}

     /**
      * Make clone magic method private, so nobody can clone instance.
      *
    private function __clone() {}

     /**
      * Make sleep magic method private, so nobody can serialize instance.
      *
    private function __sleep() {}

     /**
      * Make wakeup magic method private, so nobody can unserialize instance.
      *
    private function __wakeup() {}
*/
}
