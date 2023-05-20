<?php
    session_start();
    require_once('dbconfig.php');
    $id = $_SESSION['adminsession'];   
    $subj_code = $_SESSION['code']; 
    if($id == null){
        header('Location: admin.php');
    }
    if(isset($_POST['qusdelete'])){
        $test = $_SESSION['test'];
        $testtitle = $lang.'-'.$test;
        $qid = $_POST['delval'];
        if(mysqli_query($conn,"DELETE FROM `$testtitle` WHERE q_id = '$qid'")){
            header("Location: viewquestions.php?test=$test");
        }
        
    }
    if(isset($_POST['testdelete'])){
        $assessment_id = $_POST['assessment_id'];

        if( mysqli_query($conn,"DELETE FROM question  WHERE assessment_id = '$assessment_id'")){
            if( mysqli_query($conn,"DELETE FROM assessment  WHERE assessment_id = '$assessment_id'")){
                header("Location: viewtests.php?code=".$subj_code);
            }
            else{
                echo "error ".mysqli_error($conn);
            }
        }else{
            echo "error ".mysqli_error($conn);
        }

    }
    if(isset($_GET['subjectdelete'])){
        $sub = $_GET['testlang'];
        $res=mysqli_query($conn,"SELECT tests FROM `$sub`");
        if(mysqli_num_rows($res)>0){
            while($row = mysqli_fetch_assoc($res)){
                $testtitle = $sub.'-'.$row['tests'];
                if(mysqli_query($conn,"DROP TABLE `$testtitle`")){
                    
                }
                else{
                    echo "error ".mysqli_error($conn);
                }
                
            }
        }
        if(mysqli_query($conn,"DROP TABLE `$sub`") && mysqli_query($conn,"DELETE FROM lang WHERE subjects = '$sub'")){
            header("Location: index.php");
        }
        else{
            echo "error ".mysqli_error($conn);
        }
        
    }
?>