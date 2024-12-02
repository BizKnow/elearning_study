<div class="row">
    <div class="col-md-4">

        <form id="gallery-image" action="#" method="post">
            <div class="{card_class}">
                <div class="card-header">
                    <h3 class="card-title">Image Gallery</h3>
                </div>
                <div class="card-body ">
                    <div class="form-group">
                        <label for="image" class="form-label mb-4">Select Image</label>
                        <input type="file" name="image" class="form-control" id="image">
                    </div>

                </div>
                <div class="card-footer">{publish_button}</div>
            </div>
        </form>
        <!--end::Form-->
    </div>
    <div class="col-md-8">
        <div class="{card_class}">
            <div class="card-header">
                <h3 class="card-title">List Images</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="list-images">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script id="formTemplate" type="text/x-handlebars-template">
    <input type="hidden" name="id" value="{{id}}">
    <div class="form-group">
        <label class="form-label required">Enter Title</label>
        <input type="text" name="title" value="{{title}}" class="form-control" placeholder="Enter Title">
    </div>
</script>