<div class="container">
    <div class="row">
        <div class="col-md-12 p-4">
            <?php
            if (isset($_GET["order_id"]) && $_GET["order_id"] != "") {
                $order_id = $_GET["order_id"];
                // echo $order_id;
                $getOrder = $this->db->get_where('student_courses', [
                    'starttime' => $order_id
                ]);
                if ($getOrder->num_rows() > 0) {
                    echo alert('Done', 'success');
                    echo '<center>' . $this->ki_theme->set_attribute('target','_blank')->set_class('btn btn-primary')->add_action('<i class="fa fa-home"></i> Go to Dashboard', base_url('student')) . '</center>';

                } else
                    echo alert('Order id not match', 'danger');
            } else {
                echo alert('Purchase Data not found..', 'danger');
            }
            ?>
        </div>
    </div>
</div>