<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\PokerDeck;
use App\RedisDeck;

class BasicTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPokerDeckTest()
    {
        $poker_deck = new PokerDeck();
        $this->dotest($poker_deck);
    }

    public function testRedisDeckTest(){
        $redis_deck = new RedisDeck();
        $this->dotest($redis_deck);
    }

    private function dotest($poker_deck){
        $deck = $poker_deck->deck();

        $this->assertEquals(52, $poker_deck->cards_remaining() );

        for($i=0; $i < 51; $i++){
          $draw         = $poker_deck->draw_card_and_show_chance();
          $cards_before = 52 - $i;
          $cards_now    = 52 - $i - 1;
          $this->assertEquals(
            array(
                'chance_was' => sprintf("%d", 100 * (1/$cards_before) ),
                'chance_now' => sprintf("%d", 100 * (1/$cards_now) ),
                'card'       => array_shift($deck),
                'deck'       => $deck
            ),
            $draw
          );

          $this->assertEquals($cards_now, $poker_deck->cards_remaining() );
        }

        $draw = $poker_deck->draw_card_and_show_chance();

        $this->assertEquals(
          array(
              'chance_was' => 100,
              'chance_now' => 0,
              'card'       => array_shift($deck),
              'deck'       => $deck
          ),
          $draw
        );

        $draw = $poker_deck->draw_card_and_show_chance();

        $this->assertEquals(
          array(
              'chance_was' => 0,
              'chance_now' => 0,
              'card'       => array_shift($deck),
              'deck'       => $deck
          ),
          $draw
        );

        $this->assertEquals(array(), $deck);
    }
}
