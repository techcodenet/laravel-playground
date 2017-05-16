<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Poker - Game</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    Poker - Game
                </div>

                @if( count($draw['deck']) > 0 )
                  <div class="content" style="margin: 15px;">
                    <b>Remaining cards:</b>
                      @foreach ( $draw['deck'] as $card )
                        @if($card == $wanted_card)
                          <b>{{ $card }}</b>
                        @else
                          {{ $card }}
                        @endif
                      @endforeach
                  </div>
                @endif

                <div class="content" style="margin: 15px; font-size: 125%;">
                  @if($draw['card'])
                    <b>Drawn: {{ $draw['card'] }}</b><br/>
                  @endif

                  @if($draw['card'] == $wanted_card)
                    <h1>Your card showed up! You had {{ $draw['chance_was'] }}% chance!</h1>
                    <div class="links" style="padding-top: 10px;">
                      <a href="{{ url('/new-game') }}">New game</a>
                    </div>
                  @elseif( $draw['chance_now'] == 0 && count($draw['deck']) == 0 )
                    <h1>You've played with URL params - have you?</h1>
                    <div class="links" style="padding-top: 10px;">
                      <a href="{{ url('/new-game') }}">New game</a>
                    </div>
                  @else
                    <div class="links" style="padding-top: 10px;">
                      <b>Chance: {{ $draw['chance_now'] }}%</b>
                      <a href="{{ url('draw-card', array($poker_deck->deck_id(), $wanted_card) ) }}" style="border: 1px solid; padding: 10px; margin: 10px;">
                        <b>Draw next</b>
                      </a>
                    </div>
                  @endif
                </div>

                <div class="content links" style="margin: 25px; border:1px solid; padding: 0px 10px 25px 10px;">
                    <h2>Links</h2>
                    <a href="{{ url('/stats?string=abba') }}">String Stats</a>
                    <a href="{{ url('/new-game') }}">Poker Deck</a>
                </div>
            </div>
        </div>
    </body>
</html>
