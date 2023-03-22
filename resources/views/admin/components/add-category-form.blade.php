<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <strong>Add Category</strong>
        </div>
        <div class="card-body card-block">
            <form action="/admin-add-category" method="post" class="">
                @csrf
                <div class="row form-group px-3">
                    <label for="categoryName" class=" form-control-label">Category Name</label>
                    <input type="text" id="categoryName" name="category_name" placeholder="Name..." class="form-control">
                </div>
                <div class="row form-group px-3">
                    <label for="categoryDescription" class=" form-control-label">Category Description</label>
                    <textarea id="categoryDescription" name="category_description" placeholder="Description..." class="form-control"></textarea>
                </div>
                <div class="row form-group px-3">
                    <label for="categoryColor" class=" form-control-label">Color</label>
                    <input type="color" id="categoryColor" name="category_color" placeholder="Color..." class="form-control" value="#000000" />
                </div>
                <hr />
                <div class="row form-group mt-2">
                    <div class="col col-md-12 text-center">
                        <button type="reset" class="btn btn-danger mr-1">
                        <i class="fa fa-ban"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Add
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>