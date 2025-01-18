<style>
    .bg-white {
        background-color: white !important;
    }

    .tabs-container {
        width: 100%;
        height: auto;
        /* Make the height flexible */
        background-color: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        position: relative;
        border: 1px solid #0e7e89;
    }

    .tabs {
        padding: 10px 20px 15px 20px;
        /* Increased padding */
    }

    .tab-links {
        display: flex;
        /* justify-content: space-between; */
        border-bottom: 1px solid #f0f0f0;
    }

    .tab-link {
        background: none;
        border: none;
        font-size: 16px;
        font-weight: 500;
        padding: 15px 30px;
        /* Increased padding for spacing */
        color: #ccc;
        cursor: pointer;
        position: relative;
        transition: color 0.3s ease;
    }

    .tab-link.active,
    .tab-link:hover {
        color: #b84de5;
        /* Gradient purple */
    }

    .tab-link i {
        margin-right: 10px;
    }

    .tab-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 3px;
        bottom: -1px;
        left: 50%;
        background: linear-gradient(45deg, #0e7e89, #325b6f);
        /* Purple gradient */
        transition: all 0.4s ease;
    }

    .tab-link.active::after {
        width: 100%;
        left: 0;
    }

    .tab-content {
        display: none;
        animation: fadeInUp 0.5s ease;
        padding: 5px 10px 15px 10px;
    }

    .tab-content.active {
        display: block;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }


    /* Responsive Design */
    @media screen and (max-width: 600px) {
        .tab-links {
            flex-direction: column;
            align-items: center;
        }

        .tab-link {
            text-align: center;
            width: 100%;
            padding: 15px 0;
        }
    }

    .user-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        border-radius: 10px;
        border: 2px solid #0e7e89;
        padding: 40px;
        width: 100%;
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 20px -5px rgba(0, 0, 0, 0.5);
    }

    .user-card:before {
        content: '';
        position: absolute;
        height: 300%;
        width: 33%;
        background: #0e7e89;
        top: -60px;
        left: -125px;
        z-index: 0;
        transform: rotate(17deg);
    }

    .user-card-img {
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 3;
    }

    .user-card-img img {
        width: 132px;
        height: 132px;
        object-fit: cover;
        border-radius: 50%;
        /* border:6px solid #0e7e89; */
        /* box-shadow: 0 0 20px 0 #0e7e89; */
        border: 4px solid white
    }

    .user-card-info {
        text-align: center;
    }

    .user-card-info h2 {
        font-size: 24px;
        margin: 0;
        margin-bottom: 10px;
        font-family: 'Bebas Neue', sans-serif;
        letter-spacing: 3px;
    }

    .user-card-info p {
        font-size: 14px;
        margin-bottom: 2px;
    }

    .user-card-info p span {
        font-weight: 700;
        margin-right: 10px;
    }

    @media only screen and (min-width: 768px) {
        .user-card {
            flex-direction: row;
            align-items: flex-start;
        }

        .user-card-img {
            margin-right: 20px;
            margin-bottom: 0;
        }

        .user-card-info {
            text-align: left;
        }
    }

    @media (max-width: 767px) {
        .wrapper {
            padding-top: 3%;
        }

        .user-card:before {
            width: 300%;
            height: 200px;
            transform: rotate(0);
        }

        .user-card-info h2 {
            margin-top: 25px;
            font-size: 35px;
        }

        .user-card-info p span {
            display: block;
            margin-bottom: 15px;
            font-size: 18px;
        }
    }
