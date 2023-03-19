<div class="card-header">
    <strong>Add Item</strong>
    </div>
    <div class="card-body card-block">
        <form action="/add-item" method="post" enctype="multipart/form-data" class="form-horizontal">
           @csrf
           <input type="hidden" name="shop_id" value="{{ auth()->user()->id }}" />
            <div class="row form-group">
                <div class="col col-md-3">
                    <label for="text-input" class=" form-control-label">Title</label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="text" id="text-input" name="title" required placeholder="Text" class="form-control">
                    <small class="form-text text-muted">Item title</small>
                </div>
            </div>

            <div class="row form-group">
                <div class="col col-md-3">
                    <label for="textarea-input" class=" form-control-label">Description</label>
                </div>
                <div class="col-12 col-md-9">
                    <textarea name="description" required id="textarea-input" rows="9" placeholder="Item description..." class="form-control"></textarea>
                </div>
            </div>

            <div class="row form-group">
                <div class="col col-md-3">
                    <label for="select" class=" form-control-label">Category</label>
                </div>
                <div class="col-12 col-md-9">
                    <select name="category_id" required id="select" class="form-control">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row form-group">
                <div class="col col-md-3">
                    <label for="item-quantity-input" class=" form-control-label">Quantity</label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="number" id="item-quantity-input" name="original_amount" required min="1" placeholder="Quantity" class="form-control">
                    <small class="help-block form-text">Quantity of your item</small>
                </div>
            </div>

            <div class="row form-group">
                <div class="col col-md-3">
                    <label for="item-price-input" class=" form-control-label">Price</label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="number" id="item-price-input" name="price" required step="0.01" min="0.01" placeholder="Price" class="form-control">
                    <small class="help-block form-text">Price of your item (per unit)</small>
                </div>
            </div>
         
            <div class="row form-group">
                <div class="col col-md-3">
                    <label for="file-input" class=" form-control-label">Item Image</label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="file" id="file-input" name="image" required class="form-control-file">
                </div>
            </div>
            <hr />
            <div class="row form-group">
                <div class="col col-md-12 text-center">
                    <button type="reset" class="btn btn-danger">
                        <i class="fa fa-ban"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Add Item
                    </button>
                </div>
            </div>

        </form>

    </div>
</div>