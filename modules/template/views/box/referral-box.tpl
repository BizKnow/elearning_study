<div class="user-card animation animated fadeInRight">
    <!--div class="user-card-img">
        <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjxivAs4UknzmDfLBXGMxQkayiZDhR2ftB4jcIV7LEnIEStiUyMygioZnbLXCAND-I_xWQpVp0jv-dv9NVNbuKn4sNpXYtLIJk2-IOdWQNpC2Ldapnljifu0pnQqAWU848Ja4lT9ugQex-nwECEh3a96GXwiRXlnGEE6FFF_tKm66IGe3fzmLaVIoNL/s1600/img_avatar.png"
            alt="">
    </div -->
    <?php
    $user = $this->db->where('id',$referral_id)->get('students')->row();
    $course = $this->db->where('id',$course_id)->get('course')->row();
    ?>
    <div class="user-card-info">
        <h2>Refer By <b class="text-success"><?=$user->name?></b></h2>
        <p><span>Course Name:</span> <?=$course->course_name?> </p>
        <p><span>Duration:</span> <?=$course->duration?> <?=$course->duration_type?></p>
        <p><span>Price:</span> <?=$course->fees?> {inr}</p>
    </div>
</div>