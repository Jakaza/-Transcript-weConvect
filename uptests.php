<?php
session_start();
    require_once('dbconfig.php');
    $subj_code = $_SESSION['code']; 
    if(isset($_GET['update'])){
        $testOld = $_GET['test'];
        $testNew = strtolower($_GET['title']);
        $id = $_GET['assessment_id'];
        $testtime = $_GET['testtime'];


        if(mysqli_query($conn,"UPDATE `assessment` SET assessment_name = '$testNew',testtime = '$testtime' WHERE assessment_id = '$id'")){
                header("Location: viewtests.php?code=$subj_code");
            }
        else{
                echo "error".mysqli_error($conn);
        }
        
    }else{
        echo "error ".mysqli_error($conn);
    }
?>