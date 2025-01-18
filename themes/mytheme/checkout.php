<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Details</h3>
                </div>
                <div class="card-body">
                    <?php
                    $token = $this->session->userdata("referral_token");
                    $template = $this->ki_theme->referral_template($token);
                    echo $template;
                    ?>
                </div>                
                <div class="card-footer">
                    <button class="btn btn-default">
                        <span><span class="hvr-bounce-to-bottom" style="padding:5px">10000 <span class="">₹</span>
                                Pay Now </span></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>