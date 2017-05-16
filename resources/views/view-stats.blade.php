<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

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

            table td {
                padding: 5px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    String
                </div>

                @if ($errors)
                <div style="padding: 15px;">
                    <h1>{{ $errors }}</h1>
                </div>
                @endif

                <form method="get" action="{{ url('/stats') }}">
                    Please enter some text
                    <input type="text" name="string" maxlength="255" value="{{ $string }}"/>
                    <input type="submit" value="submit" />
                </form>
                @if(!empty($stats))
                    <div style="font-weight: bold; color: 000; text-align: left; margin: 20px auto;">
                        <table border="1" style="border-spacing: 0;" align="center">
                          <tr>
                            <td>char</td>
                            <td>cnt</td>
                            <td>before</td>
                            <td>after</td>
                            <td>max-distance</td>
                          </tr>
                          @foreach ($stats as $char => $node)
                            <tr>
                              <td>{{ $char }}</td>
                              <td>{{ $node['count'] }}</td>
                              <td>{{ json_encode( $node['before'] ) }}</td>
                              <td>{{ json_encode( $node['after'] ) }}</td>
                              <td>{{ $node['distance'] }}</td>
                            </tr>
                          @endforeach
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </body>
</html>
