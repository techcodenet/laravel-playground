<?php

namespace App;
use Illuminate\Support\Facades\Log;

class PokerDeck
{
    public $deck = array();

    public function sorted_deck(){
        // https://en.wikipedia.org/wiki/Standard_52-card_deck#Rank_and_color
        $card_suits = array('H', 'S', 'D', 'C');
        $card_values = array_merge( range(2, 10), array('A', 'J', 'Q', 'K') );

        $cards = array();

        foreach( $card_suits as $suit ){
            foreach( $card_values as $value ){
                $cards[] = $suit . $value;
            }
        }

        return $cards;
    }

    public function shuffle_deck(){
        $new_deck = $this->sorted_deck();
        shuffle($new_deck);
        $this->deck = $new_deck;
        return $this->deck;
    }

    public function __construct(){
        $new_deck = $this->shuffle_deck();
        $this->deck = $new_deck;
    }

    public function _draw_card(){
        return array_shift( $this->deck );
    }

    public function draw_card_and_show_chance(){
        return array(
            'chance_was'  => $this->chance(),
            'card'        => $this->draw_card(),
            'chance_now'  => $this->chance(),
            'deck'        => $this->deck(),
        );
    }

    public function draw_card(){
        $cnt = $this->cards_remaining();
        if( $cnt > 0 ){
            return $this->_draw_card();
        }
        else {
            // ToDo: Error handling
        }
    }

    public function cards_remaining(){
        return count( $this->deck );
    }

    public function chance(){
        $cards_remaining = $this->cards_remaining();
        if($cards_remaining > 0){
            return sprintf("%d", 100 * (1/$cards_remaining) );
        }
        else {
            // ToDo: Error handling
        }
    }

    public function deck(){
        return $this->deck;
    }
}
