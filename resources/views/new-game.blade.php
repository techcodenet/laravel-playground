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
                    Poker - New Game
                </div>

                <div class="content">

                  <form method="get" action="{{ url('/draw-card') }}">
                      <input type="hidden" name="deck_id" value="{{ $poker_deck->deck_id() }}" />
                      <b>Select card (suit and value):</b>
                      <select name="wanted_card">
                        @foreach ( $poker_deck->sorted_deck() as $card )
                          <option value="{{ $card }}">{{ $card }}</option>
                        @endforeach
                      </select>

                      <input type="submit" name="submit">
                  </form>
                </div>
            </div>
            <div class="content links" style="margin: 25px; border:1px solid; padding: 0px 10px 25px 10px;">
                <h2>Links</h2>
                <a href="{{ url('/stats?string=abba') }}">String Stats</a>
                <a href="{{ url('/new-game') }}">Poker Deck</a>
            </div>
        </div>
    </body>
</html>
