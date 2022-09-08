<?php
include "db_conn.php";
session_start();


$sql1="SELECT * FROM status";
$result = mysqli_query($conn,$sql1);
$row=mysqli_fetch_array($result);



if (isset($_SESSION['student_id'])) {


   
    
    
    
    
    
    
if($row['enrolment_done']== 1 && $row['window_open']==0)
     {
     
        echo "We are not accepting requests currently"."<br>";
     }
    
    
    
    
    
    
    
    

else if($row['enrolment_done']==0 && $row['window_open']==0)
     {
     
        echo "We are processing queries right now "."<br>";
     }
    
    
    
    
    
    
else if($row['enrolment_done']==1 && $row['window_open']==1){
     echo "Your results are ready"."<br>";
     
    $sql="SELECT add_flag, sub_flag, with_flag from storage WHERE student_id= '{$_SESSION['student_id']}'";
    
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result);
    if($row['add_flag']==0){
         echo "No entry provided for Addition"."<br>";
    }
    else if($row['add_flag']==2)
    {
        echo "Addition Successful"."<br>";
    }
    else{
        echo "Addition Unsuccessful"."<br>";
    }
    
    
    
    
    if($row['sub_flag']==0){
         echo "No entry provided for Subsitution"."<br>";
    }
    else if($row['sub_flag']==2)
    {
        echo "Subsitution Successful"."<br>";
    }
    else{
        echo "Substituion Unsuccessful"."<br>";
    }
    
    
    
    
    
    if($row['with_flag']==0){
         echo "No entry provided for Withdrawal"."<br>";
    }
    else if($row['with_flag']==2)
    {
        echo "Withdrawal Successful"."<br>";
    }
    else{
        echo "Withdrawal Unsuccessful"."<br>";
    }
    
    
    
     
}
else if($row['enrolment_done']==0 && $row['window_open']==1)

