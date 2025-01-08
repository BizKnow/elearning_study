<?php
$course = $this->db->where('id',$combo_id)->get('combo')->row();
?>

<div class="animation animated fadeInRight">
    <table class="table table-bordered" style="position: relative;">
        <tr>
            <th colspan="2">Selected Courses Combo</th>
        </tr>
        <tr>
            <th width="135">Combo Name</th>
            <td>
                <?=$course->title?>
            </td>
        </tr>
        <tr>
            <th width="135">Price</th>
            <td>
                <?=$course->amount?> {inr}
            </td>
        </tr>
    </table>
</div>