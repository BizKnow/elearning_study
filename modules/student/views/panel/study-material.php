<?php
$login_id = $this->student_model->studentId();
$list = $this->db->get_where('student_courses', [
    'student_id' => $login_id
]);
if ($list->num_rows()) {

    foreach ($list->result() as $row) {
        $getCourse = $this->db->where('id', $row->course_id)->get('course');
        if ($getCourse->num_rows()) {
            $courseRow = $getCourse->row();
            echo '<div class="row">
            <div class="col-md-12">
                <div class="{card_class}">
                    <div class="card-header">
                        <h3 class="card-title">' . $courseRow->course_name . ' ( ' . $courseRow->duration . ' ' . $courseRow->duration_type . ')</h3>
                    </div>
                    <div class="card-body">';
            $studyMaterial = $this->db->where('course_id', $row->course_id)->get('study_material');
            if ($studyMaterial->num_rows()) {
                echo '
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold text-uppercase gs-0">
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>';
                    $i =1 ;
                foreach ($studyMaterial->result() as $study) {
                    $token = $this->token->encode([
                        'id' => $study->material_id,
                        'student_id' => $login_id
                    ]);
                    echo '<tr data-time="' . $study->material_id . '">
                                <td>' .$i++ . '.</td>
                                <td>' . $study->title . '</td>
                                <td>' . $study->description . '</td>
                                <td>
                                    <a href="{base_url}student/study-material/'.$token.'" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
                                </td>
                            </tr>';
                }



                echo '                      </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
            }
        }
    }
} else {
    echo $this->ki_theme->item_not_found('Not Found', 'Study Material not found.');
}

/*

*/
?>