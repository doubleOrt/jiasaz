
@php
    $ORDER_ITEM_MODAL_ID = "orderItemModal";
    $ORDER_ITEM_MODAL_CONFIRM_BUTTON_ID = "orderItemModalConfirmOrderButton";
    $ORDER_ITEM_MODAL_ORDER_QUANTITY_ID = "orderItemModalOrderQuantity";
@endphp

<div class="modal fade" id="{{$ORDER_ITEM_MODAL_ID}}" data-item-id="-1" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title" id="mediumModalLabel">Order Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5>
                        <span class="modalItemTitle"></span>
                        <span class="badge badge-warning modalItemCategory"></span>
                        </h5>
                    </div>
                    <div class="col-md-12">
                        <p class="modalItemDescription text-muted">
                            
                        </p>
                    </div>
                    <div class="col-md-12 mt-2">
                        <h6 class="text-secondary">
                            <small class="text-muted">By</small> <span class="font-weight-bold modalItemSeller"></span>
                        </h6>
                    </div>
                    <div class="col-md-12 mt-1">
                        <h4><span class="badge badge-success modalItemPrice font-weight-normal"></span></h4>
                    </div>
                    <div class="col-md-12 mt-1">
                        <form id="orderItemModalOrderForm" method="post" action="/order">   
                            @csrf
                            <input id="orderItemModalOrderFormItemId" type="hidden" name="item_id" value=""/>
                            <label for="quantity">Quantity <small>(<span id="orderItemModalAmountInStockLabel"></span> in stock)</small>:</label>
                            <input id="orderItemModalOrderQuantity" class="bg-light" type="number" name="quantity" value="1" min="1" max="5">
                            <!-- we press this hidden button using JQuery instead of submitting the form in JQuery so that browser validation works -->
                            <input id="orderItemModalHiddenSubmitButton" type="submit" style="display: none;"/>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button id="orderItemModalConfirmOrderButton" type="button" class="btn btn-primary">Confirm</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script>

    // update the order item modal with the data for the item when the oder item button is clicked
    $(".itemCard .orderItemButton").click(function(){
        const itemCardElement = $(this).closest(".card");
        const itemId = itemCardElement.attr("data-item-id");
        const itemTitle = itemCardElement.find(".card-title").text();
        const itemDescription = itemCardElement.find(".card-text").text();
        const itemPrice = itemCardElement.find(".itemPrice").text();
        const itemSeller = itemCardElement.find(".itemSeller").text();
        const itemCategory = itemCardElement.find(".itemCategory").text();
        const itemAmountInStock = itemCardElement.find(".itemAmountInStock").text();
        $("#{{$ORDER_ITEM_MODAL_ID}} .modalItemTitle").text(itemTitle);
        $("#{{$ORDER_ITEM_MODAL_ID}} .modalItemDescription").text(itemDescription);
        $("#{{$ORDER_ITEM_MODAL_ID}} .modalItemSeller").text(itemSeller);
        $("#{{$ORDER_ITEM_MODAL_ID}} .modalItemPrice").text(itemPrice);
        $("#{{$ORDER_ITEM_MODAL_ID}} .modalItemCategory").text(itemCategory);
        $("#{{$ORDER_ITEM_MODAL_ID}} .modalItemCategory").text(itemCategory);
        $("#{{$ORDER_ITEM_MODAL_ID}}").attr("data-item-id", itemId);
        $("#orderItemModalOrderQuantity").attr("max", itemAmountInStock);
        $("#orderItemModalAmountInStockLabel").text(itemAmountInStock);
        // set default value back to 1 (otherwise setting a quantity and redisplaying the modal shows previous quantity)
        $("#orderItemModalOrderQuantity").val(1);
    });

    $("#orderItemModalOrderForm").submit(function() {
        $(this).closest(".modal").modal("hide");
    });

    $("#{{ $ORDER_ITEM_MODAL_CONFIRM_BUTTON_ID }}").click(function() {
        const itemId = $(this).closest(".modal").attr("data-item-id");
        $("#orderItemModalOrderFormItemId").val(itemId);
        $("#orderItemModalHiddenSubmitButton").click();
    });

</script>