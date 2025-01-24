
<!--begin::Navbar-->
<div class="overflow-hidden position-relative card-rounded">
    <div class="card mb-2 mb-xl-10 border border-1 border-primary">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap">
                <!--begin: Pic-->
                <div class="me-7" align="center">
                    <input type="hidden" id="student_id" value="{student_id}">
                    <?php
                    $file_exists = file_exists('upload/' . $image);
                    ?>
                </div>
                <!--end::Pic-->
                <!--begin::Info-->
                <div class="flex-grow-1">
                    <!--begin::Title-->
                    <div class="d-flex justify-content-between align-items-start flex-wrap">
                        <!--begin::User-->
                        <div class="d-flex flex-column">
                            <!--begin::Name-->
                            <div class="d-flex align-items-center mb-2">
                                <a href="#"
                                    class="text-gray-900 text-hover-primary fs-2 fw-bold me-1 student-name">{student_name}</a>
                                <a href="#" class="student-status <?= ($student_profile_status) ? '' : 'd-none' ?>"><i
                                        class="ki-outline ki-verify fs-1 text-primary"></i></a>

                            </div>
                            <!--end::Name-->
                            <!--begin::Info-->
                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                <a href="#"
                                    class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="ki-outline ki-profile-circle fs-4 me-1"></i> Student
                                </a>
                                <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                    <i class="ki-outline ki-sms fs-4"></i> &nbsp;<span
                                        class="student-email">{email}</span>
                                </a>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->
            <!--begin::Navs-->
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                <!--begin::Nav item-->
                <?php
                foreach ($tabs as $type => $data) {
                    $active = $type == $tab ? 'active' : '';
                    $icon = '';
                    $link = $current_link;
                    if (isset($data['url']) and $data['url'])
                        $link = "$current_link/{$data['url']}";
                    if (isset($data['icon'])) {
                        list($class, $path) = $data['icon'];
                        $icon = $this->ki_theme->keen_icon($class, $path);
                    }
                    ?>
                    <li class="nav-item mt-2">
                        <a class="nav-link active text-active-primary ms-0 me-10  <?= $active ?>" href="<?= $link ?>">
                            <?= $icon ?>
                            <?= str_replace('Account', '', $data['title']) ?>
                        </a>
                    </li>
                    <!--end::Nav item-->
                    <?php
                }
                ?>
            </ul>
            <!--begin::Navs-->
        </div>
    </div>
</div>

<!--end::Navbar-->
<!--begin::details View-->
<?php
$this->ki_theme->check_it_referral_stduent($student_id);
// echo $student_id;
if (file_exists(__DIR__ . '/panel/' . $tab . EXT)) {
    echo $this->parser->parse('student/panel/' . $tab, $student_details, true);
}
?>
<!--end::details View-->