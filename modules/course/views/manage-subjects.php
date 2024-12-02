<div class="row">
    <div class="col-md-12">
        <form action="" id="subject_add">
            <div class="{card_class}">
                <div class="card-header collapsible cursor-pointer rotate" data-bs-toggle="collapse"
                    data-bs-target="#kt_docs_card_collapsible">
                    <h3 class="card-title"><i class="fa fa-plus text-dark fw-bold fs-1"></i> &nbsp;Add Subject</h3>
                    <div class="card-toolbar rotate-180">
                        <i class="ki-duotone ki-down fs-1"></i>
                    </div>
                </div>
                <div id="kt_docs_card_collapsible" class="collapse show">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="course" class="form-label required">Course</label>
                                    <select name="course_id" data-control="select2" data-placeholder="Select Course"
                                        id="course" class="form-select fetch-duration">
                                        <option></option>
                                        <?php
                                        $list = $this->db->get('course');
                                        foreach ($list->result() as $c)
                                            echo "<option value='$c->id' data-duration='$c->duration' data-durationType='$c->duration_type'>$c->course_name</option>";
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group set-duration">
                                    <input type="hidden" name="duration_type">
                                    <label for="course_duration" class="form-label required">Duration
                                        (<?= $this->ki_theme->course_duration('implode', ' / ') ?>)
                                    </label>
                                    <select name="duration" data-control="select2" data-placeholder="Select duration"
                                        id="course_duration" class="form-select ">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="subject_name" class="form-label required">Subject Name</label>
                                    <input type="text" class="form-control" name="subject_name"
                                        placeholder="Enter Subject Name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-label required">Subject Code</label>
                                    <input type="text" class="form-control" placeholder="Enter Subject Code"
                                        name="subject_code">
                                </div>
                            </div>
                            <div class="card card-flush border-primary  mt-3">
                                <div class="card-body">
                                    <div class="row m-0 p-0">
                                        <!--begin::Input group-->
                                        <div class="col-md-2 ">
                                            <!--begin::Label-->
                                            <label class="required fw-semibold fs-6 mb-5">Subject Type</label>
                                            <!--end::Label-->

                                            <div class="form-check radio radio-primary ps-0">
                                                <ul class="radio-wrapper">


                                                    <li>
                                                        <input class="form-check-input " checked id="radio-iconb"
                                                            type="radio" value="both" name="subject_type">
                                                        <label class="form-check-label" for="radio-iconb"><i
                                                                class="fa fa-eye-slash"></i><span>Both</span></label>
                                                    </li>
                                                    <li>
                                                        <input class="form-check-input" id="radio-icon" type="radio"
                                                            value="theory" name="subject_type">
                                                        <label class="form-check-label" for="radio-icon"><i
                                                                class="fa fa-sliders"></i><span>Theory</span></label>
                                                    </li>
                                                    <li>
                                                        <input class="form-check-input" id="radio-icon5" type="radio"
                                                            value="practical" name="subject_type">
                                                        <label class="form-check-label" for="radio-icon5"><i
                                                                class="fa fa-eye-slash"></i><span>Practical</span></label>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                        <!--end::Input group-->
                                        <div class="col-md-10">
                                            <div class="row theory_box both_box mb-4">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="" class="form-label">Theory Max Marks</label>
                                                        <input type="text" name="theory_max_marks"
                                                            placeholder=" Theory Max Marks" class="form-control"
                                                            value="100">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="" class="form-label">Theory Min Marks</label>
                                                        <input type="text" name="theory_min_marks"
                                                            placeholder=" Theory Min Marks" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row practical_box both_box">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="" class="form-label">Practical Max Marks</label>
                                                        <input type="text" name="practical_max_marks"
                                                            placeholder=" Practical Max Marks" class="form-control"
                                                            value="100">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="" class="form-label">Practical Min Marks</label>
                                                        <input type="text" name="practical_min_marks"
                                                            placeholder=" Practical Min Marks" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer pb-5">
                        {publish_button}
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-12 mt-4">
        <div class="{card_class}">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-list text-dark fw-bold fs-1"></i> &nbsp; List All Subjects</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="list-subjects">
                        <thead>
                            <tr>
                                <th rowspan="2">#</th>
                                <th rowspan="2">Code</th>
                                <th rowspan="2">Name</th>
                                <th rowspan="2">Course</th>
                                <th class="text-center w-10" colspan="2">Theory</th>
                                <th class="text-center w-10" colspan="2">Practical</th>
                                <th rowspan="2">Action</th>
                            </tr>
                            <tr>

                                <th style="width:65px!important">Min Marks</th>
                                <th style="width:65px!important">Max Marks</th>

                                <th style="width:65px!important">Min Marks</th>
                                <th style="width:65px!important">Max Marks</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-4">
        <div class="{card_class}">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-list text-dark fw-bold fs-1"></i> &nbsp; List All Deleted
                    Subjects</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="deleted-list-subjects">
                        <thead>
                            <tr>
                                <th rowspan="2">#</th>
                                <th rowspan="2">Code</th>
                                <th rowspan="2">Name</th>
                                <th rowspan="2">Course</th>
                                <th class="text-center w-10" colspan="2">Theory</th>
                                <th class="text-center w-10" colspan="2">Practical</th>
                                <th rowspan="2">Action</th>
                            </tr>
                            <tr>

                                <th style="width:65px!important">Min Marks</th>
                                <th style="width:65px!important">Max Marks</th>

                                <th style="width:65px!important">Min Marks</th>
                                <th style="width:65px!important">Max Marks</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script id="formTemplate" type="text/x-handlebars-template">
    <input type="hidden" name="id" value="{{id}}">
    
    <div class="form-group mb-4">
        <label class="form-label">Enter Subject Code</label>
        <input type="text" name="subject_code" class="form-control" placeholder="Enter Subject Code" value="{{subject_code}}">
    </div>
    <div class="form-group mb-4">
        <label class="form-label required">Enter Subject Name</label>
        <input type="text" name="subject_name" class="form-control" placeholder="Enter Subject name" value="{{subject_name}}">
    </div>
</script>