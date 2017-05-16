<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Stats;

class StatsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    public function testStatsABC(){
        $stats = new Stats();

        $str_array  = str_split( "abc" );

        foreach($str_array as $char){
            $stats->add_letter($char);
        }

        $this->assertEquals(
            array(
                'a' => [
                    'before' => ['b'],
                    'after' => [],
                    'count' => 1,
                    'distance' => 0,
                ],
                'b' => [
                    'before' => ['c'],
                    'after' => ['a'],
                    'count' => 1,
                    'distance' => 0,
                ],
                'c' => [
                    'before' => [],
                    'after' => ['b'],
                    'count' => 1,
                    'distance' => 0,
                ]
            ),
            $stats->dump()
        );
    }

    public function testStatsABBA(){
        $stats = new Stats();

        $str_array  = str_split( "abba" );

        foreach($str_array as $char){
            $stats->add_letter($char);
        }

        $this->assertEquals(
            array(
                'a' => [
                    'before' => ['b'],
                    'after' => ['b'],
                    'count' => 2,
                    'distance' => 3,
                ],
                'b' => [
                    'before' => ['b', 'a'],
                    'after' => ['a', 'b'],
                    'count' => 2,
                    'distance' => 1,
                ],
            ),
            $stats->dump()
        );
    }

    public function testStatsFootball(){
        $stats = new Stats();

        $str_array  = str_split( "football" );

        foreach($str_array as $char){
            $stats->add_letter($char);
        }

        $this->assertEquals(
            array(
                'f' => [
                    'before' => ['o'],
                    'after' => [],
                    'count' => 1,
                    'distance' => 0,
                ],
                'o' => [
                    'before' => ['o', 't'],
                    'after' => ['f', 'o'],
                    'count' => 2,
                    'distance' => 1,
                ],
                't' => [
                    'before' => ['b'],
                    'after' => ['o'],
                    'count' => 1,
                    'distance' => 0,
                ],
                'b' => [
                    'before' => ['a'],
                    'after' => ['t'],
                    'count' => 1,
                    'distance' => 0,
                ],
                'a' => [
                    'before' => ['l'],
                    'after' => ['b'],
                    'count' => 1,
                    'distance' => 0,
                ],
                'l' => [
                    'before' => ['l'],
                    'after' => ['a', 'l'],
                    'count' => 2,
                    'distance' => 1,
                ],
            ),
            $stats->dump()
        );
    }

    public function testStatsSpaces(){
        $stats = new Stats();

        $str_array  = str_split( "ab ba" );

        foreach($str_array as $char){
            $stats->add_letter($char);
        }

        $this->assertEquals(
            array(
                ' ' => [
                    'before'    => ['b'],
                    'after'     => ['b'],
                    'count'     => 1,
                    'distance'  => 0,
                ],
                'a' => [
                    'before'    => ['b'],
                    'after'     => ['b'],
                    'count'     => 2,
                    'distance'  => 4,
                ],
                'b' => [
                    'before'    => [' ', 'a'],
                    'after'     => ['a', ' '],
                    'count'     => 2,
                    'distance'  => 2,
                ],
            ),
            $stats->dump()
        );
    }

    public function testStatsABCConstructor(){
        $stats = new Stats("abc");

        $this->assertEquals(
            array(
                'a' => [
                    'before' => ['b'],
                    'after' => [],
                    'count' => 1,
                    'distance' => 0,
                ],
                'b' => [
                    'before' => ['c'],
                    'after' => ['a'],
                    'count' => 1,
                    'distance' => 0,
                ],
                'c' => [
                    'before' => [],
                    'after' => ['b'],
                    'count' => 1,
                    'distance' => 0,
                ]
            ),
            $stats->dump()
        );
    }

}
