<style>
    .select2-selection__choice__remove {
        background-color: transparent !important;
    }

    .select2-results__option--selected {
        background-color: lightgray;
    }

    .custom-select2-container .select2-search__field {
        width: 100% !important;
    }

    .select2-results__options {
        scrollbar-width: thin;
        border: 1px solid lightgray;
        box-shadow: 0 0 10px 0 lightgray;
    }
</style>


<div class="row">
    <div class="col-md-6">
        <form action="" id="form">
            <div class="{card_class}">
                <div class="card-header">
                    <h3 class="card-title">Add Course Combo</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="" class="form-label required">Enter Title</label>
                        <input type="text" placeholder="Title" name="title" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label required">Select Courses</label>
                        <select data-placeholder="Please Select Courses" class="form-select" name="courses[]"
                            data-control="select2" multiple="multiple">
                            <option value="1" amount="1200">Hello</option>
                            <option value="2" amount="1200">Hii</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label required">Amount</label>
                        <input type="number" min="100" required class="form-control" name="amount" required value="0">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label required">Description</label>
                        <textarea class="form-control" name="description" placeholder="Description" required></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    {publish_button}
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <div class="{card_class}">
            <div class="card-header">
                <h3 class="card-title">List Course Combo(s)</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped" id="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Amount</th>
                            <!-- <th>Courses</th> -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>