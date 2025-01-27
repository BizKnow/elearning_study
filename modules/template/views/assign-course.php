<?php
$courses = $this->student_model->list_system_course();
if (isset($student_id) && $student_id) {
    if ($courses->num_rows()) {
        ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Duration</th>
                    <th>Fees</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($courses->result() as $course) {
                    echo '<tr>
                        <td>' . $course->course_name . '</td>
                        <td>'.humnize_duration($course->duration,$course->duration_type).'</td>
                        <td>'.$course->fees.' {inr}</td>
                        <td>';
                        $chk = $this->student_model->student_course([
                            'student_id' => $student_id,
                            'course_id' => $course->id
                        ]);
                        if($chk->num_rows()){
                            $row = $chk->row();
                            echo '<label class="text-danger">Already Assigned</label>'."&nbsp;&nbsp;";
                            echo $row->status == 1 ? label('Payment Done',' bg-success') : label('Payment Pending',' bg-warning');
                        }
                        else{
                            echo '<button class="btn btn-primary do-assign" data-student_id="'.$student_id.'" data-course_id="'.$course->id.'">Assign</button>';
                        }
                        
                        
                  echo '</td>
                    </tr>';
                }

                ?>
            </tbody>
        </table>
        <?php
    } else
        echo alert("No courses available", 'danger');
} else
    echo alert("Please Select Student..", 'danger');