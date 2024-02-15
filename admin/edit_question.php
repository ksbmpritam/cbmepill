<?php
include("includes/header.php");

require("includes/function.php");
require("language/language.php");

$id = base64_decode($_REQUEST['edit']);
$data_qry = "SELECT * FROM question WHERE `id`= $id ";
mysqli_set_charset($mysqli, "utf8");

$data_result = mysqli_query($mysqli, $data_qry);
$data = mysqli_fetch_assoc($data_result);
if (isset($_POST['update'])) {
    $e_id = $data['e_id'];
    if ($e_id != '') {
        if ($_FILES['big_picture']['name'] != '') {
            $icon = $_FILES['big_picture']['name'];
            $temp = $_FILES['big_picture']['tmp_name'];
            move_uploaded_file($temp, "images/ExamAns/" . $icon);
        } else {
            $icon = $data['image'];
        }

        if ($_FILES['image_opt1']['name'] != '') {
            $image_opt1 = $_FILES['image_opt1']['name'];
            $temp = $_FILES['image_opt1']['tmp_name'];
            move_uploaded_file($temp, "images/ExamAns/" . $image_opt1);
        } else {
            $image_opt1 = $data['image_opt1'];
        }

        if ($_FILES['image_opt2']['name'] != '') {
            $image_opt2 = $_FILES['image_opt2']['name'];
            $temp = $_FILES['image_opt2']['tmp_name'];
            move_uploaded_file($temp, "images/ExamAns/" . $image_opt2);
        } else {
            $image_opt2 = $data['image_opt2'];
        }

        if ($_FILES['image_opt3']['name'] != '') {
            $image_opt3 = $_FILES['image_opt3']['name'];
            $temp = $_FILES['image_opt3']['tmp_name'];
            move_uploaded_file($temp, "images/ExamAns/" . $image_opt3);
        } else {
            $image_opt3 = $data['image_opt3'];
        }


        if ($_FILES['image_opt4']['name'] != '') {
            $image_opt4 = $_FILES['image_opt4']['name'];
            $temp = $_FILES['image_opt4']['tmp_name'];
            move_uploaded_file($temp, "images/ExamAns/" . $image_opt4);
        } else {
            $image_opt4 = $data['image_opt4'];
        }


        $points = isset($_POST['points']) ? $_POST['points'] : 0;
        $is_negative = isset($_POST['is_negative']) ? $_POST['is_negative'] : 0;
        if ($is_negative == 1) {
            $negative_points = isset($_POST['negative_points']) ? $_POST['negative_points'] : 0;
        } else {
            $negative_points = 0;
        }

        $qry = 'UPDATE  `question` SET `e_id`="' . $e_id . '",`Question`="' . $_POST['Question'] . '",`option_1`="' . $_POST['option_1'] . '",`option_2`="' . $_POST['option_2'] . '",`option_3`="' . $_POST['option_3'] . '",`option_4`="' . $_POST['option_4'] . '",`answer`="' . $_POST['answer'] . '",`image`="' . $icon . '"'
                . ',`image_opt1`="' . $image_opt1 . '",`image_opt2`="' . $image_opt2 . '"'
                . ',`image_opt3`="' . $image_opt3 . '" '
                . ',`image_opt4`="' . $image_opt4 . '" '
                . ',`points`="' . $points . '" '
                . ',`is_negative`="' . $is_negative . '" '
                . ',`negative_points`="' . $negative_points . '" '
                . 'WHERE `id`="' . $id . '"';
        $data_ins = mysqli_query($mysqli, $qry);
        if ($data_ins) {
            $_SESSION['msg'] = "11";
            $data_qry = "SELECT * FROM question WHERE `id`= $id ";
            mysqli_set_charset($mysqli, "utf8");

            $data_result = mysqli_query($mysqli, $data_qry);
            $data = mysqli_fetch_assoc($data_result);
        }
    } else {
        echo "<script>alert('You Didn't Select Any Exam. Please Select Exam.');window.location.href='manage_exam.php';</script>";
    }
}
?>

<style>
    td.mngg {
        width: 42%;
    }
    label.col-md-3.control-label.ll {
        font-size: 13px;
    }
