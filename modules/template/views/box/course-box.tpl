<?php
$course = $this->db->where('id',$course_id)->get('course')->row();
?>

<div class="animation animated fadeInRight">
    <table class="table table-bordered" style="position: relative;">
        <tr>
            <th colspan="2">Selected Course</th>
        </tr>
        <tr>
            <th width="135">Course Name</th>
            <td><?=$course->course_name?></td>
        </tr>
        <tr>
            <th width="135">Duration</th>
            <td><?=$course->duration?> <?=$course->duration_type?></td>
        </tr>
        <tr>
            <th width="135">Price</th>
            <td><?=$course->fees?> {inr}</td>
        </tr>
    </table>
</div>