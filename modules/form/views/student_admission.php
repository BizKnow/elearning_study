<style>
    .form-label {
        color: black
    }
</style>
<?php
$col = (!CHECK_PERMISSION('NOT_TIMETABLE')) ? 4 : 6;
$col =  CHECK_PERMISSION('ADMISSION_WITH_SESSION') ? 4  : $col;
?>
<section class="small_pt gray-bg" data-aos="fade-up">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center animation animated fadeInUp" data-aos="fade-up" data-animation="fadeInUp"
                    data-animation-delay="0.01s" style="animation-delay: 0.01s; opacity: 1;">
                    <div class="heading_s1 text-center">
                        <h2 class="main-heading center-heading"><i class="fab fa-wpforms"></i> Student Admission Form
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-4 mt-4">
                <form action="" class="student-admission-form animation animated fadeInLeft">
                    <div class="card">
                        <div class="card-body ">
                            <div class="row">
                                <div class="form-group mb-4 col-lg-3 col-xs-12 col-sm-12 d-none hide">
                                    <label class="form-label required">Admission Date</label>
                                    <input readonly type="text" name="admission_date" class="form-control"
                                        placeholder="Select Admission Date" value="<?= $this->ki_theme->date() ?>">
                                </div>
                                <div class="form-group mb-4 col-lg-6 col-xs-12 col-sm-12">
                                    <label class="form-label required required">Student Name</label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Enter Student Name">
                                </div>

                                <div class="form-group mb-4 col-lg-6 col-xs-12 col-sm-12">
                                    <label class="form-label required">Mobile Number</label>
                                    <div class="input-group">
                                        <input type="text" name="contact_number" class="form-control"
                                            placeholder="Mobile Number" autocomplete="off">
                                            <?php
                                            echo form_hidden('contact_no_type','self');
                                            ?>
                                    </div>
                                </div>
                                <div class="form-group mb-4 col-lg-6 col-xs-12 col-sm-12">
                                    <label class="form-label required">E-Mail ID</label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter E-Mail ID">
                                </div>
                                <div class="form-group mb-4 col-lg-6 col-xs-12 col-sm-12">
                                    <label class="form-label required">Password</label>
                                    <input type="text" name="password" placeholder="Enter Your Password" class="form-control">
                                </div>
                                <div class="form-group mb-4 col-lg-6 col-xs-12 col-sm-12">
                                    <label class="form-label required">Upload Photo</label>
                                    <input type="file" name="image" class="form-control">
                                </div>
                                
                               
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="btn-wrapper btn-wrapper2">
                                <?= $this->ki_theme->set_class('btn btn-outline-success')->button('<span><i class="fa fa-plus"></i> Admission Now</span>', 'submit') ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>