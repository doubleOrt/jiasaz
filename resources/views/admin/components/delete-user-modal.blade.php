
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smallmodalLabel">Delete User &nbsp;<i class="fa fa-warning"></i></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                   Are you sure you want to delete user #<span class="deleteUserModalTextUserId"></span>?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger deleteUserModalDeleteButton" data-user-id="">Delete</button>
            </div>
        </div>
    </div>
</div>