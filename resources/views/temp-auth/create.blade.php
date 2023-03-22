@extends("layouts.app-min")

@section("page_title")
Register
@endsection

@section("content")
    <div class="page-wrapper">
        <!-- Need to add this style attribute manually otherwise user cannot vertically scroll the page enough -->
        <div class="page-content--bge5" style="height: auto;">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="{{ $WEBSITE_LOGO_IMAGE_PATH }}" alt="CoolAdmin">
                            </a>
                        </div>
                        <div class="login-form">

                                                    <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-4" :errors="$errors" />
                            
                            <ul class="nav nav-pills justify-content-center mb-3 mt-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active show" id="pills-register-as-customer" data-toggle="pill" href="#" role="tab" aria-controls="pills-customer" aria-selected="true">Customer</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-register-as-delivery-person" data-toggle="pill" href="#" role="tab" aria-controls="pills-delivery" aria-selected="false">Delivery</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-register-as-shop-owner" data-toggle="pill" href="#" role="tab" aria-controls="pills-shop" aria-selected="false">Shop Owner</a>
                                </li>
							</ul>
                            <h4 id="registrationFormHeading" class="text-secondary text-center mb-5">Register as <span class="text-primary">customer...</span></h4>
                            <form action="{{ route('register') }}" method="post">

                                @csrf

                                <input id="registrationFormRoleInput" type="hidden" name="role" value=""/>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input class="au-input au-input--full" type="text" name="first_name" placeholder="First Name" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input class="au-input au-input--full" type="text" name="last_name" placeholder="Last Name" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="au-input au-input--full" type="email" name="email" placeholder="Email" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input class="au-input au-input--full" type="tel" name="phone_no" pattern="[7][0-9]{2}-[0-9]{3}-[0-9]{4}" placeholder="Phone No" required>
                                    <small class="form-text text-muted">(Format: 75*-***-****)</small>
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="au-input au-input--full" type="password" name="password" placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input class="au-input au-input--full" type="password" name="password_confirmation" placeholder="Confirm Password" required>
                                    <small class="form-text text-muted">(Password you entered previously)</small>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <button id="registrationGetLocationButton" class="au-btn au-btn--block au-btn--blue m-b-20" type="button">Get Location</button>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <input id="registrationLocationInput" class="au-input au-input--full" type="text" name="location" placeholder="Location..." required>
                                            <small class="form-text text-muted">(Latitude and Longitude)</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="login-checkbox">
                                    <label>
                                        <input type="checkbox" name="aggree">Agree the terms and policy
                                    </label>
                                </div>
                                <button class="au-btn au-btn--block au-btn--blue m-b-20" type="submit">register</button>
                            </form>
                            <div class="register-link">
                                <p>
                                    Already have account?
                                    <a href="{{ route('login') }}">Sign In</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>

        // this handles the location input

        function showPosition(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            $("#registrationLocationInput").val(latitude + "," + longitude);
        }

        $("#registrationGetLocationButton").click(function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                 alert("Geolocation is not supported by this browser.");
            }
        });


        // this handles the role selection 

        const REGISTRATION_FORM = {
            ROLE_NAMES: {
                "customer": "user",
                "delivery": "delivery_person",
                "shop": "shop_owner",
            },
        };

        const ROLE_NAMES = REGISTRATION_FORM["ROLE_NAMES"];

        // set the default value for the hidden role input
        $("#registrationFormRoleInput").val(ROLE_NAMES["customer"]);

        // changes the name of the blue text within the form heading
        function changeRegistrationFormText(newText) {
            $("#registrationFormHeading span").text(newText)
        }

        $("#pills-register-as-customer").click(function() {
            changeRegistrationFormText("customer...");
            $("#registrationFormRoleInput").val(ROLE_NAMES["customer"]);
        });
        
        $("#pills-register-as-delivery-person").click(function() {
            changeRegistrationFormText("delivery...");
            $("#registrationFormRoleInput").val(ROLE_NAMES["delivery"]);
        });
                
        $("#pills-register-as-shop-owner").click(function() {
            changeRegistrationFormText("shop...");
            $("#registrationFormRoleInput").val(ROLE_NAMES["shop"]);
        });

    </script>

@endsection