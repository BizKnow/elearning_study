<div class="row">
    <div class="col-md-12">
        <?php
        $get = $this->db->where('student_id', $this->student_model->studentId())->get('student_banks');
        $disabled = '';
        if (!$get->num_rows())
            echo '<form class="submit-bank"><input type="hidden" name="student_id" value="'.$this->student_model->studentId().'">';
        else
            $disabled = 'disabled';
        ?>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Bank Details KYC</h3>
            </div>
            <div class="card-body row">

                <div class="form-group col-md-12 mb-2">
                    <label for="" class="form-label required">Bank Name</label>
                    <input <?= $disabled ?> type="text" placeholder="Enter Bank Name" name="bank_name" value="<?=($get->num_rows() ? $get->row('bank_name') : '')?>"
                        class="form-control">
                </div>
                <div class="form-group col-md-12 mb-2">
                    <label for="" class="form-label required">Account Number</label>
                    <input <?= $disabled ?> type="text" placeholder="Enter Account Number" name="account_number" value="<?=($get->num_rows() ? $get->row('account_number') : '')?>"
                        class="form-control">
                </div>
                <div class="from-group col-md-6 mb-2">
                    <label for="" class="form-label required">IFSC CODE</label>
                    <input <?= $disabled ?> type="text" placeholder="Enter IFSC CODE" name="ifsc_code" value="<?=($get->num_rows() ? $get->row('ifsc_code') : '')?>"
                        class="form-control">
                </div>
                <div class="from-group col-md-6 mb-2">
                    <label for="" class="form-label required">Holder Name</label>
                    <input <?= $disabled ?> type="text" placeholder="Enter Holder Name" name="holder_name" value="<?=($get->num_rows() ? $get->row('holder_name') : '')?>"
                        class="form-control">
                </div>
                <div class="from-group col-md-12 mb-2">
                    <label for="" class="form-label">UPI</label>
                    <input <?= $disabled ?> type="text" placeholder="Enter UPI" name="upi" value="<?=($get->num_rows() ? $get->row('upi') : '')?>" class="form-control">
                </div>
            </div>
            <div class="card-footer">
                <?php
                if (empty($disabled))
                    echo '<button class="btn btn-primary"><i class="fa fa-save"></i> &nbsp; Save</button>';
                else
                    echo alert('Contact your administrator, for update bank details..', 'danger');
                ?>
            </div>
        </div>
        <?php
        if (!$get->num_rows())
            echo '</form>';
        ?>
    </div>
</div>