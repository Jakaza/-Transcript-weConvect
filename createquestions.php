<?php
session_start();
    require_once('dbconfig.php');

    if(isset($_POST['newques'])){
        $guide = $_POST['guidelines'];
        $question_text = $_POST['title'];
        $time = time();
        $o1 = $_POST['option1'];
        $o2 = $_POST['option2'];
        $o3 = $_POST['option3'];
        $ans = $_POST['answer'];
        $assessment_id = $_POST['assessment_id']; 



  
        $res = mysqli_query($conn,"SELECT * FROM `question` WHERE question_text = '$question_text'");
        if(mysqli_num_rows($res) > 0){
            // header("Location: viewquestions.php?test=$test&error");
            echo "Error Occured";
            exit;
        }
        else{
            if(mysqli_query($conn,"INSERT INTO `question`(guidelines,question_text,option1,option2,option3,answer,assessment_id) VALUES('$guide','$question_text','$o1','$o2','$o3','$ans','$assessment_id')")){
                header("Location: viewquestions.php?test=$assessment_id");
            }
            else{
                echo "error".mysqli_error($conn);
            }
        }
    }
?>