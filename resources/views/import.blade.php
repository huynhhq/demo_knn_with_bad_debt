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
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">            
            <div class="content">
                <a href="/">
                    <button>Back</button>
                </a>
                <div class="title m-b-md">
                    Import Data
                </div>

                <form id="import-form" 
                    class="form-horizontal form-simple steps"                                 
                    action="{{url('/import-transaction')}}"
                    method="post" 
                    accept-charset="UTF-8" 
                    enctype="multipart/form-data" 
                    novalidate="novalidate">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">                    
                    <div class="form-group">
                        <fieldset class="form-group">   
                            <input type="file" 
                                name="file" 
                                class="form-control"
                                required="required" 
                                data-rule-required="true" 
                                data-msg-required="Xin chọn file csv."
                                > 
                            <span id="file-span-error1" class="error1" style="display: none;">
                                <i class="error-log fa fa-exclamation-triangle"></i>                        
                            </span>
                        </fieldset>                                  
                    </div>                                
                    <div class="form-actions right">
                        <button type="submit" name="up" id="up" class="btn btn-primary btn-lg">
                            Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
