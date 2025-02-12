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
            'icon' => array('book', 2),
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
                )
            )
        ),
        array(
            'label' => 'Course Combo',
            'type' => 'course_combo',
            'icon' => array('package', 4),
            'url' => 'course/combo',
        ),
    )
);
$config['menu'] = array(
    'title' => 'Student Area',
    'menu' => array(
        array(
            'label' => 'Student Information',
            'type' => 'student_information',
            'icon' => array('users', 3),
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
            'label' => 'Setting',
            'type' => 'cms_setting',
            'icon' => array('settings', 4),
            'url' => 'cms/setting'
        ),
        array(
            'label' => 'Support Info',
            'type' => 'support_info',
            'icon' => array('target', 4),
            'url' => 'cms/support_info'
        ),
        array(
            'label' => 'Gallery Image',
            'type' => 'gallery_setting',
            'icon' => array('folder', 4),
            'url' => 'cms/gallery-images'
        ),
        array(
            'label' => 'Slider',
            'type' => 'slider_setting',
            'icon' => array('map', 4),
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
$staticMenus = array(
    array(
        'label' => 'Forms',
        'type' => 'static_forms',
        'icon' => array('file', 4),
        'url' => 'cms/forms'
    )
);
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