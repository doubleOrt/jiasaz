@php


    $user = auth()->user();
    $user->full_name = $user->first_name . " " . $user->last_name;

    $NAVBAR_SEARCH_PLACEHOLDER_TEXT = "Search for items...";

    
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="au theme template">
        <meta name="author" content="Jiasaz">
        <meta name="keywords" content="au theme template">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Title Page-->
        <title>@yield("page_title", "Jiasaz")</title>
        
        <link rel="icon" type="image/x-icon" href="/images/icon/logo-mini.png">

        <!-- Styles ^^^ Breeze -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts ^^^ Breeze -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fontfaces CSS-->
        <link href="/css/font-face.css" rel="stylesheet" media="all">
        <link href="/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
        <link href="/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
        <link href="/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

        
        <!-- Bootstrap CSS-->
        <link href="/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

            
        <!-- Vendor CSS-->
        <link href="/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
        <link href="/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
        <link href="/vendor/wow/animate.css" rel="stylesheet" media="all">
        <link href="/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
        <link href="/vendor/slick/slick.css" rel="stylesheet" media="all">
        <link href="/vendor/select2/select2.min.css" rel="stylesheet" media="all">
        <link href="/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

        <!-- Main CSS-->
        <link href="/css/theme.css" rel="stylesheet" media="all">

        <!-- Jquery JS-->
        <script src="/vendor/jquery-3.2.1.min.js"></script>
        <!-- Bootstrap JS-->
        <script src="/vendor/bootstrap-4.1/popper.min.js"></script>
        <script src="/vendor/bootstrap-4.1/bootstrap.min.js"></script>
        <!-- Vendor JS       -->
        <script src="/vendor/slick/slick.min.js">
        </script>
        <script src="/vendor/wow/wow.min.js"></script>
        <script src="/vendor/animsition/animsition.min.js"></script>
        <script src="/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
        </script>
        <script src="/vendor/counter-up/jquery.waypoints.min.js"></script>
        <script src="/vendor/counter-up/jquery.counterup.min.js">
        </script>
        <script src="/vendor/circle-progress/circle-progress.min.js"></script>
        <script src="/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
        <script src="/vendor/chartjs/Chart.bundle.min.js"></script>
        <script src="/vendor/select2/select2.min.js">
        </script>

        <!-- required otherwise laravel doesn't validate jquery ajax requests due to CSRF suspicions -->
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>

        <style>
            .fixedPositionAlert {
                position: fixed;
                left: 50%;
                bottom: 10px;
                transform: translate(-50%, 0);
            }

            .itemCategory a {
                color: white;
            }

            .itemCategory {
                transform: translate(0, 0);
                transition: transform .1s ease-out;
            }

            .itemCategory:hover {
                transform: translate(1px, 0);
            }

            .itemCard .card-text {
                line-height: 1.4;
                font-size: 90%;
            }

            .ordersTable0ItemDescription {
                font-size: 70% !important;
            }
/*
            .userProfileCardHeader[data-role|="user"] {
                background-color: #007bff;
                color: white;
            }

            .userProfileCardHeader[data-role|="shop_owner"] {
                background-color: #ffc107;
                color: white;
            }

            .userProfileCardHeader[data-role|="delivery_person"] {
                background-color: #28a745;
                color: white;
            } */

            .allowHorizontalScroll {
                overflow-x: scroll !important;
            }

            .itemCardImageContainer {
                max-height: 200px; 
                overflow: hidden;
            }

        </style>

    </head>
    <body class="animsition">
        
        @switch($user->role)
        @case("user")
            @include("navigation.navigation-user")
            @break
    
        @case("shop_owner")
            @include("navigation.navigation-shop-owner")
            @break
    
        @default
            @include("navigation.navigation-user")
        @endswitch
        

        
        <div id="fixedPositionAlertSuccess" class="fixedPositionAlert sufee-alert alert with-close alert-success alert-dismissible fade">
            <span class="badge badge-pill badge-success">Success</span>
            <span class="alertText"></span>
        </div>

        <div id="fixedPositionAlertDanger" class="fixedPositionAlert sufee-alert alert with-close alert-danger alert-dismissible fade">
            <span class="badge badge-pill badge-danger">Failure</span>
            <span class="alertText"></span>
        </div>

        <script>

        function getAddressFromCoordinates(latitude, longitude) {
            const reverseGeocodingRequest = "https://nominatim.openstreetmap.org/reverse?format=json&lat={{ $user->location_latitude }}&lon={{ $user->location_longitude }}";
            $.get(reverseGeocodingRequest, function(data, status){
                alert(data["address"]["city"]);
            });
        }

        function showFixedPositionAlert(alertType = "success", text) {
            let alertId = "fixedPositionAlertSuccess";
            if (alertType == "success") {
                alertId = "fixedPositionAlertSuccess";
            } else if (alertType == "danger") {
                alertId = "fixedPositionAlertDanger";
            } else {
                console.warn("Please provide a correct value for the 'alertType' parameter");
                return -1;
            }

            const alertElement = $("#" + alertId);                      
            alertElement.find(".alertText").text(text);
            alertElement.addClass("show");
            setTimeout(function(){
                alertElement.removeClass("show");
            }, 4000);
        }

        </script>

         <!-- Main JS-->
        <script src="/js/main.js"></script>

    </body>
</html>