</style>
<?php
$template = $this->ki_theme->referral_template();
?>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="tabs-container">
                <div class="tabs">
                    <div class="tab-links">
                        <a class="tab-link active" data-tab="tab-1"><i class="fas fa-plus"></i> New Registration</a>
                        <a class="tab-link" data-tab="tab-2"><i class="fas fa-sign-in"></i>Student Login</a>
                    </div>

                    <div class="tab-content active" id="tab-1">
                        <style>
                            .form-label {
                                color: black
                            }
                        </style>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-center animation animated fadeInUp" data-aos="fade-up"
                                    data-animation="fadeInUp" data-animation-delay="0.01s"
                                    style="animation-delay: 0.01s; opacity: 1;">
                                    <div class="heading_s1 text-center">
                                        <h2 class="main-heading center-heading"><i class="fab fa-wpforms"></i>
                                            Student Admission Form
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <?php
                                echo $template;
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" class="student-admission-form animation animated fadeInLeft">
                                    <?php
                                    if (isset($_GET['token']))
                                        echo form_hidden('token', $_GET['token']);
                                    ?>
                                    <div class="card">
                                        <div class="card-body ">
                                            <div class="row">
                                                <div class="form-group mb-4 col-lg-4 col-xs-12 col-sm-12 d-none">
                                                    <label class="form-label required">Admission Date</label>
                                                    <input readonly type="text" name="admission_date"
                                                        class="form-control" placeholder="Select Admission Date"
                                                        value="<?= $this->ki_theme->date() ?>">
                                                </div>
                                                <div class="form-group mb-4 col-lg-4 col-xs-12 col-sm-12">
                                                    <label class="form-label required required">Student
                                                        Name</label>
                                                    <input type="text" name="name" class="form-control"
                                                        placeholder="Enter Student Name">
                                                </div>



                                                <div class="form-group mb-4 col-lg-4 col-xs-12 col-sm-12">
                                                    <label class="form-label required">Father Name</label>
                                                    <input type="text" name="father_name" class="form-control"
                                                        placeholder="Enter Father Name">
                                                </div>
                                                <div class="form-group mb-4 col-lg-4 col-xs-12 col-sm-12">
                                                    <label class="form-label required">E-Mail ID</label>
                                                    <input type="email" name="email" class="form-control"
                                                        placeholder="Enter E-Mail ID">
                                                </div>
                                                <div class="form-group mb-4 col-lg-6 col-xs-12 col-sm-12">
                                                    <label class="form-label required">Mobile Number</label>
                                                    <div class="input-group">
                                                        <input type="number" name="contact_number" class="form-control"
                                                            placeholder="Mobile Number" autocomplete="off">
                                                        <input type="hidden" name="contact_no_type" value="self">

                                                    </div>
                                                </div>
                                                <!-- <div class="form-group mb-4 col-lg-3 col-xs-12 col-sm-12">
                                <label class="form-label required">Father Mobile</label>
                                <input type="text" name="father_mobile" class="form-control"
                                    placeholder="Enter Father MObile">
                            </div> -->
                                                <!-- <div class="form-group mb-4 col-lg-3 col-xs-12 col-sm-12">
                                <label class="form-label required">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Enter">
                            </div>-->
                                                <div class="form-group mb-4 col-lg-6 col-xs-12 col-sm-12">
                                                    <label class="form-label required">Password</label>
                                                    <input type="text" name="password" class="form-control"
                                                        placeholder="Enter Password">
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

                    <div class="tab-content" id="tab-2">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-center animation animated fadeInUp" data-aos="fade-up"
                                    data-animation="fadeInUp" data-animation-delay="0.01s"
                                    style="animation-delay: 0.01s; opacity: 1;">
                                    <div class="heading_s1 text-center">
                                        <h2 class="main-heading center-heading"><i class="fa fa-sign-in"></i>
                                            Student Login Form
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 pt-5">
                                <?php
                                echo $template;
                                ?>
                            </div>
                            <div class="col-md-7">
                                <form action="" class="student-login-form animation animated fadeInLeft">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="" class="form-label mt-2 required">Mobile Number</label>
                                                <input type="text" name="contact_number" placeholder="Enter Mobile Number."
                                                    class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="form-label required">Password</label>
                                                <input type="text" name="password" placeholder="Enter Password"
                                                    class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <p><i class="fa fa-bell"></i> If the password has not been created
                                                    or changed, then enter 2 letters of your name and the year of
                                                    your date of birth. <br>Password Example : <code> AJ1998</code>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="btn-wrapper btn-wrapper2">
                                                <?= $this->ki_theme->set_class('btn btn-outline-success')->button('<span><i class="fa fa-sign-in"></i> Login in</span>', 'submit') ?>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const tabLinks = document.querySelectorAll('.tab-link');
    const tabContents = document.querySelectorAll('.tab-content');

    tabLinks.forEach(link => {
        link.addEventListener('click', () => {
            // Remove active class from all links
            tabLinks.forEach(link => link.classList.remove('active'));
            // Add active class to clicked link
            link.classList.add('active');

            // Hide all tab contents
            tabContents.forEach(content => content.classList.remove('active'));

            // Show current tab content
            const targetTab = document.getElementById(link.dataset.tab);
            targetTab.classList.add('active');
        });
    });

</script>