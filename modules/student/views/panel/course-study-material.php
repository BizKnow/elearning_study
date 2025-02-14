<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <?= $file_type == 'file' ? '<i class="fa text-red fa-file-pdf me-2"></i> PDF File' : '<i class="fab text-red fa-youtube me-2"></i> Video Lecture' ?>(s)
                </h3>
                <div class="ms-auto">
                    <div class="input-icon mb-3">
                        <input type="text" id="search-study" class="form-control" placeholder="Search…" autocomplete="off">
                        <span class="input-icon-addon">
                            <!-- Download SVG icon from http://tabler.io/icons/icon/search -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-1">
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body row">
                <?php
                $data = $this->db->select('c.duration,c.duration_type,sm.*')
                    ->from('study_material as sm')
                    ->join('course as c', 'c.id = sm.course_id AND c.id = ' . $course_id)
                    // ->where('sm.student_id',$student_id)
                    // ->order_by('sm.title','ASC')
                    ->where('sm.file_type', $file_type)
                    ->get();
                // echo $this->db->last_query();
                if ($data->num_rows() > 0) {
                    foreach ($data->result() as $row) {
                        $token = $this->token->encode([
                            'id' => $row->material_id,
                            'student_id' => $student_id
                        ]);
                        echo '<div class="col-md-4">
                                <div class="card" data-text="'.strip_tags($row->title).' '.strip_tags($row->description).'">';
                        if ($file_type == 'youtube' && defined('YOUTUBE_THUMB')) {
                            $id = getYouTubeId($row->file);
                            $thumb = getYouTubeThumbnail($id);
                            echo '<div class="card-body p-0" style="height:200px;background-image:url(' . $thumb . ');background-size: cover;background-position: center;">
                                    </div>';
                        }
                        echo '<div class="card-body p-2">                             
                                        <h1 class="search-text">' . $row->title . '</h1>
                                        <p class="">' . $row->description . '</p>
                                    </div>
                                    <div class="card-footer text-end">
                                        <a href="{base_url}student/study-material/' . $token . '" target="_blank" class="btn btn-green"><i class="fa fa-eye me-2"></i><i>Read Now</i></a>
                                    </div>
                                </div>
                            </div>';
                    }
                } else {
                    $message = $file_type == 'pdf' ? '<i class="fa text-red fa-file-pdf me-2"></i> PDF File' : '<i class="fab text-red fa-youtube me-2"></i> Video Lecture';
                    echo alert("$message(s) not found..", 'danger');
                }
                ?>
            </div>
        </div>
    </div>
</div>