{

    $sql2="SELECT * FROM storage where student_id = '{$_SESSION['student_id']}'";
    $result2 = mysqli_query($conn,$sql2);
   // $row2=mysqli_fetch_array($result2);
    $num_results = mysqli_num_rows($result2);
     if($num_results!=0){
         echo "You have already filled it out"."<br>";
     }
     else{







    
   
    ?>
    
<!DOCTYPE html>

<html>
 
<head>
         <link rel="stylesheet" type="text/css" href="style.css">
    <title>HOME</title>

 

</head>

<body>
    
         <a href = "logout.php" class="logout"> LOGOUT </a>
   
<?php


$stmt =  "SELECT CourseID , CourseName  , SectionID,LecturerName, SectionTiming
    FROM
    (
    SELECT  CourseID , CourseName  , N , SectionID, section_information.lecturer_name as LecturerName, section_information.section_timing AS SectionTiming
    FROM (
    SELECT CID as CourseID, CourseName ,  N , sections.section_id as SectionID
    FROM (
    SELECT course_id as CID ,courses.course_Name as CourseName, courses.number_of_sections as N
    FROM(
       
     SELECT course_id as CID
    FROM del
     WHERE dept_id  = (
     select dept_id from student_departments
    where student_departments.student_id = '{$_SESSION['student_id']}'
     )
    ) as V1
    INNER JOIN courses ON
    CID =courses.course_ID
    ) as V2
    INNER JOIN sections ON
    CID=sections.course_id
    ) as V3
    INNER JOIN section_information ON
    SectionID= section_information.section_id
    ) as F1

    ";
 
$sql=$conn->prepare($stmt);
   
    
//$sql->bind_param("ss",$_SESSION['student_id'],$_SESSION['student_id']);
    
    $sql->execute();
    
    $result = $sql->get_result();
  
  
   ?>
    <h3>DEL AVAILABLE</h3>
   <table border="2">
    <tr>
        <th>Course ID</th>
        <th>Course Name</th>
        <th>Section ID</th>
        <th>Lecturer Name</th>
        <th>Section Timing</th>
    </tr>

   
    <?php
    while ($row = $result->fetch_assoc()) {
  
      ?>
      <tr>
       <td> <?php echo $row['CourseID']." "; ?> </td>
       <td> <?php echo $row['CourseName']." "; ?> </td>
       <td> <?php echo $row['SectionID']." "; ?> </td>
       <td> <?php echo $row['LecturerName']." "; ?> </td>
       <td> <?php echo $row['SectionTiming']." "; ?> </td>
   </tr>
    <?php
}
    
    
?>

</table>

<?php
   

    $result->close();
    $sql->close();
    
    
    
    
   $stmt1= "SELECT CourseID , CourseName  , SectionID,LecturerName, SectionTiming
        FROM
        (
        SELECT  CourseID , CourseName  , N , SectionID, section_information.lecturer_name as LecturerName, section_information.section_timing AS SectionTiming
        FROM (
        SELECT CID as CourseID, CourseName ,  N , sections.section_id as SectionID
        FROM (
        SELECT course_id as CID ,courses.course_Name as CourseName, courses.number_of_sections as N
        FROM(
           
         SELECT course_id as CID
        FROM huel_opel
         WHERE dept_id  <> (
         select dept_id from student_departments
        where student_departments.student_id = '{$_SESSION['student_id']}'
         )
        ) as V1
        INNER JOIN courses ON
        CID =courses.course_ID
        ) as V2
        INNER JOIN sections ON
        CID=sections.course_id
        ) as V3
        INNER JOIN section_information ON
        SectionID= section_information.section_id
        ) as F1
";
    
    $sql1=$conn->prepare($stmt1);
       
        
    //$sql1->bind_param("ss",$_SESSION['student_id'],$_SESSION['student_id']);
        
        $sql1->execute();
        
        $result1 = $sql1->get_result();
    //$resultOPEL = $sql1->get_result();
      
       ?>
    
        <h3>OPEL/HUEL AVAILABLE</h3>
       <table border="2">
        <tr>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Section ID</th>
            <th>Lecturer Name</th>
            <th>Section Timing</th>
        </tr>

       
        <?php
        while ($row = $result1->fetch_assoc()) {
      
          ?>
          <tr>
           <td> <?php echo $row['CourseID']." "; ?> </td>
           <td> <?php echo $row['CourseName']." "; ?> </td>
           <td> <?php echo $row['SectionID']." "; ?> </td>
           <td> <?php echo $row['LecturerName']." "; ?> </td>
           <td> <?php echo $row['SectionTiming']." "; ?> </td>
       </tr>
        <?php
    }
        
        
    ?>

    </table>

    <?php
        $result1->close();
        $sql1->close();
    
    
  
    
    
    
   $stmt2= "SELECT dept_id, course_id ,course_name, section_id , section_timing , lecturer_name
FROM
(

SELECT K3.course_id, courses.course_name, section_id, section_timing, lecturer_name, courses.dept_id
FROM
(
SELECT sections.course_id, sections.section_id, section_timing, lecturer_name
FROM
(
SELECT K1.section_id , section_information.lecturer_name , section_information.section_timing
FROM (
SELECT section_id
FROM enrolment
WHERE student_id = ?
) as K1
INNER JOIN section_information
ON K1.section_id = section_information.section_id
) as K2
INNER JOIN sections
ON  sections.section_id=K2.section_id
) as K3
INNER JOIN courses
ON courses.course_ID= K3.course_id
) as K4
WHERE K4.course_id NOT IN (

SELECT course_id
FROM cdc
WHERE
dept_id=(
SELECT dept_id
FROM student_departments
WHERE student_id= ?
)
) ";
    
    $sql2=$conn->prepare($stmt2);
       
        
    $sql2->bind_param("ss",$_SESSION['student_id'],$_SESSION['student_id']);
        
        $sql2->execute();
        
        $result2 = $sql2->get_result();
     //$resultNON = $sql2->get_result();
      
       ?>
    
        <h3>CURRENT NON-CDC</h3>
       <table border="2">
        <tr>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Section ID</th>
            <th>Lecturer Name</th>
            <th>Section Timing</th>
        </tr>

       
        <?php
        while ($row = $result2->fetch_assoc()) {
      
          ?>
          <tr>
           <td> <?php echo $row['course_id']." "; ?> </td>
           <td> <?php echo $row['course_name']." "; ?> </td>
           <td> <?php echo $row['section_id']." "; ?> </td>
           <td> <?php echo $row['lecturer_name']." "; ?> </td>
           <td> <?php echo $row['section_timing']." "; ?> </td>
       </tr>
        <?php
    }
        
        
    ?>

    </table>
    
    
    
    
    <?php
        $result2->close();
        $sql2->close();
    
    
    
    
    
    
    

    
    
    
    
    
  

    

?>
    
    
    
  
    <fieldset>
    <legend>Fill Details</legend>
    
    
    
    
    <form name="frmContact" method="post" action="final.php">
    <p>
    
    
    <?php

    $link = mysqli_connect('localhost','root','','test');

    $sql = "SELECT SectionID
    FROM
    (
    SELECT  SectionID,CourseID
            FROM
            (
            SELECT  CourseID , CourseName  , N , SectionID, section_information.lecturer_name as LecturerName, section_information.section_timing AS SectionTiming
            FROM (
            SELECT CID as CourseID, CourseName ,  N , sections.section_id as SectionID
            FROM (
            SELECT course_id as CID ,courses.course_Name as CourseName, courses.number_of_sections as N
            FROM(
               
             SELECT course_id as CID
            FROM huel_opel
             WHERE dept_id  <> (
             select dept_id from student_departments
            where student_departments.student_id = '{$_SESSION['student_id']}'
             )
            ) as V1
            INNER JOIN courses ON
            CID =courses.course_ID
            ) as V2
            INNER JOIN sections ON
            CID=sections.course_id
            ) as V3
            INNER JOIN section_information ON
            SectionID= section_information.section_id
            ) as F1

            WHERE F1.SectionTiming
            NOT IN
            (
            SELECT section_timing
            FROM section_information
            INNER JOIN (SELECT section_id as SectionId
            FROM enrolment
            where enrolment.student_id = '{$_SESSION['student_id']}') as v1
            ON
            V1.SectionID=section_information.section_id
            )
            
            
            UNION
            
            SELECT  SectionID, CourseID
        FROM
        (
        SELECT  CourseID , CourseName  , N , SectionID, section_information.lecturer_name as LecturerName, section_information.section_timing AS SectionTiming
        FROM (
        SELECT CID as CourseID, CourseName ,  N , sections.section_id as SectionID
        FROM (
        SELECT course_id as CID ,courses.course_Name as CourseName, courses.number_of_sections as N
        FROM(
           
         SELECT course_id as CID
        FROM del
         WHERE dept_id  = (
         select dept_id from student_departments
        where student_departments.student_id = '{$_SESSION['student_id']}'
         )
        ) as V1
        INNER JOIN courses ON
        CID =courses.course_ID
        ) as V2
        INNER JOIN sections ON
        CID=sections.course_id
        ) as V3
        INNER JOIN section_information ON
        SectionID= section_information.section_id
        ) as F1

        WHERE F1.SectionTiming
        NOT IN
        (
        SELECT section_timing
        FROM section_information
        INNER JOIN (SELECT section_id as SectionId
        FROM enrolment
        where enrolment.student_id = '{$_SESSION['student_id']}'
        
    
    ) as v1
        ON
        V1.SectionID=section_information.section_id
        )
        
         order  by SectionID

         ) as KK
         WHERE KK.CourseID  NOT IN
         (
         
               select course_id from sections
               INNER JOIN
               (
                  
                  SELECT section_id FROM enrolment WHERE student_id = '{$_SESSION['student_id']}'
              )
              as KKK
              
           ON   KKK.section_id=sections.section_id
         )

    ";
    
   

    $result = mysqli_query($link,$sql);
    if ($result != 0) {
        echo '<label for = "ADD">Addition SectionID:';
        echo '<select name="ADD">';
        echo '<option value="none">none</option>';

        $num_results = mysqli_num_rows($result);
        for ($i=0;$i<$num_results;$i++) {
            $row = mysqli_fetch_array($result);
            $name = $row['SectionID'];
            echo '<option value="' .$name. '">' .$name. '</option>';
        }

        echo '</select>';
        echo '</label>';
    }

    mysqli_close($link);

    ?>

    
    <?php

    $link = mysqli_connect('localhost','root','','test');

    $sql = "SELECT section_id
FROM
(

SELECT K3.course_id, courses.course_name, section_id, section_timing, lecturer_name, courses.dept_id
FROM
(
SELECT sections.course_id, sections.section_id, section_timing, lecturer_name
FROM
(
SELECT K1.section_id , section_information.lecturer_name , section_information.section_timing
FROM (
SELECT section_id
FROM enrolment
WHERE student_id = '{$_SESSION['student_id']}'
) as K1
INNER JOIN section_information
ON K1.section_id = section_information.section_id
) as K2
INNER JOIN sections
ON  sections.section_id=K2.section_id
) as K3
INNER JOIN courses
ON courses.course_ID= K3.course_id
) as K4
WHERE K4.course_id NOT IN (

SELECT course_id
FROM cdc
WHERE
dept_id=(
SELECT dept_id
FROM student_departments
WHERE student_id= '{$_SESSION['student_id']}'
)
) ";
    
   // $sql2=$link->prepare($sql);
       
        
   // $sql2->bind_param("ss",$_SESSION['student_id'],$_SESSION['student_id']);

    $result = mysqli_query($link,$sql);
    if ($result != 0) {
        echo '<label for = "SUB1">Substitution SectionID(one you want to remove):';
        echo '<select name="SUB1">';
        echo '<option value="none">none</option>';

        $num_results = mysqli_num_rows($result);
        for ($i=0;$i<$num_results;$i++) {
            $row = mysqli_fetch_array($result);
            $name = $row['section_id'];
            echo '<option value="' .$name. '">' .$name. '</option>';
        }

        echo '</select>';
        echo '</label>';
    }

    mysqli_close($link);

    ?>
    
    
    <?php

    $link = mysqli_connect('localhost','root','','test');

    $sql = "SELECT SectionID
 FROM
 (
 SELECT  SectionID,CourseID
         FROM
         (
         SELECT  CourseID , CourseName  , N , SectionID, section_information.lecturer_name as LecturerName, section_information.section_timing AS SectionTiming
         FROM (
         SELECT CID as CourseID, CourseName ,  N , sections.section_id as SectionID
         FROM (
         SELECT course_id as CID ,courses.course_Name as CourseName, courses.number_of_sections as N
         FROM(
            
          SELECT course_id as CID
         FROM huel_opel
          WHERE dept_id  <> (
          select dept_id from student_departments
         where student_departments.student_id = '{$_SESSION['student_id']}'
          )
         ) as V1
         INNER JOIN courses ON
         CID =courses.course_ID
         ) as V2
         INNER JOIN sections ON
         CID=sections.course_id
         ) as V3
         INNER JOIN section_information ON
         SectionID= section_information.section_id
         ) as F1

         WHERE F1.SectionTiming
         NOT IN
         (
        SELECT enrolment.section_id as SectionId
     FROM enrolment
      INNER JOIN (
      Select sections.section_id from cdc
       inner join sections
       on
       sections.course_id = cdc.course_id)
       as T
       
       ON enrolment.student_id = '{$_SESSION['student_id']}'   AND enrolment.section_id=T.section_id
         )
         
         
         UNION
         
         SELECT  SectionID, CourseID
     FROM
     (
     SELECT  CourseID , CourseName  , N , SectionID, section_information.lecturer_name as LecturerName, section_information.section_timing AS SectionTiming
     FROM (
     SELECT CID as CourseID, CourseName ,  N , sections.section_id as SectionID
     FROM (
     SELECT course_id as CID ,courses.course_Name as CourseName, courses.number_of_sections as N
     FROM(
        
      SELECT course_id as CID
     FROM del
      WHERE dept_id  = (
      select dept_id from student_departments
     where student_departments.student_id = '{$_SESSION['student_id']}'
      )
     ) as V1
     INNER JOIN courses ON
     CID =courses.course_ID
     ) as V2
     INNER JOIN sections ON
     CID=sections.course_id
     ) as V3
     INNER JOIN section_information ON
     SectionID= section_information.section_id
     ) as F1

     WHERE F1.SectionTiming
     NOT IN
     (
     SELECT section_timing
     FROM section_information
     INNER JOIN
     
     (SELECT enrolment.section_id as SectionId
     FROM enrolment
      INNER JOIN (
      Select sections.section_id from cdc
       inner join sections
       on
       sections.course_id = cdc.course_id)
       as T
       
       ON enrolment.student_id = '{$_SESSION['student_id']}'   AND enrolment.section_id=T.section_id
    

     
 
    ) as v1
     
     ON

 
     V1.SectionID=section_information.section_id
     )
     
      order  by SectionID

      ) as KK
      WHERE KK.CourseID  NOT IN
      (
      
            select course_id from sections
            INNER JOIN
            (
               
               SELECT section_id FROM enrolment WHERE student_id = '{$_SESSION['student_id']}'
           )
           as KKK
           
        ON   KKK.section_id=sections.section_id
      )
 


 ";
    
   

    $result = mysqli_query($link,$sql);
    if ($result != 0) {
        echo '<label for = "SUB2">Substitution SectionID(one you want to add):';
        echo '<select name="SUB2">';
        echo '<option value="none">none</option>';

        $num_results = mysqli_num_rows($result);
        for ($i=0;$i<$num_results;$i++) {
            $row = mysqli_fetch_array($result);
            $name = $row['SectionID'];
            echo '<option value="' .$name. '">' .$name. '</option>';
        }

        echo '</select>';
        echo '</label>';
    }

    mysqli_close($link);

    ?>

    
    
    
    
    
    <?php

    $link = mysqli_connect('localhost','root','','test');

    $sql = "SELECT section_id
FROM
(

SELECT K3.course_id, courses.course_name, section_id, section_timing, lecturer_name, courses.dept_id
FROM
(
SELECT sections.course_id, sections.section_id, section_timing, lecturer_name
FROM
(
SELECT K1.section_id , section_information.lecturer_name , section_information.section_timing
FROM (
SELECT section_id
FROM enrolment
WHERE student_id = '{$_SESSION['student_id']}'
) as K1
INNER JOIN section_information
ON K1.section_id = section_information.section_id
) as K2
INNER JOIN sections
ON  sections.section_id=K2.section_id
) as K3
INNER JOIN courses
ON courses.course_ID= K3.course_id
) as K4
WHERE K4.course_id NOT IN (

SELECT course_id
FROM cdc
WHERE
dept_id=(
SELECT dept_id
FROM student_departments
WHERE student_id= '{$_SESSION['student_id']}'
)
) ";
    
   // $sql2=$link->prepare($sql);
       
        
   // $sql2->bind_param("ss",$_SESSION['student_id'],$_SESSION['student_id']);

    $result = mysqli_query($link,$sql);
    if ($result != 0) {
        echo '<label for ="WITH">Withdrawal SectionID';
        echo '<select name="WITH">';
        echo '<option value="none">none</option>';

        $num_results = mysqli_num_rows($result);
        for ($i=0;$i<$num_results;$i++) {
            $row = mysqli_fetch_array($result);
            $name = $row['section_id'];
            echo '<option value="' .$name. '">' .$name. '</option>';
        }

        echo '</select>';
        echo '</label>';
    }

    mysqli_close($link);

    ?>

    
    
    
    
    
    
   
    
    
    <p>&nbsp;</p>
    <p>
    <input type="submit" name="Submit" id="Submit" value="Submit">
    </p>
    </form>
    </fieldset>
         
       


</body>
</html>
<?php
    
    $conn->close();
}
}


}
else{

     header("Location: index.php");

     exit();

}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<a href = "logout.php" class="logout"> LOGOUT </a>
