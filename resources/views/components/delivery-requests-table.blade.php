<div class="row justify-content-center p-6">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <h3 class="title-5 m-b-35">Delivery Requests</h3>
                    
                    <!--
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="rs-select2--light rs-select2--md">
                                <select class="js-select2 select2-hidden-accessible" name="property" tabindex="-1" aria-hidden="true">
                                    <option selected="selected">All Properties</option>
                                    <option value="">Option 1</option>
                                    <option value="">Option 2</option>
                                </select><span class="select2 select2-container select2-container--default select2-container--below select2-container--focus" dir="ltr" style="width: 126px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-property-nj-container"><span class="select2-selection__rendered" id="select2-property-nj-container" title="All Properties">All Properties</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                <div class="dropDownSelect2"></div>
                            </div>
                            <div class="rs-select2--light rs-select2--sm">
                                <select class="js-select2 select2-hidden-accessible" name="time" tabindex="-1" aria-hidden="true">
                                    <option selected="selected">Today</option>
                                    <option value="">3 Days</option>
                                    <option value="">1 Week</option>
                                </select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" style="width: 76.6667px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-time-fd-container"><span class="select2-selection__rendered" id="select2-time-fd-container" title="3 Days">3 Days</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                <div class="dropDownSelect2"></div>
                            </div>
                            <button class="au-btn-filter">
                                <i class="zmdi zmdi-filter-list"></i>filters</button>
                        </div>
                        <div class="table-data__tool-right">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>add item</button>
                            <div class="rs-select2--dark rs-select2--sm rs-select2--dark2">
                                <select class="js-select2 select2-hidden-accessible" name="type" tabindex="-1" aria-hidden="true">
                                    <option selected="selected">Export</option>
                                    <option value="">Option 1</option>
                                    <option value="">Option 2</option>
                                </select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" style="width: 90.6667px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-type-gl-container"><span class="select2-selection__rendered" id="select2-type-gl-container" title="Export">Export</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                <div class="dropDownSelect2"></div>
                            </div>
                        </div>
                    </div>
-->
                    <div class="table-responsive table-responsive-data2 allowHorizontalScroll">
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Order ID</th>
                                    <th>Delivery Person</th>
                                    <th>email and phone no</th>
                                    <th>Date Offer Sent</th>
                                    <th>Delivery Fee</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{ $delivery_rows }}
                            </tbody>
                        </table>
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>