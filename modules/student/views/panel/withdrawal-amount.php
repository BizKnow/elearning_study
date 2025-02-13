<div class="row">
    <div class="col-md-6">
        <form action="" id="withdrawal-form">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Withdrawal Request</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="" class="form-label required">Enter Amount</label>
                        <input type="number" name="amount" placeholder="Amount Ex- 100" class="form-control">
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success">Request Submit</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-12 mt-3">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title text-white">List Withdrawal Request(s)</h3>
            </div>
            <div class="card-body">
                <?php
                $list = $this->db->where('student_id', $this->student_model->studentId())->order_by('updatetime', 'DESC')->get('withdrawal_requests');
                if ($list->num_rows()) {
                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#.</th>
                                    <th>Date</th>
                                    <td>Order ID</td>
                                    <th>Amount</th>
                                    <th>Update Time</th>
                                    <th>Request Status</th>
                                    <th>Transcation/Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($list->result() as $row) {
                                    echo '<tr>
                                        <td>' . $i++ . '.</td>
                                        <td>' . date('d-m-Y', strtotime($row->timestamp)) . '</td>
                                        <td>ORD' . strtotime($row->timestamp) . '</td>
                                        <td>' . $row->amount . ' {inr}</td>
                                        <td>';
                                    if ($row->timestamp != $row->updatetime) {
                                        echo date('d-m-Y', strtotime($row->updatetime));
                                    } else
                                        echo label('Pending..', ' bg-warning');

                                    echo '</td>';
                                    if ($row->status == '1') {
                                        echo '<td>' . label('Accept', ' bg-success') . '</td>';
                                        echo '<td class="text-success">' . $row->payment_id . '</td>';
                                    } else if ($row->status == '2') {
                                        echo '<td>' . label('Reject', ' bg-danger') . '</td>';
                                        echo '<td class="text-danger">' . $row->reason . '</td>';
                                    } else {
                                        echo '<td>' . label('Pending..', ' bg-warning') . '</td>';
                                        echo '<td class="text-warning">Pending..</td>';
                                    }

                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                } else
                    echo alert('Data not found...', 'danger');
                ?>
            </div>
        </div>
    </div>
</div>