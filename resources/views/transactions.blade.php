<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
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
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            table, th, td{
                border:1px solid #ccc;
            }
            table{
                border-collapse:collapse;
            }
            tr:hover{
                background-color:#ddd;
                cursor:pointer;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">            
            <div class="content">
                <a href="/">
                    <button>Back</button>
                </a>
                <div class="title m-b-md">
                    Transaction Data
                </div>

                <table>
                    <thead>
                        <th>ID</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Education Level</th>
                        <th>Marital Status</th>
                        <th>Property</th>
                        <th>Income</th>
                        <th>Loan Amount</th>
                        <th>Tenor (Month)</th>
                        <th>Bad Debt</th>
                    </thead>
                    <tbody>
                        @foreach( $transactions as $transaction )
                            <tr>
                                <td>
                                    {{ $transaction->id }}
                                </td>
                                <td>
                                    {{ $transaction->age }}
                                </td>
                                <td>
                                    {{ $transaction->gender }}
                                </td>
                                <td>
                                    {{ $transaction->education }}
                                </td>
                                <td>
                                    {{ $transaction->marriage }}
                                </td>
                                <td>
                                    {{ $transaction->property }}
                                </td>
                                <td>
                                    {{ $transaction->income }}
                                </td>
                                <td>
                                    {{ $transaction->loan_amount }}
                                </td>
                                <td>
                                    {{ $transaction->tenor }}
                                </td>
                                <td>
                                    {{ $transaction->bad_debt }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
