<div class="row">
    <div class="col-md-12 mb-5">
        <form action="" id="live-notification">
            <div class="{card_class}">
                <div class="card-header">
                    <h3 class="card-title">Add Live Notification</h3>
                </div>
                <div class="card-body row">
                    <div class="form-group mb-2 col-md-6">
                        <label for="" class="form-label">Title</label>
                        <input type="text" name="title" required placeholder="Enter Title" class="form-control">
                    </div>
                    <div class="form-group mb-2 col-md-6">
                        <label for="" class="form-label">Description</label>
                        <textarea type="text" name="description" required placeholder="Enter Link"
                            class="form-control"></textarea>
                    </div>
                    <div class="form-group mb-2 col-md-12">
                        <label for="" class="form-label">Url</label>
                        <textarea type="text" name="Url" required placeholder="Enter Link"
                            class="form-control"></textarea>
                    </div>
                    <div class="form-group mb-2 col-md-6">
                        <label for="" class="form-label">Start Time</label>
                        <input type="datetime-local" name="starttime" required placeholder="Enter Link"
                            class="form-control"></input>
                    </div>
                    <div class="form-group mb-2 col-md-6">
                        <label for="" class="form-label">End Time</label>
                        <input type="datetime-local" name="endtime" required placeholder="Enter Link"
                            class="form-control"></input>
                    </div>

                </div>
                <div class="card-footer">
                    {publish_button}
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="{card_class}">
            <div class="card-header">
                <h3 class="card-title">List Notification Data</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="notification_list">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Start Time</th>
                                <th>End Time</th>
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