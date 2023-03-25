
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
            <table id="adminViewOrdersTable" class="table table-borderless table-data3 tableHoverableHeadings">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Shop</th>
                        <th>Customer</th>
                        <th>Item</th>
                        <th>Item Price</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    {{ $orders_rows }}
                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE-->
    </div>
</div>


<script>

    
    $(document).ready( function () {
        $('#adminViewOrdersTable').DataTable({
            order: [[0, 'desc']],
        });
        const controlsContainerRow = $("#adminViewOrdersTable")
            .closest(".table-responsive")
            .find(".tableControlsContainerRow");
        $(controlsContainerRow)
            .find(".tableControlsLengthContainer")
            .append($("#adminViewOrdersTable_length"));
        $(controlsContainerRow)
            .find(".tableControlsFilterContainer")
            .append($("#adminViewOrdersTable_filter"));
    });


</script>