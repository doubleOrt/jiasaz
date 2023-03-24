@php
    $DEFAULT_PROFILE_IMAGE_PATH = "/images/icon/default-avatar.jpg";

    $MAP_MODAL_ID = "mapModal";
    $DELETE_USER_MODAL_ID = "deleteUserModal";
@endphp
<tr data-user-id="{{$user->id}}">
    <td>{{$user->id}}</td>
    <td class="userFirstName" contenteditable="true">{{$user->first_name}}</td>
    <td class="userLastName" contenteditable="true">{{$user->last_name}}</td>
    <td>
        <span class="block-email smallBlock">
            Email: 
            <strong class="userEmail" contenteditable="true">
                {{$user->email}}
            </strong>
        </span>
        <span class="block-email smallBlock">
            Email Verified: 
                <input class="userEmailVerified" type="checkbox" name="email_verified" {{$user->email_verified_at ? "checked" : ""}} data-original-value="{{$user->email_verified_at ? "true" : "false"}}" />
        </span>
        <span class="block-email smallBlock mt-1">
            Phone: 
            <strong class="userPhoneNo" contenteditable="true">
                {{$user->phone_no}}
            </strong>
        </span>
    </td>
    <td><input class="userPassword" type="password" name="password" placeholder="New Password..."/></td>
    <td>
        <label for="updateUserImageInput{{$user->id}}">
            <img class="imageWithHoverAndActiveEffects userImage" src="{{$user->profile_image_path ? $user->profile_image_path : $DEFAULT_PROFILE_IMAGE_PATH}}" alt="Profile Image" width="100px" draggable="false" />
        </label>
        <input type="file" style="display:none" id="updateUserImageInput{{$user->id}}" class="updateUserImageInput" name="profile_image_path" />
    </td>
    <td>
        <span class="block-email smallBlock">
            Lat: 
            <strong class="usersTableLocationLatitude" contenteditable="true">
                {{$user->location_latitude}}
            </strong>
        </span>
        <br />
        <span class="block-email smallBlock mt-1">
            Long: 
            <strong class="usersTableLocationLongitude" contenteditable="true">
                {{$user->location_longitude}}
            </strong>
        </span>
        <br />
        <button class="btn btn-sm btn-warning showLocationOnMap mt-1" data-toggle="modal" data-target="#{{$MAP_MODAL_ID}}" data-location-latitude="{{$user->location_latitude}}" data-location-longitude="{{$user->location_longitude}}">
            <i class="fas fa-map-marker-alt"></i>
        </button>
    </td>
    <td>
        <select class="tablesSelectInputs updateUserRoleSelectInput" class="form-control">
            @foreach($roles as $role)
                <option value="{{$role->id}}" {{$user->hasRole($role->name) ? "selected" : ""}}>{{$role->name}}</option>
            @endforeach
        </select>
    </td>
    <td>
        <span class="block-email smallBlock">
            Created: 
            <strong>
                {{$user->created_at}}
            </strong>
        </span>
        <br />
        <span class="block-email smallBlock mt-1">
            Updated: 
            <strong>
                {{$user->updated_at}}
            </strong>
        </span>
    </td>
    <td>
        @if($user->hasRole("customer"))
            <span class="block-email smallBlock">
                No. Orders: 
                <strong>
                    {{$user->orders->count()}}
                </strong>
            </span>
        @elseif($user->hasRole("shop_owner"))
            <span class="block-email smallBlock">
                No. Orders To: 
                <strong>
                    {{$user->shop_orders->count()}}
                </strong>
            </span>
            <a href="/user-items/{{$user->id}}">
                <span class="block-email smallBlock mt-1">
                        No. Items: 
                        <strong>
                            {{$user->items->count()}}
                        </strong>
                </span>        
            </a>   
        @elseif($user->hasRole("delivery_person"))
            <span class="block-email smallBlock">
                No. Deliveries: 
                <strong>
                    {{$user->deliveries->count()}}
                </strong>
            </span>
        @endif
    </td>
    <td>
        <button type="submit" class="btn btn-primary btn-sm updateUserSaveButton">
            <i class="fa fa-save"></i> &nbsp;Save
        </button>
        <br />
        <button type="submit" class="btn btn-danger btn-sm mt-1 userDeleteButton" data-toggle="modal" data-target="#{{$DELETE_USER_MODAL_ID}}">
            <i class="fa fa-trash"></i> &nbsp;Delete
        </button>
    </td>

</tr>