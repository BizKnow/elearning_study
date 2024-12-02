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