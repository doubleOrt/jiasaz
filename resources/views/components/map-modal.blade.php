@include("php-utils")

@php
    // default coordinates for the map to show inside the modal, should change dynamically later everytime the modal is opened
    $map_latitude = 0;
    $map_longitude = 0;

    $MAP_MODAL_ID = "mapModal";
@endphp

<div class="modal fade" id="{{$MAP_MODAL_ID}}" data-item-id="-1" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title" id="mediumModalLabel">Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="mapModalMapContainer" class="row">
                    @include("components.google-maps-map")
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    function getGoogleMapsEmbedUrlForCoordinates(latitude, longitude) {
        return "https://maps.google.com/maps?q=" + latitude + "," + longitude + "&hl=en&z=15&output=embed";
    }
    $(".showLocationOnMap").click(function() {
        console.log("Hello");
        const latitude = $(this).attr("data-location-latitude");
        const longitude = $(this).attr("data-location-longitude");
        $("#mapModalMapContainer")
            .find("iframe")
            .attr("src", getGoogleMapsEmbedUrlForCoordinates(latitude, longitude));
    });
</script>
