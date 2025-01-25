<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Account Overview</h3>
                <?php
                // if(isset($isStudent)){
                //     echo '<div class="card-toolbar">';
                //     echo $this->ki_theme
                //                 ->with_icon('setting-2')
                //                 ->with_pulse('primary')
                //                 ->outline_dashed_style('primary')
                //                 ->add_action('Setting','student/profile/setting');
                //     echo '</div>';
                // }
                ?>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered">
                    <tr>
                        <th>Student Name</th>
                        <td>{student_name}</td>
                    </tr>
                    <tr>
                        <th>Mobile</th>
                        <td><a href="tel:{contact_number}">{contact_number}</a></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><a href="mailto:{email}">{email}</a></td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
</div>