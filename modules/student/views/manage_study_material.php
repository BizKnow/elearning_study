<div class="row">
    <div class="col-md-12">
        <form action="" id="upload_study_material">
            <input type="hidden" name="material_id" value="<?= time() ?>">
            <input type="hidden" name="upload_by" value="<?= $this->student_model->loginId() ?>">
            <div class="{card_class}">
                <div class="card-header">
                    <h3 class="card-title">
                        <?= $this->ki_theme->keen_icon('cloud-add') ?> Upload Study Material
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">Course</label>
                                <select class="form-select" name="course_id" data-control="select2"
                                    data-placeholder="Select a Course">
                                    <option></option>
                                    <?php
                                    foreach($this->student_model->course()->result() as $row){
                                        echo '<option value="'.$row->id.'">'.$row->course_name.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="title" class="form-label required">Title</label>
                                <input type="text" class="form-control" name="title" placeholder="Enter Title">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4 ">
                                <label class="form-label required">File Type</label>
                                <select class="form-select" name="file_type" data-control="select2"
                                    data-placeholder="Select a File Type">
                                    <option value="file">File</option>
                                    <option value="youtube">Youtube Link</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4 file">
                                <label for="file" class="form-label required">File</label>
                                <input type="file" class="form-control" id="file">
                            </div>
                            <div class="form-group mb-4 youtube d-none">
                                <label for="" class="form-label required">Youtube Link</label>
                                <input type="text" class="form-control" placeholder="Enter Youtube Link" name="youtube_link">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description" class="form-label mt-4">Description</label>
                                <textarea class="form-control" name="description" cols="4"
                                    placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    {publish_button}
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-12 mt-5">
        <div class="{card_class}">
            <div class="card-header">
                <h3 class="card-title">List Study Material</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="study-table">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Title</th>
                                <th>File</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


