<div class="row">
    <div class="col-md-4">
        <form action="" class="setting-update">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Setting</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="" class="form-label required">Withdrawal Minimum Amount</label>
                        <input name="withdrawal_amount_limit" value="<?=ES('withdrawal_amount_limit',0)?>" type="number" placeholder="Enter Minimum Amount" class="form-control">
                    </div>
                    <div class="form-group mt-3">
                        <label for="" class="form-label required">Share Recorded Video Whatapp no.</label>
                        <input name="recorded_video_send_on" required value="<?=ES('recorded_video_send_on')?>" type="number" placeholder="Enter Whatsapp Number" class="form-control">
                    </div>
                </div>
                <div class="card-footer">
                    {publish_button}
                </div>
            </div>
        </form>
    </div>
</div>