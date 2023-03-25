<tr>
    <td>{{$role->id}}</td>
    <td>{{$role->name}}</td>
    <td>
        <span class="block-email smallBlock">
            Date Added:
            <strong>
                {{$role->created_at}}
            </strong>
        </span>
        <br />
        <span class="block-email smallBlock mt-1">
            Date Updated:
            <strong>
                {{$role->updated_at}}
            </strong>
        </span>
    </td>
    <td>
        <button class="btn btn-sm btn-primary rolesTableSeePermissionsButton" data-role-id="{{$role->id}}">
            See Permissions
        </button>
    </td>
</tr>