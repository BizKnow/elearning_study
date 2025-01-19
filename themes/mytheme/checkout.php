<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form action="" method="POST" class="action">
                <?php
                $token = $this->session->userdata("referral_token");
                if ($token) {
                    ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Details</h3>
                        </div>
                        <div class="card-body">
                            <?php
                            $template = $this->ki_theme->referral_template($token);
                            echo $template;
                            $detail = ($this->ki_theme->referral_data($token));
                            // echo form_hidden((array)$detail);
                            echo form_hidden("token", $token);
                            ?>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-default">
                                <span><span class="hvr-bounce-to-bottom" style="padding:5px"><?= $detail['amount'] ?> <span
                                            class="">₹</span>
                                        Pay Now </span></span>
                            </button>
                        </div>
                    </div>
                </form>
                <?php
                } else {
                    echo alert("Course is not available in cart", 'danger');
                    echo '<center>' . $this->ki_theme->set_class('btn btn-primary')->add_action('<i class="fa fa-home"></i> Back to Home', base_url()) . '</center>';
                }
                ?>
        </div>
    </div>
</div>