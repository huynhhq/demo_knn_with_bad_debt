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
                    New Transaction
                </div>

                <form id="import-form" 
                    class="form-horizontal form-simple steps"                                 
                    action="{{url('/add-transaction')}}"
                    method="post" 
                    accept-charset="UTF-8" 
                    enctype="multipart/form-data" 
                    novalidate="novalidate">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">                    
                    <div class="form-group">
                        <fieldset class="form-group">   
                            <label>Age</label>
                            <input type="number" name="age" class="form-control">
                        </fieldset>                                  
                    </div>                                
                    <div class="form-group">
                        <fieldset class="form-group">   
                            <label>Gender</label>
                            <select name="sl-gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </fieldset>                                  
                    </div>                                
                    <div class="form-group">
                        <fieldset class="form-group">   
                            <label>Education Level</label>
                            <select name="sl-education">
                                <option value="University">University</option>
                                <option value="Junior colleges">Junior colleges</option>
                                <option value="High school">High school</option>
                                <option value="Junior high school">Junior high school</option>
                            </select>
                        </fieldset>                                  
                    </div>                                
                    <div class="form-group">
                        <fieldset class="form-group">   
                            <label>Marital Status</label>
                            <select name="sl-marriage">
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>                                
                            </select>
                        </fieldset>                                  
                    </div>                                
                    <div class="form-group">
                        <fieldset class="form-group">   
                            <label>Property</label>
                            <select name="sl-property">
                                <option value="Stay with parents">Stay with parents</option>
                                <option value="Own house">Own house</option>
                                <option value="Rent house">Rent house</option>                                
                            </select>
                        </fieldset>                                  
                    </div>   
                    <div class="form-group">
                        <fieldset class="form-group">   
                            <label>Income</label>
                            <input type="number" name="income" class="form-control">
                        </fieldset>                                  
                    </div>                             
                    <div class="form-group">
                        <fieldset class="form-group">   
                            <label>Loan Amount</label>
                            <input type="number" name="loan_amount" class="form-control">
                        </fieldset>                                  
                    </div>                             
                    <div class="form-group">
                        <fieldset class="form-group">   
                            <label>Tenor (Month)</label>
                            <input type="number" name="tenor" class="form-control">
                        </fieldset>                                  
                    </div>                             
                    <div class="form-group">
                        <fieldset class="form-group">   
                            <label>Coefficient K</label>
                            <input type="number" name="k_number" class="form-control">
                        </fieldset>                                  
                    </div>                             
                    <div class="form-actions right">
                        <button type="submit" name="up" id="up" class="btn btn-primary btn-lg">
                            Input
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
