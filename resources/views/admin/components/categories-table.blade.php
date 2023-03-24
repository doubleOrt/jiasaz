
@php
    $UPDATE_CATEGORY_ROUTE = "/admin-update-category";
@endphp

<div class="row justify-content-center mt-3 px-4">
    <div class="col-md-12">
        <!-- DATA TABLE-->
        <div class="table-responsive">
            <div class='row tableControlsContainerRow'>
                <div class="col col-md-6 tableControlsLengthContainer"></div>
                <div class="col col-md-6 text-right tableControlsFilterContainer"></div>
            </div>
            <table id="adminViewCategoriesTable" class="table table-borderless table-data3 tableHoverableHeadings">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Color</th>
                        <th>Date Added</th>
                        <th>Added By</th>
                        <th>Info</th>
                        <th title="Display Category In Navigaton Menus">Navbar</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{ $categories_rows }}
                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE-->
    </div>
</div>

<script>
    $(document).ready( function () {
        $('#adminViewCategoriesTable').DataTable();
        const controlsContainerRow = $("#adminViewCategoriesTable")
            .closest(".table-responsive")
            .find(".tableControlsContainerRow");
        $(controlsContainerRow)
            .find(".tableControlsLengthContainer")
            .append($("#adminViewCategoriesTable_length"));
        $(controlsContainerRow)
            .find(".tableControlsFilterContainer")
            .append($("#adminViewCategoriesTable_filter"));
    });

    $(".updateCategorySaveButton").click(function(e) {
        e.preventDefault();
        const trElement = $(this).closest("tr");
        const categoryId = $(trElement).attr("data-category-id");
        const categoryName = $(trElement).find(".categoryName").text();
        const categoryDescription = $(trElement).find(".categoryDescription").text();
        const categoryColor = $(trElement).find("input[name='category_color']").val();
        // We need to cast this to an integer (backend requirement).
        const categoryDisplayedInNavbar = + $(trElement).find("input[name='displayed_in_navbar']").is(":checked");

        $.post(
            "{{$UPDATE_CATEGORY_ROUTE}}",
            {
                "category_id": categoryId,
                "name": categoryName,
                "description": categoryDescription,
                "color": categoryColor,
                "displayed_in_navbar": categoryDisplayedInNavbar,
            },
        )
        .done(function(msg) {
            showFixedPositionAlert("success", msg);
        })
        .fail(function(xhr, status, err) {
            const response = jQuery.parseJSON(xhr["responseText"]);
            const message = response["message"];
            console.warn(response);
            showFixedPositionAlert("danger", "Failed to update category: " + message);
        });
    });
</script>