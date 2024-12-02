<?php

// pre($this->ki_theme->list_pages());

?>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow border-primary">
            <div class="card-body table-card fade">
                <div class="table-responsive">
                    <table class="table table-bordered" id="list-pages">
                        <thead>
                            <th>#</th>
                            <th>Page Name</th>
                            <th>Page Type</th>
                            <th>Primary Page</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            $index = 1;
                            foreach ($this->ki_theme->list_pages() as $id => $page) {
                                $page['index'] = $index++;
                                extract($page);
                                echo ('<tr>
                                                        <td>'.$index.'.</td>      
                                                        <td>'.$title.'</td>      
                                                        <td>'.label($type,'light-'.($isLink ? 'primary' : 'success')).'</td>      
                                                        <td>
                                                            <div class="form-check">
                                                            <input style="height:15px" class="form-check-input clicktosetPrimary" value="'.$id.'" '.($isPrimary ? 'checked' : '').' name="a" id="flexRadioDefault_'.$index.'" type="radio" name="flexRadioDefault">
                                                            <label class="form-check-label mb-0" for="flexRadioDefault_'.$index.'">'.($isPrimary ? '' : 'Set Is').' Primary </label>
                                                            </div>
                                                        </td>      
                                                        <td class="btn-group">');
                                                      if(!$isLink){
                                                        echo "<a href='{base_url}cms/manage-page-schema/{$link}' class='btn btn-warning btn-sm'>Manage Schema</a>";
                                                     
                                                        echo '<a href="{base_url}cms/manage-page-content/'.$link.'" class="btn btn-sm btn-icon btn-primary">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>';
                                                      }
                                                      echo "<a href='{$url}' class='btn btn-info btn-sm' target='_blank'>
                                                                <i class='fa fa-eye'></i>
                                                            </a>";
                                                    echo '<button class="btn btn-danger btn-icon btn-sm delete-page" data-id="'.$id.'" data-isprimary="'.$isPrimary.'">
                                                                <i class="fa fa-trash"></i>
                                                            </button>';
                                                echo '</td>        
                                                    </tr>';
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>