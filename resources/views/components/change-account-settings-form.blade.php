<div class="card-header">
    <strong>Edit Account</strong>
    </div>
    <div class="card-body card-block">
        <form action="/update-account" method="post" enctype="multipart/form-data" id="changeAccountSettingsForm" class="form-horizontal">
           @csrf

           <div class="row form-group">
                <div class="col col-md-3">
                    <label for="first-name-input" class="form-control-label">First Name</label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="text" id="first-name-input" name="first_name" value="{{$user->first_name}}" placeholder="First Name..." class="form-control">
                </div>
            </div>

            <div class="row form-group">
                <div class="col col-md-3">
                    <label for="last-name-input" class="form-control-label">Last Name</label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="text" id="last-name-input" name="last_name" value="{{$user->last_name}}" placeholder="Last Name..." class="form-control">
                </div>
            </div>

            <div class="row form-group">
                <div class="col col-md-3">
                    <label for="email-input" class="form-control-label">Email Address</label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="text" id="email-input" name="email" value="{{$user->email}}" placeholder="Email Address..." class="form-control">
                </div>
            </div>

            <div class="row form-group">
                <div class="col col-md-3">
                    <label for="phone-no-input" class="form-control-label">Phone No:</label>
                </div>
                <div class="col-12 col-md-9">
                    <input class="au-input au-input--full" id="phone-no-input" type="tel" name="phone_no" value="{{$user->phone_no}}" pattern="[7][0-9]{2}-[0-9]{3}-[0-9]{4}" placeholder="Phone No">
                    <small class="form-text text-muted">(Format: 75*-***-****)</small>
                </div>
            </div>
         
            <div class="row form-group">
                <div class="col col-md-3">
                    <label for="profile-picture-input" class="form-control-label">Profile Picture</label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="file" id="profile-picture-input" name="profile_picture" class="form-control-file">
                </div>
            </div>

            <hr />

            <div class="row form-group">
                <div class="col col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Update Settings
                    </button>
                </div>
            </div>

        </form>

    </div>
</div>
