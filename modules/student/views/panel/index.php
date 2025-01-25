<style>
  .card-stamp-icon {
    left: 25px;
    top: -35px;
  }
</style>
<div class="row">
  <div class="col-12 mt-3 mb-3">
    <div class="card card-md ">
      <div class="card-stamp card-stamp-lg">
        <div class="card-stamp-icon bg-primary">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-message-2-heart">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M8 9h8" />
            <path d="M8 13h3.5" />
            <path d="M10.5 19.5l-1.5 -1.5h-3a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v4" />
            <path
              d="M18 22l3.35 -3.284a2.143 2.143 0 0 0 .005 -3.071a2.242 2.242 0 0 0 -3.129 -.006l-.224 .22l-.223 -.22a2.242 2.242 0 0 0 -3.128 -.006a2.143 2.143 0 0 0 -.006 3.071l3.355 3.296z" />
          </svg>
        </div>
      </div>
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-10">
            <h3 class="h1">Purchased Course(s)</h3>
            <div class="markdown text-secondary">
            </div>
          </div>
        </div>
        <div class="row">
          <?php
          $check_course = $this->student_model->student_course([
            'student_id' => $student_id,
            'status' => 1
          ]);
          // pre($this->session->userdata());
          if ($check_course->num_rows()) {
            foreach ($check_course->result() as $row) {
              try {
                $pdfToken = $this->token->encode([
                  'student_id' => $row->student_id,
                  'course_id' => $row->course_id,
                  'file_type' => 'file'
                ]);
                
                $videoToken = $this->token->encode([
                  'student_id' => $row->student_id,
                  'course_id' => $row->course_id,
                  'file_type' => 'youtube'
                ]);
                $courseRow = $this->student_model->show_remaining_days($row->id);
                // $course = $this->db->get_where('course', [
                //     'id' => $row->course_id
                // ]);
                $expred = $courseRow->status === 'Expired';
                $character = getFirstCharacter($courseRow->course_name);
                echo '
            <div class="col-md-4">
            <div class="card border-success">
                  <div class="card-header border-success">
                    <div>
                      <div class="row align-items-center">
                        <div class="col-auto">
                          <span class="avatar" style="background-image: url({base_url}assets/character/' . $character . '/green)"></span>
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
                                <th>Start on</th><td>' . $courseRow->purchase_date . '</td>
                            </tr>
                            <tr>
                                <th>End on</th><td>' . $courseRow->expiration_date . '</td>
                            </tr>
                            <tr>
                                <th>Enrollment No</th><td>' . $row->enrollment_no . '</td>
                            </tr>
                        </table>
                  </div>
                  <div class="card-footer d-flex ">
                    ';
                    if($expred){
                        echo alert('This Course was expired','danger p-3 m-0');
                    }
                    else{
                        echo '
                    <a href="{base_url}student/course-study-material/'.$pdfToken.'" class="btn me-2 btn-green "><i class="fa text-red fa-file-pdf me-2"></i> PDF File(s)</a>
                    <a href="{base_url}student/course-study-material/'.$videoToken.'" class="btn btn-green "><i class="fab text-red fa-youtube me-2"></i> Video Lecture(s)</a>
                        ';
                }
                    echo '
                  </div>
                </div>
            </div>
            ';
              } catch (Exception $e) {
              }
            }
          } else {
            echo alert('You don\'t have any course, Purchase First', 'danger');
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
$llsit = $this->student_model->get_non_purchase_courses();
if ($llsit->num_rows()) {
  // echo $this->db->last_query();
  ?>
  <div class="row">
    <div class="col-12 mt-3 mb-3">
      <div class="card card-md ">
        <div class="card-stamp card-stamp-lg">
          <div class="card-stamp-icon bg-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-message-2-dollar">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M8 9h8" />
              <path d="M8 13h6" />
              <path d="M13.5 19.5l-1.5 1.5l-3 -3h-3a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v3.5" />
              <path d="M21 15h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
              <path d="M19 21v1m0 -8v1" />
            </svg>
          </div>
        </div>
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-10">
              <h3 class="h1">For Purchase</h3>
              <div class="markdown text-secondary">
              </div>
            </div>
          </div>
          <div class="row">
            <?php
            foreach ($llsit->result() as $row) {
              $character = getFirstCharacter($row->course_name);
              // pre($row);
              $token = $this->token->encode([
                'course_id' => $row->id
              ]);
              $total_days = (int) calculate_course_days($row->duration, $row->duration_type);
              $end_date = new DateTime();
              $end_date->modify("+$total_days days");
              echo '<div class="col-md-4" ' . $row->id . '>
            <div class="card border-danger">
                  <div class="card-header border-danger">
                    <div>
                      <div class="row align-items-center">
                        <div class="col-auto">
                          <span class="avatar" style="background-image: url({base_url}assets/character/' . $character . ')"></span>
                        </div>
                        <div class="col">
                          <div class="card-title">' . $row->course_name . '</div>
                          <div class="card-subtitle">' . humnize_duration($row->duration, $row->duration_type) . '</div>
                        </div>
                      </div>
                    </div>
                    <div class="card-actions">
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <table class="table table-striped table-bordered">
                      <tr>
                        <th>Price</th><td>' . $row->fees . ' {inr}</td>
                      </tr>
                      <tr>
                        <th>Start Now</th><td>' . date('Y-m-d') . '</td>
                      </tr>
                      <tr>
                        <th>End by this date</th><td>' . $end_date->format('Y-m-d') . '</td>
                      </tr>
                    </table>
                  </div>
                  <div class="card-footer text-end border-danger">';
              $checkPayment = $this->db->where([
                'combo_id' => 0,
                'course_id' => $row->id,
                'student_id' => $student_id,
                'status' => 0
              ])->get('student_courses');
              // echo $this->db->last_query();
              if ($checkPayment->num_rows()) {
                  echo '<a class="btn btn-warning" href="{base_url}site/payment/'.$checkPayment->row('starttime').'">Try Again.</a>';
              } else {
                echo '<a target="_blank" href="{base_url}register?token=' . $token . '" class="btn btn-danger">
                      Purchase Now
                    </a>';
              }
              echo '
                  </div>
                </div>
            </div>';
            }
            // ... rest of the code
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>
