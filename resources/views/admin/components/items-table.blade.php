
@php
    $UPDATE_ITEM_ROUTE = "/admin-update-item";
    $DELETE_ITEM_ROUTE = "/admin-delete-item";
@endphp

<div class="row justify-content-center mt-3 px-4">
    <div class="col-md-12">
        <!-- DATA TABLE-->
        <div class="table-responsive">
            <div class='row tableControlsContainerRow'>
                <div class="col col-md-6 tableControlsLengthContainer"></div>
                <div class="col col-md-6 text-right tableControlsFilterContainer"></div>
            </div>
            <table id="adminViewItemsTable" class="table table-borderless table-data3 tableHoverableHeadings">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Shop</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Date Added</th>
                        <th>Image</th>
                        <th>Info</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{ $items_rows }}
                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE-->
    </div>
</div>

@include("admin.components.delete-item-modal");

<script>
    $(document).ready( function () {
        $('#adminViewItemsTable').DataTable();
        const controlsContainerRow = $("#adminViewItemsTable")
            .closest(".table-responsive")
            .find(".tableControlsContainerRow");
        $(controlsContainerRow)
            .find(".tableControlsLengthContainer")
            .append($("#adminViewItemsTable_length"));
        $(controlsContainerRow)
            .find(".tableControlsFilterContainer")
            .append($("#adminViewItemsTable_filter"));
    });

    // show image preview when image is uploaded
    $(".updateItemImageInput").change(function(e) {
        const file = e.target.files[0];
        if (file) {
            $(this).closest("td").find("img").attr("src", URL.createObjectURL(file));
        }
    });

    $(".updateItemSaveButton").click(function(e) {
        e.preventDefault();
        const trElement = $(this).closest("tr");
        const itemId = $(trElement).attr("data-item-id");
        const itemTitle = $(trElement).find(".itemTitle").text();
        const itemDescription = $(trElement).find(".itemDescription").text();
        const itemCategoryId = $(trElement).find(".updateItemCategorySelectInput").val();
        // cast to int because of back-end
        const itemPrice = + $(trElement).find(".itemPrice").text();

        const itemImage = $(trElement).find(".updateItemImageInput").prop("files")[0];

        /* You have to use a form element to pass the data to ajax otherwise no data will be
        * sent because of the "contentType" and "processData" being set to "false" (having either
        * prevents data from being sent). We need to have those as "false" though in order to 
        * send a file asynchronously.
        *  */
        const formData = new FormData();
        formData.append("item_id", itemId);
        formData.append("title", itemTitle);
        formData.append("description", itemDescription);
        formData.append("category_id", itemCategoryId);
        formData.append("price", itemPrice);
        if (itemImage) {
            formData.append("image", itemImage);
        }

        $.ajax({
            "url": "{{$UPDATE_ITEM_ROUTE}}",
            "type": "post",
            "data": formData,
            processData: false,
            contentType: false,
        })
        .done(function(msg) {
            console.log(msg);
            showFixedPositionAlert("success", msg);
        })
        .fail(function(xhr, status, err) {
            const response = jQuery.parseJSON(xhr["responseText"]);
            const message = response["message"];
            console.warn(response);
            showFixedPositionAlert("danger", "Failed to update item: " + message);
        });
    });

    $(".itemDeleteButton").click(function(e){
        const itemId = $(this).closest("tr").attr("data-item-id");
        $("#deleteItemModal").find(".deleteItemModalTextItemId").text(itemId);
        $("#deleteItemModal").find(".deleteItemModalDeleteButton").attr("data-item-id", itemId);
    });

    $(".deleteItemModalDeleteButton").click(function(e) {
        const itemId = $(this).attr("data-item-id");
        $.post(
            "{{$DELETE_ITEM_ROUTE}}",
            {
                "item_id": itemId, 
            }
            )
            .done(function(msg) {
                console.log(msg);
                showFixedPositionAlert("success", msg);
                $("#deleteItemModal").modal("hide");
            })
            .fail(function(xhr, status, err) {
                const response = jQuery.parseJSON(xhr["responseText"]);
                const message = response["message"];
                console.warn(response);
                showFixedPositionAlert("danger", "Failed to delete item: " + message);
            });
    });
   
</script>