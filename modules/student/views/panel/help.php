<?php
$get = $this->db->select("title,value,type,CASE 
WHEN type = 'mobile' THEN CONCAT('tel:',value)
WHEN type = 'email' THEN CONCAT('mailto:',value)
ELSE value
END AS url")
    ->get('supports');

?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">For Support</h3>
            </div>
            <div class="card-body">
                <?php
                if ($get->num_rows()) {
                    ?>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($get->result() as $row) {
                                switch ($row->type) {
                                    case 'mobile':
                                        $title = '<i class="fa fa-phone"></i> &nbsp;Call Now';
                                        break;
                                    case 'email';
                                        $title = '<i class="fa fa-envelope"></i> &nbsp;Email';
                                        break;
                                    default:
                                        $title = '<i class="fa fa-question-circle"></i>&nbsp; Support';
                                }
                                echo '<tr>
                                        <td>' . $row->title . '</td>
                                        <td><a class="btn btn-primary" href="'.$row->url.'">'.$title.'</a></td>
                                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                } else {
                    echo alert('Support data not exists..', 'danger');
                }
                
                ?>
            </div>
        </div>
    </div>
</div>