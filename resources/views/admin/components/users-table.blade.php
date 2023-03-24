
@php
    $ADMIN_UPDATE_USER_ROUTE = "/admin-update-user-account";
    $ADMIN_DELETE_USER_ROUTE = "/admin-delete-user";
@endphp

<div class="row justify-content-center mt-3 px-4">
    <div class="col-md-12">
        <!-- DATA TABLE-->
        <div class="table-responsive">
            <div class='row tableControlsContainerRow'>
                <div class="col col-md-6 tableControlsLengthContainer"></div>
                <div class="col col-md-6 text-right tableControlsFilterContainer"></div>
            </div>
            <table id="adminViewUsersTable" class="table table-borderless table-data3 tableHoverableHeadings">
                <thead>
                    <tr>
                        <th><small>ID</small></th>
                        <th><small>First Name</small></th>
                        <th><small>Last Name</small></th>
                        <th><small>Contact Info</small></th>
                        <th><small>Password</small></th>
                        <th><small>Profile Image</small></th>
                        <th><small>Location</small></th>
                        <th><small>Role</small></th>
                        <th><small>Date Info</small></th>
                        <th><small>Info</small></th>
                        <th><small>Actions</small></th>
                    </tr>
                </thead>
                <tbody>
                    {{ $users_rows }}
                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE-->
    </div>
</div>

@include("admin.components.delete-user-modal");

<script>
    $(document).ready( function () {
        $('#adminViewUsersTable').DataTable();
        const controlsContainerRow = $("#adminViewUsersTable")
            .closest(".table-responsive")
            .find(".tableControlsContainerRow");
        $(controlsContainerRow)
            .find(".tableControlsLengthContainer")
            .append($("#adminViewUsersTable_length"));
        $(controlsContainerRow)
            .find(".tableControlsFilterContainer")
            .append($("#adminViewUsersTable_filter"));
    });

    // show image preview when image is uploaded
    $(".updateUserImageInput").change(function(e) {
        const file = e.target.files[0];
        if (file) {
            $(this).closest("td").find(".userImage").attr("src", URL.createObjectURL(file));
        }
    });

    $(".updateUserSaveButton").click(function(e) {
        e.preventDefault();
        const trElement = $(this).closest("tr");
        const userId = $(trElement).attr("data-user-id");
        const userFirstName = $(trElement).find(".userFirstName").text();
        const userLastName = $(trElement).find(".userLastName").text();
        const userEmail = $(trElement).find(".userEmail").text();
        const userEmailVerified = $(trElement).find(".userEmailVerified").is(":checked");
        const userEmailVerifiedOriginalValue = ($(trElement).find(".userEmailVerified").attr("data-original-value") === 'true');

        const userPhoneNo = $(trElement).find(".userPhoneNo").text();
        const userPassword = $(trElement).find(".userPassword").val();

        const locationLatitude = $(trElement).find(".usersTableLocationLatitude").text();
        const locationLongitude = $(trElement).find(".usersTableLocationLongitude").text();

        const userImage = $(trElement).find(".updateUserImageInput").prop("files")[0];

        const userRole = $(trElement).find(".updateUserRoleSelectInput").val();

        /* You have to use a form element to pass the data to ajax otherwise no data will be
        * sent because of the "contentType" and "processData" being set to "false" (having either
        * prevents data from being sent). We need to have those as "false" though in order to 
        * send a file asynchronously.
        *  */
        const formData = new FormData();
        formData.append("user_id", userId);
        formData.append("first_name", userFirstName);
        formData.append("last_name", userLastName);
        formData.append("email", userEmail);
        formData.append("phone_no", userPhoneNo);
        formData.append("location_latitude", locationLatitude);
        formData.append("location_longitude", locationLongitude);


        if (userEmailVerified != userEmailVerifiedOriginalValue) {
            formData.append("email_verified", userEmailVerified);
        }

        if (userPassword) {
            formData.append("password", userPassword);
        }
        if (userImage) {
            formData.append("profile_image", userImage);
        }

        $.ajax({
            "url": "{{$ADMIN_UPDATE_USER_ROUTE}}",
            "type": "post",
            "data": formData,
            processData: false,
            contentType: false,
        })
        .done(function(msg) {
            showFixedPositionAlert("success", msg);
            /* update the element's original value so that we don't send the new value again and 
            * again if user makes new changes without altering this field
            */
            $(trElement).find(".userEmailVerified").attr("data-original-value", userEmailVerified)
        })
        .fail(function(xhr, status, err) {
            const response = jQuery.parseJSON(xhr["responseText"]);
            const message = response["message"];
            console.warn(response);
            showFixedPositionAlert("danger", "Failed to update user account: " + message);
        });
    });

    $(".userDeleteButton").click(function(e){
        const userId = $(this).closest("tr").attr("data-user-id");
        $("#deleteUserModal").find(".deleteUserModalTextUserId").text(userId);
        $("#deleteUserModal").find(".deleteUserModalDeleteButton").attr("data-user-id", userId);
    });

    $(".deleteUserModalDeleteButton").click(function(e) {
        const userId = $(this).attr("data-user-id");
        $.post(
            "{{$ADMIN_DELETE_USER_ROUTE}}",
            {
                "user_id": userId, 
            }
            )
            .done(function(msg) {
                console.log(msg);
                showFixedPositionAlert("success", msg);
                $("#deleteUserModal").modal("hide");
            })
            .fail(function(xhr, status, err) {
                const response = jQuery.parseJSON(xhr["responseText"]);
                const message = response["message"];
                console.warn(response);
                showFixedPositionAlert("danger", "Failed to delete user: " + message);
            });
    });

</script>