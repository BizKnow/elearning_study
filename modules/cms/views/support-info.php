<div class="row">
    <div class="col-md-4">
        <form action="" class="add-support-info" id="page_form">
            <div class="{card_class}">
                <div class="card-header">
                    <h3 class="card-title">List Support Data</h3>
                </div>
                <div class="card-body">
                    <div class="form-group mb-2">
                        <label for="" class="form-label required">Type</label>
                        <select name="type" id="" required data-control="select2" data-placeholder="Select Type"
                            class="form-control">
                            <option></option>
                            <option value="url">URL</option>
                            <option value="email">Email</option>
                            <option value="mobile">Moblie</option>
                            <option value="whatsapp">Whatsapp</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="form-label required">Title</label>
                        <input type="text" placeholder="Enter Title.." name="title" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label required">Value</label>
                        <input type="text" placeholder="Enter Mobile , Email or URL.." name="value" required
                            class="form-control">
                    </div>
                </div>
                <div class="card-footer">
                    {publish_button}
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-8">
        <div class="{card_class}">
            <div class="card-header">
                <h3 class="card-title">List Support Data</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped" id="list">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <body>

                    </body>
                </table>
            </div>
        </div>
    </div>
</div>