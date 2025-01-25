<div class="card">
    <div class="row g-0">
        <div class="col-12 col-md-3 border-end">
            <div class="card-body">
                <h4 class="subheader">Account settings</h4>
                <div class="list-group list-group-transparent">
                <?php
                foreach ($tabs as $type => $data) {
                    $active = $type == $tab ? 'active' : '';
                    $icon = '';
                    $link = $current_link;
                    if (isset($data['url']) and $data['url'])
                        $link = "$current_link/{$data['url']}";
                    if (isset($data['icon'])) {
                        list($class, $path) = $data['icon'];
                        // $icon = $this->ki_theme->keen_icon($class, $path);
                        $icon = "<i class='fa fa-$class'></i>&nbsp;";
                    }
                    ?>
                        <a class="list-group-item list-group-item-action d-flex align-items-center   <?= $active ?>" href="<?= $link ?>">
                            <?= $icon ?>
                            <?= str_replace('Account', '', $data['title']) ?>
                        </a>
                    <!--end::Nav item-->
                    <?php
                }
                ?>
                    <!-- <a href="{base_url}student/profile"
                        class="list-group-item list-group-item-action d-flex align-items-center active">My Profile</a>
                    <a href="{base_url}student/profile/change-password" class="list-group-item list-group-item-action d-flex align-items-center">My
                        Change Password</a> -->
                </div>
                <!-- <h4 class="subheader mt-4">Experience</h4>
                <div class="list-group list-group-transparent">
                    <a href="#" class="list-group-item list-group-item-action">Give Feedback</a>
                </div> -->
            </div>
        </div>
        <div class="col-12 col-md-9 d-flex flex-column p-3">
            <?php
            if (file_exists(__DIR__ . '/panel/' . $tab . EXT)) {
                echo $this->parser->parse('student/panel/' . $tab, $student_details, true);
            }
            ?>
        </div>
    </div>
</div>