</style>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                    <div class="page_title">Edit Question</div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row mrg-top">
                <div class="col-md-12">

                    <div class="col-md-12 col-sm-12">
                        <?php if (isset($_SESSION['msg'])) { ?> 
                            <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <?php echo $client_lang[$_SESSION['msg']]; ?></a> </div>
                            <?php
                            unset($_SESSION['msg']);
                        }
                        ?> 
                    </div>
                </div>
            </div>
            <div class="card-body mrg_bottom"> 
                <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">

                    <div class="section">
                        <div class="section-body">

                            <div class="form-group">
                                <label class="col-md-3 control-label">Points :-</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="points" name="points" style="padding: 6px 12px;" value="<?php echo $data['points'] ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Is include Negative Points ? :-</label>
                                <div class="col-md-6">
                                    <label class="radio-inline"><input type="radio" name="is_negative" value="1" <?php echo ($data['is_negative'] == 1) ? "checked=''" : ""; ?>>Yes</label>
                                    <label class="radio-inline"><input type="radio" name="is_negative" value="0" <?php echo ($data['is_negative'] == 0) ? "checked=''" : ""; ?>>No</label>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group negative_section"  style="display: <?php echo ($data['is_negative'] == 1) ? "block" : "none"; ?>;">
                                <label class="col-md-3 control-label">Negative Points :-</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="negative_points" name="negative_points" style="padding: 6px 12px;" value="<?php echo $data['negative_points'] ?>"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Question :-</label>
                                <div class="col-md-6">
                                    <textarea name="Question" id="editor5"  class="form-control" required><?php echo $data['Question'] ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Image :-<br/><p class="control-label-help">(Recommended resolution: 600x293 or 650x317 or 700x342 or 750x366)</p></label>

                                <div class="col-md-6">
                                    <div class="fileupload_block">
                                        <input type="file" name="big_picture" value="" id="fileupload">
                                        <div class="fileupload_img"><img type="image" src="images/ExamAns/<?php echo $data['image']; ?>" alt="category image" /></div>    
                                    </div>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Correct</th>
                                        <th>Choices</th>
                                        <th>Choice Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>A</td>
                                        <td><input type="radio" name="answer" class="form-control" value="A" <?php
                                            if ($data['answer'] == 'A') {
                                                echo 'checked';
                                            }
                                            ?>></td>
                                        <td><textarea name="option_1" id="editor1"><?php echo $data['option_1']; ?></textarea>

                                        </td>

                                        <td class="mngg">
                                            <label class="col-md-3 control-label ll">Image :-<br/><p class="control-label-help">(Recommended resolution: 600x293 or 650x317 or 700x342 or 750x366)</p></label>

                                            <div class="col-md-9">
                                                <div class="fileupload_block">
                                                    <input type="file" name="image_opt1" value="" id="fileupload">
                                                    <div class="fileupload_img">
                                                        <?php if (empty($data['image_opt1'])) { ?>
                                                            <img type="image" src="assets/images/add-image.png" alt="question image" />
                                                        <?php } else { ?>
                                                            <img type="image" src="images/ExamAns/<?php echo $data['image_opt1']; ?>" alt="Option image" />
                                                        <?php } ?>
                                                    </div>    
                                                </div>
                                            </div>
                                        </td>


                                    </tr>
                                    <tr>
                                        <td>B</td>
                                        <td><input type="radio" name="answer" class="form-control" value="B"  <?php
                                            if ($data['answer'] == 'B') {
                                                echo 'checked';
                                            }
                                            ?>></td>

                                        <td><textarea name="option_2" id="editor2"><?php echo $data['option_2']; ?></textarea></td>

                                        <td class="mngg">
                                            <label class="col-md-3 control-label ll">Image :-<br/><p class="control-label-help">(Recommended resolution: 600x293 or 650x317 or 700x342 or 750x366)</p></label>

                                            <div class="col-md-9">
                                                <div class="fileupload_block">
                                                    <input type="file" name="image_opt2" value="" id="fileupload">
                                                    <div class="fileupload_img">
                                                        <?php if (empty($data['image_opt2'])) { ?>
                                                            <img type="image" src="assets/images/add-image.png" alt="question image" />
                                                        <?php } else { ?>
                                                            <img type="image" src="images/ExamAns/<?php echo $data['image_opt2']; ?>" alt="Option image" />
                                                        <?php } ?>
                                                    </div>    
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>C</td>
                                        <td><input type="radio" name="answer" class="form-control"  value="C"  <?php
                                            if ($data['answer'] == 'C') {
                                                echo 'checked';
                                            }
                                            ?>></td>
                                        <td><textarea name="option_3" id="editor3"><?php echo $data['option_3']; ?></textarea></td>

                                        <td class="mngg">
                                            <label class="col-md-3 control-label ll">Image :-<br/><p class="control-label-help">(Recommended resolution: 600x293 or 650x317 or 700x342 or 750x366)</p></label>

                                            <div class="col-md-9">
                                                <div class="fileupload_block">
                                                    <input type="file" name="image_opt3" value="" id="fileupload">
                                                    <div class="fileupload_img">
                                                        <?php if (empty($data['image_opt3'])) { ?>
                                                            <img type="image" src="assets/images/add-image.png" alt="question image" />
                                                        <?php } else { ?>
                                                            <img type="image" src="images/ExamAns/<?php echo $data['image_opt3']; ?>" alt="Option image" />
                                                        <?php } ?>
                                                    </div>    
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>D</td>
                                        <td><input type="radio" name="answer" class="form-control"  value="D"  <?php
                                            if ($data['answer'] == 'D') {
                                                echo 'checked';
                                            }
                                            ?>></td>
                                        <td><textarea name="option_4" id="editor4"><?php echo $data['option_4']; ?></textarea></td>

                                        <td class="mngg">
                                            <label class="col-md-3 control-label ll">Image :-<br/><p class="control-label-help">(Recommended resolution: 600x293 or 650x317 or 700x342 or 750x366)</p></label>

                                            <div class="col-md-9">
                                                <div class="fileupload_block">
                                                    <input type="file" name="image_opt4" value="" id="fileupload">
                                                    <div class="fileupload_img">
                                                        <?php if (empty($data['image_opt4'])) { ?>
                                                            <img type="image" src="assets/images/add-image.png" alt="question image" />
                                                        <?php } else { ?>
                                                            <img type="image" src="images/ExamAns/<?php echo $data['image_opt4']; ?>" alt="Option image" />
                                                        <?php } ?>
                                                    </div>    
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                            <h1>Use the full-all presets javascript</h1>

                            <script>
                                CKEDITOR.replace('editor1');
                                CKEDITOR.replace('editor2');
                                CKEDITOR.replace('editor3');
                                CKEDITOR.replace('editor4');
                            </script>
                            <script>
                                CKEDITOR.replace('editor5', {
                                    skin: 'moono',
                                    enterMode: CKEDITOR.ENTER_BR,
                                    shiftEnterMode: CKEDITOR.ENTER_P,
                                    toolbar: [{name: 'basicstyles', groups: ['basicstyles'], items: ['Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor']},
                                        {name: 'styles', items: ['Format', 'Font', 'FontSize']},
                                        {name: 'scripts', items: ['Subscript', 'Superscript']},
                                        {name: 'justify', groups: ['blocks', 'align'], items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']},
                                        {name: 'paragraph', groups: ['list', 'indent'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']},
                                        {name: 'links', items: ['Link', 'Unlink']},
                                        {name: 'insert', items: ['Image']},
                                        {name: 'spell', items: ['jQuerySpellChecker']},
                                        {name: 'table', items: ['Table']}
                                    ],
                                });

                            </script>
                            <!--
                            <div class="col-md-9 mrg_bottom link_block">
                            <div class="form-group">
                              <label class="col-md-4 control-label">Video :-<br/>(Optional)
                              <p class="control-label-help">To directly open single video when click on notification</p></label>
                              <div class="col-md-8">
                                <select name="video_id" id="video_id" class="select2" required>
                                  <option value="0">--Select Video--</option>
                            <?php
                            while ($data_row = mysqli_fetch_array($data_result)) {
                                ?>                       
                                                                      <option value="<?php echo $data_row['id']; ?>"><?php echo $data_row['video_title']; ?></option>                           
                                <?php
                            }
                            ?>
                                </select>
                              </div>
                            </div> 
                            <div class="or_link_item">
                            <h2>OR</h2>
                            </div>
                            <div class="form-group">
                              <label class="col-md-4 control-label">External Link :-<br/>(Optional)</label>
                              <div class="col-md-8">
                                <input type="text" name="external_link" id="external_link" class="form-control" value="" placeholder="http://Ksbminfotech.com">
                              </div>
                            </div>   
                          </div>  --> 
                            <div class="form-group">
                                <div class="col-md-9 col-md-offset-3">
                                    <button type="submit" name="update" class="btn btn-primary">Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>       

<script>
    $(document).ready(function () {
        show_negative_section();
        $("input[name='is_negative']").click(function () {
            show_negative_section();
        });

        function show_negative_section() {
            var option = $('input[name="is_negative"]:checked').val();
            if (option == 1) {
                $(".negative_section").show();
            } else {
                $(".negative_section").hide();
            }
        }
        $("#negative_points,#points").keyup(function () {
            var $this = $(this);
            $this.val($this.val().replace(/[^\d.]/g, ''));
        });
        $(".add_question").on('click', function (e) {
            var option = $('input[name="is_negative"]:checked').val();
            var negative_points = $("#negative_points").val();
            if (option == 1 && negative_points == "") {
                alert("Please provide negative points.")
                e.preventDefault();
            }
        });
    });
</script>