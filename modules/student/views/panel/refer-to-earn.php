<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Refer to earn
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <span id="copy-feedback" style="display:none; color: green;">Link copied!</span>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Course Name</th>
                                <th>Earn</th>
                                <th>Share</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $courses = $this->db->get('course');
                            if ($courses->num_rows()) {
                                $i = 1;
                                foreach ($courses->result() as $row) {
                                    $data = [
                                        'referral_id' => $this->student_model->studentId(),
                                        'course_id' => $row->id
                                    ];
                                    $token = $this->token->encode($data);
                                    echo '<tr>
                                        <td>' . $i++ . '.</td>
                                        <td>' . $row->course_name . '</td>
                                        <td>' . $row->referral_amount . ' {inr}</td>
                                        <td>
                                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Share
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item my-link" href="{base_url}register?token='.$token.'" id="whatsapp">WhatsApp</a>
                                                <a class="dropdown-item my-link" href="{base_url}register?token='.$token.'" id="facebook">Facebook</a>
                                                <a class="dropdown-item my-link" href="{base_url}register?token='.$token.'" id="twitter">Twitter</a>
                                                <a class="dropdown-item my-link" href="{base_url}register?token='.$token.'" id="linkedin">LinkedIn</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item my-link" href="{base_url}register?token='.$token.'" id="copy_link">Copy Link</a>
                                            </div>
                                        </td>
                                    
                                    </tr>';
                                }
                            }
                            $courses = $this->db->get('combo');
                            if ($courses->num_rows()) {
                                foreach ($courses->result() as $row) {
                                    $data = [
                                        'referral_id' => $this->student_model->studentId(),
                                        'combo_id' => $row->id
                                    ];
                                    $token = $this->token->encode($data);
                                    echo '<tr>
                                        <td>' . $i++ . '.</td>
                                        <td>' . $row->title . ' <label class="badge bg-danger" style="float:right">This is Combo</label></td>
                                        <td>' . $row->referral_amount . ' {inr}</td>
                                        <td>
                                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Share
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item my-link" href="{base_url}register?token='.$token.'" id="whatsapp">WhatsApp</a>
                                                <a class="dropdown-item my-link" href="{base_url}register?token='.$token.'" id="facebook">Facebook</a>
                                                <a class="dropdown-item my-link" href="{base_url}register?token='.$token.'" id="twitter">Twitter</a>
                                                <a class="dropdown-item my-link" href="{base_url}register?token='.$token.'" id="linkedin">LinkedIn</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item my-link" href="{base_url}register?token='.$token.'" id="copy_link">Copy Link</a>
                                            </div>
                                        </td>
                                    
                                    </tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
