<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title  me-auto mb-0">List Wallet</h3>
                <div class="card-toolbar">
                    <a href="{base_url}student/withdrawal-amount" class="btn btn-primary"><i
                            class="fa fa-inr"></i>&nbsp;Withdrawal Amount</a>
                </div>
            </div>
            <div class="card-body">
                <?php
                $studentId = $this->student_model->studentId();
                $get = $this->db->select('ra.*,ra.amount as a_amount,sc.*,s.name,s.contact_number')
                    ->from('refferal_amount as ra')
                    ->join('student_courses as sc', 'sc.id = ra.parent_id AND sc.status = 1')
                    ->join('students as s', 's.id = sc.student_id')
                    ->where("(sc.referral_id = $studentId AND ra.type = 'referral') OR (sc.student_id = $studentId AND ra.type = 'cashback' )")
                    ->order_by('sc.starttime', 'DESC')
                    ->get();
                // echo $get->num_rows();
                // echo $this->db->last_query();
                if ($get->num_rows()) {
                    ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Student</th>
                                    <th>Course/Combo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($get->result() as $row) {
                                    $mobile = maskMobileNumber1($row->contact_number);
                                    // $amount = 0;
                                    $type = label(ucfirst($row->type), ' bg-primary');
                                    $course = '';
                                    $sub = '';
                                    if ($row->combo_id) {
                                        $refer = $this->db->select('title as course_name')->where('id', $row->combo_id)->get('combo');
                                        $sub = label('Combo');
                                    } else {
                                        $refer = $this->db->where('id', $row->course_id)->get('course');
                                        $sub = label('Course');
                                    }
                                    if ($refer->num_rows()) {
                                        $course = $refer->row('course_name');
                                    }
                                    echo '<tr>
                                        <td>' . $i++ . '.</td>
                                        <td>' . date('d-m-Y', $row->starttime) . '</td>
                                        <td>' . $row->a_amount . ' {inr} ' . $type . '</td>
                                        <td>';
                                    if ($row->student_id == $studentId) {
                                        echo 'You';
                                    } else
                                        echo $row->name . '&nbsp;(' . $mobile . ')';

                                    echo '</td>
                                        <td>' . $course . '&nbsp; ' . $sub . '</td>
                                
                                </tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                } else {
                    echo alert('No Record Found..', 'danger');
                }
                ?>
            </div>
        </div>
    </div>
</div>