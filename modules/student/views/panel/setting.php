<div class="row">
    <form action="" class="save-student-data" id="save-student-data">
        <input type="hidden" name="student_id" id="student_id" value="{student_id}">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex flex-wrap align-items-center gap-2">
                    <h3 class="card-title me-auto mb-0">Account Setting</h3>
                    <div class="card-toolbar">
                        {update_button}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group mb-4 col-lg-6 col-xs-12 col-sm-12">
                            <label class="form-label required required">Student Name</label>
                            <input type="text" name="name" value="{student_name}" class="form-control"
                                placeholder="Enter Student Name">
                        </div>
                        <?php
                        if ($this->student_model->isAdmin()) {
                            ?>
                            <div class="form-group mb-4 col-lg-6 col-xs-12 col-sm-12">
                                <label class="form-label required required">Student Email</label>
                                <input type="email" name="email" value="{email}" class="form-control"
                                    placeholder="Enter Student Email">
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="col-md-6 mt-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Profile Photo</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <span class="avatar avatar-xl" style="background-image: url({base_url}upload/{image})"></span>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label">Update Profile Photo</label>
                            <input class="form-control" type="file" name="avatar">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>