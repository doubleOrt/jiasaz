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
                            <form action="/register" method="post">

                                @csrf

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
                                    <input class="au-input au-input--full" type="email" name="email_address" placeholder="Email" required>
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
                                    <label>Retype Password</label>
                                    <input class="au-input au-input--full" type="password" name="retype_password" placeholder="Retype Password" required>
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
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">register</button>
                                <div class="social-login-content">
                                    <div class="social-button">
                                        <button class="au-btn au-btn--block au-btn--blue m-b-20">register with facebook</button>
                                        <button class="au-btn au-btn--block au-btn--blue2">register with twitter</button>
                                    </div>
                                </div>
                            </form>
                            <div class="register-link">
                                <p>
                                    Already have account?
                                    <a href="#">Sign In</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>

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
        
    </script>

@endsection