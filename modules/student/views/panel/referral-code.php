<form action="" class="submit-referral_code">
    <input type="hidden" value="<?= $student_id ?>" name="student_id">
    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center gap-2">
            <h3 class="card-title  me-auto mb-0">Custom Referral Code(s)</h3>
            <div class="card-toolbar">
                <?php
                echo $this->ki_theme
                    ->with_icon('gift')
                    ->with_pulse('success')
                    ->outline_dashed_style('success')
                    ->button('Add Code', 'submit');
                ?>
            </div>
        </div>
        <div class="card-body row">
            <div class="col-md-6 form-group">
                <label for="" class="form-label required">Select Course</label>
                <select name="course_id" id="" required class="form-control">
                    <option value="">Select Course</option>
                    <?php
                    $listCourses = $this->db->get('course');
                    foreach ($listCourses->result() as $course) {
                        echo '<option value="' . $course->id . '">' . $course->course_name . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="" class="form-label required">Enter Your Code</label>
                <input type="text" name="code" required min="3" class="form-control" placeholder="Enter Referral Code">
            </div>
        </div>
    </div>
</form>

<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">List Custom Referral Code(s)</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <?php
            $list = $this->db->select('src.*,c.course_name')
                ->from('student_referral_code as src')
                ->join('course as c', 'c.id = src.course_id')
                ->where('src.student_id', $student_id)
                ->get();
            if ($list->num_rows()) {
                ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Course</th>
                            <th>Referral Code</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($list->result() as $row) {
                            echo '<tr>
                                <td>' . $i++ . '.</td>
                                <td>' . $row->course_name . '</td>
                                <td>' . $row->code . '</td>
                                <td>
                                    <button class="btn btn-danger btn-xs btn-sm delete-ref" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo alert('Record not Found..', 'danger');
            }
            ?>
        </div>

    </div>
</div>