<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List Wallet</h3>
            </div>
            <div class="card-body">
                <?php
                $get = $this->db->select('ra.*,sc.*,s.name')
                    ->from('refferal_amount as ra')
                    ->join('student_courses as sc', 'sc.id = ra.parent_id AND sc.status = 1')
                    ->join('students as s', 's.id = sc.student_id')

                    ->where('sc.referral_id', 3)
                    ->order_by('sc.starttime', 'DESC')
                    ->get();
                echo $get->num_rows();
                if ($get->num_rows()) {
                    ?>
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
                                $amount = 0;
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
                                    $amount = $refer->row('referral_amount');
                                }
                                echo '<tr>
                                        <td>' . $i++ . '.</td>
                                        <td>' . date('d-m-Y', $row->starttime) . '</td>
                                        <td>' . $amount . ' {inr}</td>
                                        <td>' . $row->name . '</td>
                                        <td>' . $course . '&nbsp; ' . $sub . '</td>
                                
                                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                } else {
                    echo alert('No Record Found..', 'danger');
                }
                ?>
            </div>
        </div>
    </div>
</div>