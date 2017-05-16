<?php

use App\Stats;
use App\RedisDeck;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\MessageBag;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::get('/stats', function(){
    $rules = array(
        'string' => 'required|min:1|max:255'
    );
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
        // get the error messages from the validator
        $messages = $validator->messages();

        return View::make(
            'view-stats',
            array(
                'string'    => "",
                'stats'     => [],
                'errors'    => $messages->first('string'),
            )
        );

    }
    else {
        $string = Input::get('string');
        $stats = new Stats( $string );
        return View::make(
            'view-stats',
            array(
                'string'    => $string,
                'stats'     => $stats->dump(),
                'errors'    => '',
            )
        );
    }
});

Route::get('/new-game', function () {
    $poker_deck = new RedisDeck();

    return View::make('new-game',
        array(
            'poker_deck' => $poker_deck,
        )
    );
});

/*

    Laravel docs and Stackoverflow were mentioning something with [C]ontroller and
    such - however this hack with two Routes worked and I didn't want to spend
    more time on figuring out other/better/proper way ;)

*/
Route::get('/draw-card', function() {
    /*
        This one handles normal GET FORM stuff like: /draw-card?deck_id=XX&wanted_card=YY
        and redirects request to /draw-card/XX/YY (below named 'draw-card')
    */
    $deck_id = Input::get('deck_id');
    $wanted_card = Input::get('wanted_card');
    return redirect()->route('draw-card', ['deck_id' => $deck_id, 'wanted_card' => $wanted_card]);
});

Route::get('/draw-card/{deck_id}/{wanted_card}', function($deck_id, $wanted_card){
    $poker_deck = new RedisDeck( $deck_id );
    return View::make('draw-card',
        array(
            'poker_deck'  => $poker_deck,
            'draw'        => $poker_deck->draw_card_and_show_chance(),
            'wanted_card' => $wanted_card,
        )
    );
})
->where(array('deck_id' => '[0-9]+', 'wanted_card' => '[0-9A-Z]+'))
->name('draw-card');
