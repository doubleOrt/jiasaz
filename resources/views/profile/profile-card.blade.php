@php
    $user->full_name = $user->first_name . " " . $user->last_name;

    $context = stream_context_create(
    array(
            "http" => array(
                "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
            )
        )
    );

    $location_latitude = $user->location_latitude;
    $location_longitude = $user->location_longitude;
    $user_address_request = json_decode(
        file_get_contents("https://nominatim.openstreetmap.org/reverse?format=json&lat=$location_latitude&lon=$location_longitude&accept-language=en-us", false, $context)
    );
    $user_address = $user_address_request->address;
    $user_country = $user_address->country;
    $user_district = $user_address->district;

    $PROFILE_CARD_TITLE_TEXT_BASED_ON_ROLE = [
        "user" => "Customer",
        "shop_owner" => "Shop Owner",
        "delivery_person" => "Courier",
        "admin" => "Admin"
    ];

    $DEFAULT_PROFILE_IMAGE_PATH = "/images/icon/default-avatar.jpg";
    $PROFILE_IMAGE_PATH = !($user->profile_image_path == "") ? $user->profile_image_path : $DEFAULT_PROFILE_IMAGE_PATH;

@endphp
<div class="card">
        <div class="card-header userProfileCardHeader text-center" data-role="{{$user->role}}">
            <strong class="card-title mb-3">{{ $PROFILE_CARD_TITLE_TEXT_BASED_ON_ROLE[$user->role] }}</strong>
        </div>
        <div class="card-body">
            <div class="mx-auto d-block">
                <div class="row justify-content-center">
                    <div class="profileCardProfileImageContainer my-2" style="background: url('{{$PROFILE_IMAGE_PATH}}');">
                    </div>
                </div>
                <h5 class="text-sm-center mt-2 mb-1">{{ $user->full_name }}</h5>
                <div class="location text-sm-center">
                    <i class="fa fa-map-marker-alt"></i>&nbsp;{{$user_district}}, {{$user_country}}</div>
            </div>
            <hr>
            <div class="card-text text-sm-left">
                <h6 class="font-weight-normal text-secondary">
                    <i class="fa fa-envelope pr-1"></i>&nbsp;{{$user->email}}
                </h6>                
                <h6 class="font-weight-normal text-secondary mt-2">
                    <i class="fa fa-phone pr-1"></i>&nbsp;{{$user->phone_no}}
                </h6>
            </div>
        </div>
    </div>
</div>
