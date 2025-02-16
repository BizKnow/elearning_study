<?php
$token = $this->uri->segment(3, 0);
if ($token) {
    // echo $token;
    try {
        $id = $this->token->decode($token)['id'];
        $fetch = $this->db->where('id', $id)->get('withdrawal_requests');
        if (!$fetch->num_rows())
            throw new Exception('Invalid Token..');
        $row = $fetch->row();
        $student = $this->student_model->get_student_via_id($row->student_id);
        if (!$student->num_rows())
            throw new Exception('Student Not Found on this token..');
        $student = $student->row();
        ?>
        <div class="row">
            <div class="col-md-12">
                <form action="" class="withdrawal-request">
                    <input type="hidden" name="token" value="<?= $token ?>">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <?php
                                $bank = $this->db->where('student_id', $row->student_id)->get('student_banks');
                                if ($bank->num_rows()) {
                                    $bankROw = $bank->row();
                                    ?>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped border-primary border-2">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    <th class="text-center text-white" colspan="4">Bank Details / UPI</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>Bank Name</th>
                                                    <td><?=$bankROw->bank_name?></td>
                                                    <th>Account Number</th>
                                                    <td><?=$bankROw->account_number?></td>
                                                </tr>
                                                <tr>
                                                    <th>IFSC Code</th>
                                                    <td><?=$bankROw->ifsc_code?></td>
                                                    <th>Holder Name</th>
                                                    <td><?=$bankROw->holder_name?></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="2">Unified Payments Interface (UPI)</th>
                                                    <td colspan="2"><?=$bankROw->upi?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="col-md-6">
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <th class="text-center" colspan="2"><?= $student->student_name ?>
                                                (<?= $student->contact_number ?>)</th>
                                        </tr>
                                        <tr>
                                            <th>Order ID</th>
                                            <td>ORD<?= strtotime($row->timestamp) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Withdrawal Amount</th>
                                            <td><?= $row->amount ?> {inr}</td>
                                        </tr>
                                        <tr>
                                            <th>Withdrawal Date</th>
                                            <td><?= date('d-m-Y', strtotime($row->timestamp)) ?></td>
                                        </tr>
                                        <?php
                                        if ($row->timestamp != $row->updatetime) {
                                            echo '<tr>
                                        <th>Update Time</th><td>' . date('d-m-Y', strtotime($row->updatetime)) . '</td>
                                    </tr>';
                                        }
                                        ?>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="withdrawal_status">
                                            <option value="0" <?= $row->status == '0' ? 'selected' : '' ?>>Pending</option>
                                            <option value="1" <?= $row->status == '1' ? 'selected' : '' ?>>Accept</option>
                                            <option value="2" <?= $row->status == '2' ? 'selected' : '' ?>>Reject</option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-2" id="transcation_id" <?= $row->status == '1' ? '' : 'style="display:none"' ?>>
                                        <label for="" class="form-label required">Transcation Id</label>
                                        <input type="text" name="transcation_id" placeholder="Enter Transcation"
                                            value="<?= $row->payment_id ?>" class="form-control">
                                    </div>
                                    <div class="form-group mt-2" id="reason-box" <?= $row->status == '2' ? '' : 'style="display:none"' ?>>
                                        <label for="" class="form-label required">Reason</label>
                                        <input type="text" name="reason" placeholder="Enter Reason" value="<?= $row->reason ?>"
                                            class="form-control">
                                    </div>

                                    <div class="form-group text-end mt-3">
                                        <button class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
    } catch (Exception $e) {
        echo alert($e->getMessage(), 'danger');
    }
    // print_r($decode);

} else {
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List Request(s)</h3>
                </div>
                <div class="card-body">
                    <?php
                    // $list = $this->db->get('withdrawal_requests')
                    $list = $this->db->select('wr.*,s.name,s.contact_number as mobile')
                        ->from('withdrawal_requests as wr')
                        ->join('students as s', 's.id = wr.student_id')
                        ->order_by('id', 'DESC')
                        ->get();
                    if ($list->num_rows()) {
                        ?>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#.</th>
                                    <th>Date</th>
                                    <th>Order ID</th>
                                    <th>Amount</th>
                                    <th>Student</th>
                                    <th>Request Status</th>
                                    <th>Transcation/Reason</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($list->result() as $row) {
                                    $token = $this->token->encode(['id' => $row->id]);
                                    echo '<tr>
                                        <td>' . $i++ . '.</td>
                                        <td>' . date('d-m-Y', strtotime($row->timestamp)) . '</td>
                                        <td>ORD' . strtotime($row->timestamp) . '</td>
                                        <td>' . $row->amount . ' {inr}</td>
                                        <td>' . $row->name . '&nbsp;( ' . $row->mobile . ' )</td>
                                        ';
                                    if ($row->status == '1') {
                                        echo '<td>' . label('Accept on ' . date('d-m-Y', strtotime($row->updatetime)), ' bg-success') . '</td>';
                                        echo '<td class="text-success">' . $row->payment_id . '</td>';

                                    } else if ($row->status == '2') {
                                        echo '<td>' . label('Reject on ' . date('d-m-Y', strtotime($row->updatetime)), ' bg-danger') . '</td>';
                                        echo '<td class="text-danger">' . $row->reason . '</td>';

                                    } else {
                                        echo '<td>' . label('Pending..', ' bg-warning') . '</td>';
                                        echo '<td class="text-warning"></td>';

                                    }
                                    echo '
                                        <td>
                                            <a href="{base_url}student/withdrawal-request/' . $token . '" class="btn btn-primary">Action</a>
                                        </td>
                                    </tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                    } else
                        echo alert('Data not found..', 'danger');

                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}

?>