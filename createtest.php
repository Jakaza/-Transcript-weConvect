<?php
session_start();
    require_once('dbconfig.php');
    $lang = $_SESSION['lang'];
    if(isset($_POST['newtest']) && isset($_POST['code'])){
        $assessment_name = strtolower($_POST['title']);
        $guide = "";
        $timelimit = $_POST['testtime'];
        $subj_code = $_POST['code'];
        $time = time();
        $test_id = "test_".$time;
        $res = mysqli_query($conn,"SELECT * FROM assessment WHERE assessment_name = '$assessment_name'");
        if(mysqli_num_rows($res) > 0){
            // header("Location: viewtests.php?testlang=$lang&error");
            echo 'Error Occured';
            exit;
        }
        else{
            if(mysqli_query($conn, "INSERT INTO `assessment`(assessment_name,testtime,subj_code) VALUES('$assessment_name','$timelimit','$subj_code')")){
                header("Location: viewtests.php?code=$subj_code");
            }
            else{
                echo "error".mysqli_error($conn);
            }
        }
    }
?>