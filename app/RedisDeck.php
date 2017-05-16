<?php

namespace App;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class RedisDeck extends PokerDeck
{

    private $deck_id = 0;
    private $redis_deck_name = "RedisDeck_0";
    private $redis_lua_sha1;

    private function next_deck_id(){
        /*

            In production we would use something like https://github.com/nlenepveu/Skip32
            or https://laravel.com/docs/4.2/security#encryption so IDs are not sequential
            and easy to guess by 3rd parties...

        */
        $new_deck_id = Redis::incr("next_PokerDeck_id");

        if($new_deck_id > 10){
            /*

                ToDo: Properly handle limiting and expiring stuff we put into Redis ...
                For now we're just recycle 10 id's

            */
            Redis::set("next_PokerDeck_id", 1);
            return 1;
        }
        else {
            return $new_deck_id;
        }
    }

    public function deck_id(){
        return $this->deck_id;
    }

    private function lua_script_load(){
        /*

          We should call/load this script once (during deploy/roll-out)

        */
        $lua_draw_card = <<<LUA_DRAW_CARD
            -- # draw_card_and_show_chance
            -- # KEYS[1] redis_deck_name (eg: RedisDeck_1)
            local function ToInteger(number)
              return math.floor(tonumber(number) or error("Could not cast '" .. tostring(number) .. "' to number.'"))
            end

            local deck           = assert(KEYS[1], "redis_deck_name missing")
            local count_before   = redis.call('llen', deck)

            if count_before <= 0 then
              return cjson.encode( {['chance_was']=0, ['chance_now']=0, ['card']='', ['deck']={}} )
            end

            local card           = redis.call('lpop', deck)
            local count_after    = redis.call('llen', deck)
            local deck           = redis.call('lrange', deck, 0, -1)

            local chance_was  = count_before > 0 and ToInteger( 1 / count_before * 100 ) or 0
            local chance_now  = count_after > 0 and ToInteger( 1 / count_after * 100 ) or 0

            local result = {['chance_was']=chance_was, ['chance_now']=chance_now, ['card']=card, ['deck']=deck}
            return cjson.encode( result )
LUA_DRAW_CARD;

        $this->redis_lua_sha1 = Redis::script("load", $lua_draw_card);
    }

    public function draw_card_and_show_chance(){
        /*

            While something like this also works (in fact that's what I used at first):
            return array(
              'chance_was'  => $this->chance(),
              'card'        => $this->draw_card(),
              'chance_now'  => $this->chance(),
              'deck'        => $this->deck(),
            );

            Due to possible concurrency problems you might get inconsistent values for
            chance_was and chance_now (or try to go past your selected card) if there's
            multiple/parallel requests/process working on the same deck_id.

            So I've moved logic into a LUA script within Redis that makes this as one
            atomic operation.

        */
        if($this->redis_lua_sha1 == ""){
            $this->lua_script_load();
        }
        $result_json = Redis::evalSha( $this->redis_lua_sha1, 1, $this->redis_deck_name );
        return json_decode( $result_json, true );
    }

    private function deck_to_redis(){
        // Make sure there's nothing under that deck_id from some earlier game
        Redis::del( $this->redis_deck_name );
        foreach ($this->deck as $card) {
            Redis::lpush($this->redis_deck_name, $card);
        }
    }

    public function cards_remaining(){
        return Redis::llen($this->redis_deck_name);
    }

    public function _draw_card(){
        /*

            While this works in the same way as for parent (PokerDeck) class:
            return Redis::lpop($this->redis_deck_name);

            We're taking care of that within draw_card_and_show_chance()

        */
        throw new Exception("You're not meant to call draw_card() on RedisDeck instance");
    }

    public function deck(){
        return Redis::lrange($this->redis_deck_name, 0, -1);
    }

    public function __construct($existing_deck_id = 0){
        if($existing_deck_id > 0){
            $this->deck_id = $existing_deck_id;
        }
        else {
            $this->deck_id = $this->next_deck_id();
        }

        $this->redis_deck_name = "RedisDeck_" . $this->deck_id;

        if($existing_deck_id == 0){
            $this->shuffle_deck();
            $this->deck_to_redis();
        }
    }
}
