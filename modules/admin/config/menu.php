<?php
$config['dashboard'] = array(
    'title' => 'General',
    'menu' => array(
        array('label' => 'Dashboard', 'icon' => array('layout-dashboard', 2), 'type' => 'dashboard', 'url' => 'admin')
    )
);

$config['academics'] = array(
    'title' => 'Academics',
    'condition' => OnlyForAdmin(),
    'menu' => array(
        array(
            'label' => 'Course Area',
            'type' => 'course_area',
            'icon' => array('learning', 2),
            'submenu' => array(
                array(
                    'label' => 'Category',
                    'type' => 'course_category',
                    'icon' => array('note-2', 4),
                    'url' => 'course/category',
                ),
                array(
                    'label' => 'Manage Course',
                    'type' => 'manage_course',
                    'icon' => array('book', 4),
                    'url' => 'course/manage',
                ),
                array(
                    'label' => 'Manage Subject(s)',
                    'type' => 'manage_subject',
                    'icon' => array('book-open', 4),
                    'url' => 'course/manage-subjects'
                ),
                array(
                    'label' => 'Arrange Subjects',
                    'type' => 'arrange_subject',
                    'icon' => array('book-open', 4),
                    'url' => 'course/arrange-subjects'
                ),
            )
        ),
        array(
            'label' => 'Session',
            'type' => 'session_area',
            'icon' => array('others', 4),
            'url' => 'academic/session',
        )
    )
);
$config['menu'] = array(
    'title' => 'Student Area',
    'menu' => array(
        array(
            'label' => 'Student Information',
            'type' => 'student_information',
            'icon' => array('profile-user', 3),
            'submenu' => array(
                array(
                    'label' => 'Student Details',
                    'type' => 'student_details',
                    'icon' => array('shield-search', 3),
                    'url' => 'student/search',
                ),
                array(
                    'label' => 'Student Admission',
                    'type' => 'student_admission',
                    'icon' => array('plus', 3),
                    'url' => 'student/admission',
                ),                
                array(
                    'label' => 'Assign Course',
                    'type' => 'student_assign_course',
                    'icon' => array('plus', 3),
                    'url' => 'student/assign-course',
                ),
                array(
                    'label' => 'Student List',
                    'type' => 'approved_students',
                    'icon' => array('user-tick text-success', 0),
                    'url' => 'student/approve-list',
                ),
                array(
                    'label' => 'Study Material',
                    'type' => 'study_material',
                    'icon' => array('message-text', 3),
                    'url' => 'student/manage-study-material'
                )
            )
        )
    )
);

$config['cms_setting'] = array(
    'title' => 'CMS',
    'condition' => OnlyForAdmin(),
    'menu' => array(
        array(
            'label' => 'Manage Role User',
            'icon' => array('people', 5),
            'type' => 'manage_role_user',
            'condition' => CHECK_PERMISSION('ROLE_SYSTEM'),
            'submenu' => array(
                array(
                    'label' => 'Role Category',
                    'type' => 'manage_role_category',
                    'icon' => array('chart', 2),
                    'url' => 'admin/manage-role-category',
                ),
                array(
                    'label' => 'Manage User',
                    'type' => 'manage_user',
                    'icon' => array('people', 5),
                    'url' => 'admin/manage-role-account'
                )

            )
        ),
        array(
            'label' => 'Setting',
            'type' => 'cms_setting',
            'icon' => array('setting-2', 4),
            'url' => 'cms/setting'
        ),
        array(
            'label' => 'Gallery Image',
            'type' => 'gallery_setting',
            'icon' => array('picture', 4),
            'url' => 'cms/gallery-images'
        ),
        array(
            'label' => 'Slider',
            'type' => 'slider_setting',
            'icon' => array('picture', 4),
            'url' => 'cms/slider'
        ),
        array(
            'label' => 'Page Area',
            'type' => 'page_area',
            'icon' => array('file', 3),
            'submenu' => array(
                array(
                    'label' => 'Add Pages',
                    'type' => 'add_pages',
                    'icon' => array('add-item', 4),
                    'url' => 'cms/add-page',
                ),
                array(
                    'label' => 'List Pages',
                    'type' => 'list_pages',
                    'icon' => array('tablet-text-down', 4),
                    'url' => 'cms/list-pages',
                ),
                array(
                    'label' => 'Menu Section',
                    'type' => 'cms_menu_section',
                    'icon' => array('menu', 4),
                    'url' => 'cms/menu-section'
                ),

            )
        )
    )
);
$staticMenus = [];
if (file_exists(THEME_PATH . 'config/menu.php')) { {
        require THEME_PATH . 'config/menu.php';
        $staticMenus[] = $menu;
        unset($menu);
    }

}
$config['fix_properties'] = array(
    'title' => 'Theme Setting',
    'condition' => OnlyForAdmin(),
    'menu' => $staticMenus
);