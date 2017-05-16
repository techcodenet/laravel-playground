<?php

use App\Stats;
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
