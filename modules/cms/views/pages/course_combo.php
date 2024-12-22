<style>
    .sp_g12 {
        background: linear-gradient(to right, rgb(38 66 69), rgb(14 126 137)) !important
    }

    .course_card {
        background-image: url(http://localhost/comp/themes/board/assets/images/course_bg.png) !important;
        background-repeat: no-repeat !important;
        background-size: cover !important;
    }

    @font-face {
        font-family: "nxr";
        src: url("{base_url}assets/assets/fonts/web/nxr6462.eot?t=1692947348749");
        src: url("{base_url}assets/assets/fonts/web/nxr6462.eot?t=1692947348749#iefix") format("embedded-opentype"),
        url("{base_url}assets/assets/fonts/web/nxr6462.woff2?t=1692947348749") format("woff2"),
        url("{base_url}assets/assets/fonts/web/nxr6462.woff?t=1692947348749") format("woff"),
        url("{base_url}assets/assets/fonts/web/nxr6462.ttf?t=1692947348749") format("truetype"),
        url("{base_url}assets/assets/fonts/web/nxr6462.svg?t=1692947348749#nxr") format("svg")
    }

    [class^=nxr-],
    [class*=" nxr-"] {
        font-family: "nxr" !important;
        font-size: none;
        font-style: normal;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .nxr-course_icon:before {
        content: "";
    }
</style>

<section class="small_pb">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                <div class="text-center animation animated fadeInUp" data-animation="fadeInUp"
                    data-animation-delay="0.01s" style="animation-delay: 0.01s; opacity: 1;">
                    <div class="heading_s1 text-center">
                        <h2 class="main-heading center-heading">Our Course Combo</h2>
                    </div>

                    <div class="small_divider"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="box_shadow1 radius_all_10">
                    <div class="row animation animated fadeInRight" data-animation="fadeInLeft"
                        data-animation-delay="0.02s" style="animation-delay: 0.02s; opacity: 1;">
                        <?php
                        $list = $this->db->order_by('id', 'DESC')->get('combo');
                        if ($list->num_rows()) {
                            $courses = [];
                            foreach ($list->result() as $row) {
                                $myCourses = [];
                                $coursesId = $row->courses ? json_decode($row->courses, true) : [];
                                if ($coursesId) {
                                    foreach ($coursesId as $id) {
                                        if (in_array($id, $courses)) {
                                            $myCourses[] = $courses[$id];
                                        } else {
                                            $course = $this->db->where('id', $id)->get('course');
                                            if ($course->num_rows()) {
                                                $courseRow = $course->row();
                                                $courseName = $courseRow->course_name . ' (' . humnize_duration_with_ordinal($courseRow->duration, $courseRow->duration_type) . ')';
                                                $courses[$id] = $courseName;
                                                $myCourses[] = $courseName;
                                            }
                                        }
                                    }
                                }
                                $string = '';
                                if($myCourses){
                                    $string = (implode('|',$myCourses));
                                }

                                $token = $this->token->withExpire()->encode([
                                    'combo_id' => $row->id
                                ]);
                                ?>
                                <div class="col-md-4 align-self-center mb-4">
                                    <div class="course_card">

                                        <div class="card sp_g12">
                                            <div class="card-body  text-white">
                                                <div class="row d-flex">
                                                    <div class="col-3 align-self-center">
                                                        <i class="display-3 nxr-course_icon"></i>
                                                    </div>

                                                    <div class="col-9 align-self-center">
                                                        <h4 class="text-white">
                                                            <?= $row->title ?>
                                                        </h4>
                                                        <p><?= $row->amount ?> {inr} </p>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="card-footer">
                                                <button class="btn btn-outline-light show-course" data-courses="<?=$string?>"
                                                  data-title="<?=$row->title?>"  style="padding: .25rem 1.25rem;font-weight: 600;">Courses List</button>

                                                <a href="{base_url}student/purchase-combo/<?=$token?>" style="padding: .25rem 1.25rem;font-weight: 600;"
                                                    class="btn btn-light btn-sm fw-bold">Purchase Now</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>