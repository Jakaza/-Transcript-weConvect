<?php
    session_start();
    require_once('dbconfig.php');
    $id = $_SESSION['adminsession'];   
    if($id == null){
        header('Location: admin.php');
    }
    if(isset($_GET['viewtest']) || isset($_GET['code'])){
        $subj_code = $_GET['code'];
        $_SESSION['code'] = $subj_code;
 

        $result=mysqli_query($conn,"SELECT * FROM subject WHERE subj_code = '$subj_code'");


        // $result=mysqli_query($conn,"SELECT * FROM subject JOIN assessment ON subject.subj_code = assessment.subj_code WHERE subject.subj_code = '$subj_code'");
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)) {

                // var_dump($row);
                // exit;
                
                $_SESSION['adminsession'] = $id;

            ?>



<!DOCTYPE html>
<html>

<head>
    <title>Welcome Online Exam</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" type="text/css" href="css/font/flaticon.css">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans|Josefin+Sans" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="description" content="Online Exam">
    <meta name="author" content="Akhil Regonda">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
                            require_once('dbconfig.php');
                        ?>
</head>

<body>
    <div class="oq-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class=""><a href="index.php"><img src="images/quiz.png" class="oq-logo"></a></div>
                </div>
                <div class="col-md-8">
                    <div class="oq-userArea pull-right">
                        <a href="adminmenu.php"><span
                                class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Home</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a class="oq-btn" href="logout.php?logout">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="oq-viewTestsBody">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="oq-viewTests">
                        <div class="oq-testsHead">
                            <span class="oq-testsHeadText"><?php echo strtoupper($subj_code);?></span>
                            <div class="pull-right">
                                <?php
                                                        if(isset($_GET['error'])){
                                                            echo "<span class='oq-error'>*Test already exists! </span>";
                                                        }
                                                    ?>
                                <a class="oq-addbtn" data-toggle="modal" data-target=".newtest">Add New Test</a>
                            </div><br><br>
                            <span>List of tests are shown below:</span>
                        </div>
                        <div class="modal fade newtest" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form class="form" action="createtest.php" method="post">
                                            <span>Test Title</span><br><br>
                                            <input type="text" class="form-control" placeholder="Enter test title"
                                                name="title" required><br><br>
                                            <span>Test Time</span><br><br>
                                            <input type="text" class="form-control"
                                                placeholder="Time limit for the test (in minutes)" name="testtime"
                                                required><br> <br>

                                            <input type="hidden" class="form-control" placeholder="" name='code'
                                                value='<?php echo $subj_code?>' hidden="true">

                                            <br>

                                            <input type="submit" class="form-control oq-btn" value="Create"
                                                name="newtest">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <table class="table oq-table">
                            <tbody>
                                <?php
                                                        // $res = mysqli_query($conn,"SELECT * FROM assessment");
                                                        $res=mysqli_query($conn,"SELECT * FROM subject JOIN assessment ON subject.subj_code = assessment.subj_code WHERE subject.subj_code = '$subj_code'");
                                                            if(mysqli_num_rows($res) > 0){
                                                                echo "<tr><th>S no.</th><th>Test Name</th><th>Time</th><th>Operations</th></tr>";
                                                                $i=1;
                                                                while($row1 = mysqli_fetch_assoc($res)) {
                                                               echo "<tr><td>".$i."</td><td>".ucfirst($row1['assessment_name'])."</td><td>".$row1['testtime']." Mins</td><td class='oq-testsoperations'><a data-toggle='modal' data-target='.".$row1['assessment_id']."' class='oq-editbtn'><span class='glyphicon glyphicon-pencil'></span> Edit</a> &nbsp;<a href='viewquestions.php?test=".$row1['assessment_id']."' class='oq-btn'><span class='glyphicon glyphicon-pencil'></span> Add/Modify questions</a> &nbsp;<a data-toggle='modal' data-target='.del".$row1['assessment_id']."' class='oq-deletebtn'><span class='glyphicon glyphicon-remove'></span> Delete</a></td></tr>";
                                                                    $i++;
                                                                    
                                                                    echo "<div class='modal fade ".$row1['assessment_id']."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel'>
                                                                          <div class='modal-dialog' role='document'>
                                                                            <div class='modal-content'>
                                                                                <div class='modal-body'>
                                                                                    <form class='form' action='uptests.php' method='get'>
                                                                                        <input type='hidden' value='".$row1['assessment_id']."' name='assessment_id'>
                                                                                        <input type='hidden' value='".$row1['assessment_name']."' name='test'>
                                                                                        <span>Test Title</span><br><br>
                                                                                        <input type='text' class='form-control' value='".$row1['assessment_name']."' name='title' required><br><br>


                                                                                        <span>Time Limit</span><br><br>
                                                                                        <input type='text' class='form-control' value='".$row1['testtime']."' name='testtime' required><br>
                                                                                        <input type='submit' class='form-control oq-btn' value='Update' name='update'>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                          </div>
                                                                        </div>";
                                                                    
                                                                    
                                                                    echo "<div class='modal fade del".$row1['assessment_id']."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel'>
                                                                              <div class='modal-dialog modal-sm' role='document'>
                                                                                <div class='modal-content'>
                                                                                    <div class='modal-body'>
                                                                                        <div class='oq-questionModal'>
                                                                                            <span>Are you sure you want to delete?</span><br><br>
                                                                                            <form class='form' action='quesdel.php' method='post'>
                                                                                                <input type='hidden' name='assessment_id' value='".$row1['assessment_id']."'>
                                                                                                <input type='submit' name='testdelete' value='Yes' class='oq-deletebtn form-control' required><br>
                                                                                                <input type='button' value='No' class='oq-btn form-control' data-dismiss='modal'> 
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                              </div>
                                                                            </div>";
                                                            }
                                                        }
                                                        else{
                                                            echo "<span class='oq-news'>No tests available</span>";
                                                        }
                                                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="oq-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6"><span class="oq-footerText">ONLINE QUIZ 2023</span></div>
                <div class="col-md-6"><span class="oq-footerText pull-right">Developed by - <a href="#"><span
                                class="oq-footerBy">W<span class="oq-footerSubName">econvect</span> T<span
                                    class="oq-footerSubName">ext</span></span></a></span></div>
            </div>
        </div>
    </div>
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>

</html>
<?php
                }
        }
    }
?>