<div class="row">

    <?php
    $check_course = $this->student_model->student_course([
        'student_id' => $student_id
    ]);

    if ($check_course->num_rows()) {
        foreach ($check_course->result() as $row) {
            $course = $this->db->get_where('course', [
                'id' => $row->course_id
            ]);
            if ($course->num_rows()) {
                $courseRow = $course->row();
                $character = getFirstCharacter($courseRow->course_name);
                $n = 1;
                $type = $courseRow->duration_type;
                if ($courseRow->duration_type == 'semester') {
                    $n = $courseRow->duration * 6;
                    $type = 'months';
                }

                $endOn = date('d M Y', strtotime('+' . ($n) . ' ' . $type, $row->starttime));


                echo '
            
            <div class="col-md-4">
            <div class="card border-danger">
                  <div class="card-header border-danger">
                    <div>
                      <div class="row align-items-center">
                        <div class="col-auto">
                          <span class="avatar" style="background-image: url({base_url}assets/character/' . $character . ')"></span>
                        </div>
                        <div class="col">
                          <div class="card-title">' . $courseRow->course_name . '</div>
                          <div class="card-subtitle">' . humnize_duration($courseRow->duration, $courseRow->duration_type) . '</div>
                        </div>
                      </div>
                    </div>
                    <div class="card-actions">
                    </div>
                  </div>
                  <div class="card-body p-0">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>Start On</th><td>' . date('d M Y', $row->starttime) . '</td>
                            </tr>
                            <tr>
                                <th>End No</th><td>' . $endOn . '</td>
                            </tr>
                            <tr>
                                <th>Enrollment No</th><td>' . $row->enrollment_no . '</td>
                            </tr>
                        </table>
                  </div>
                </div>
            
            </div>
            
            
            
            ';
            }
        }
    } else {
        echo alert('You don\'t have any course, Purchase First', 'danger');
    }
    ?>
</div>