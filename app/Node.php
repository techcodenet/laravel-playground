<?php

namespace App;

class Node
{
    private $letter     = '';
    private $before     = [];
    private $after      = [];
    private $min_index  = 0;
    private $max_index  = 0;
    private $count      = 0;

    public function __construct($letter, $previous='', $index=0){
        $this->letter       = $letter;
        $this->min_index    = $index;

        $this->seen($previous, $index);
    }

    public function seen($previous='', $index=0){
        if(!empty($previous)){
            $this->after[] = $previous;
        }

        $this->max_index = $index;

        $this->count++;
    }

    public function youre_before($char){
        $this->before[] = $char;
    }

    public function dump(){
        return [
            'before'    => $this->before,
            'after'     => $this->after,
            'count'     => $this->count,
            'distance'  => $this->max_distance()
        ];
    }

    public function letter(){
        return $this->letter;
    }

    public function before(){
        return $this->before;
    }

    public function after(){
        $this->after;
    }

    public function count(){
        return $this->count;
    }

    public function max_distance(){
        return $this->max_index - $this->min_index;
    }
}
