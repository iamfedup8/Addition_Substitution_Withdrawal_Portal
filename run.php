<?php

include "db_conn.php";

session_start();


    
    
    //withdrawal part
    
   
    $sql1="SELECT * FROM status";
    $result = mysqli_query($conn,$sql1);
    $row1=mysqli_fetch_array($result);
  
    
   if( $row1['enrolment_done'] == 0){
    
   
    $stm="SELECT storage.student_id, storage.with_id, students.pr_number from storage
               INNER JOIN students
                ON   storage.student_id= students.student_id
                         order by pr_number;";
    $result= mysqli_query($conn,$stm);
     
    $num_results = mysqli_num_rows($result);
    for ($i=0;$i<$num_results;$i++) {
        $row = mysqli_fetch_array($result);
        $w = $row['with_id'];
        $s= $row['student_id'];
        
        if($w==0){
            $sql="UPDATE storage set with_flag = 0 WHERE student_id=  '{$s}'";
            $conn->query($sql);
        }
        else{
            $sql="UPDATE storage set with_flag = 1 WHERE student_id=  '{$s}'";
            $conn->query($sql);
            
            $sql1="DELETE FROM enrolment WHERE section_id= {$w} AND student_id= '{$s}' ";
            $conn->query($sql1);
            
            $sql2="UPDATE section_information
                     SET current_number=current_number-1
                     WHERE section_id= {$w} ";
            $conn->query($sql2);
            
             $sql3="UPDATE storage set with_flag = 2 WHERE student_id=  '{$s}'";
            $conn->query($sql3);
            
        }
        
        
        
    }
       
       
    
    
    
    
    
    
    //substitution part
    
    
    
   
    
    
    $stm1="SELECT storage.student_id, storage.sub1_id,storage.sub2_id, students.pr_number from      storage
               INNER JOIN students
                ON   storage.student_id= students.student_id
                order by pr_number";
    $result1= mysqli_query($conn,$stm1);
   
    $num_results1 = mysqli_num_rows($result1);
    for ($i=0;$i<$num_results1;$i++) {
        
        $row = mysqli_fetch_array($result1);
       
        $sub1 = $row['sub1_id'];
        $sub2 = $row['sub2_id'];
        $s= $row['student_id'];
       
        if($sub1==0 || $sub2==0){
           
            $sql="UPDATE storage set sub_flag = 0 WHERE student_id=  '{$s}'";
            $conn->query($sql);
        }
        else{
          
            $sql22="SELECT * FROM
            (
            SELECT * from
            enrolment
            where student_id= '{$s}'
            ) as K
            where K.section_id= {$sub1}";
            $result2= mysqli_query($conn,$sql22);
            $num_results2 = mysqli_num_rows($result2);
            
           
            
           
            
           
            
            
            
            
            
            
            
            
            
            
            
            
            
           
            
            
            if($num_results2==0){
               
                $sql="UPDATE storage set sub_flag = 1 WHERE student_id= '{$s}'";
                $conn->query($sql);
            }
            
            else{
              
                
                $sql23="SELECT * FROM
    (
    SELECT section_id, current_number, max_number, section_timing
    FROM section_information
    WHERE section_id={$sub2}
    ) as K
    WHERE K.section_timing = (
    SELECT section_timing
    FROM section_information
    WHERE section_id={$sub1}
    )
    OR
    K.section_timing NOT IN
    (
    SELECT section_timing
            FROM section_information
            INNER JOIN (SELECT section_id as SectionId
            FROM enrolment
            where enrolment.student_id = '{$s}') as v1
            ON
            V1.SectionID=section_information.section_id
    )";
                
                $result3= mysqli_query($conn,$sql23);
                $num_results3 = mysqli_num_rows($result3);
                $row3 = mysqli_fetch_array($result3);
                if($num_results3==0 || $row3['current_number']>= $row3['max_number']){
                    $sql="UPDATE storage set sub_flag = 1 WHERE student_id=  '{$s}'";
                    $conn->query($sql);
                }
                else{
                
                    $sql15="DELETE FROM enrolment WHERE section_id= {$sub1} AND student_id= '{$s}' ";
                    $conn->query($sql15);
                    
                    $sql25="UPDATE section_information
                             SET current_number=current_number-1
                             WHERE section_id= {$sub1} ";
                    $conn->query($sql25);
                    
                    
                    
                        $sql35="INSERT INTO enrolment (section_id,student_id) Values ({$sub2},'{$s}') ";
                    $conn->query($sql35);
                        
                        $sql45="UPDATE section_information
                                 SET current_number=current_number+1
                                 WHERE section_id= {$sub2} ";
                    $conn->query($sql45);
                    
                    
                    
                    
                    
                    
                     $sql55="UPDATE storage set sub_flag = 2 WHERE student_id=  '{$s}'";
                    $conn->query($sql55);
                    
                    
                    
                
                }
                
                
                
                
                
                
                
            
            
                }
            
        }
        
        
        
    }
    
    
    
    
    //addition part
  
    
    $stm1="SELECT storage.student_id, storage.addition_id, students.pr_number from      storage
               INNER JOIN students
                ON   storage.student_id= students.student_id
                order by pr_number";
    $result1= mysqli_query($conn,$stm1);
     
    $num_results1 = mysqli_num_rows($result1);
    for ($i=0;$i<$num_results1;$i++) {
        $row = mysqli_fetch_array($result1);
        $add = $row['addition_id'];
        $s= $row['student_id'];
        
       $sql=" SELECT * FROM
    (
    SELECT section_id, current_number, max_number, section_timing
    FROM section_information
    WHERE section_id={$add}
    ) as K
    WHERE
    K.section_timing NOT IN
    (
    SELECT section_timing
            FROM section_information
            INNER JOIN (SELECT section_id as SectionId
            FROM enrolment
            where enrolment.student_id = '{$s}') as v1
            ON
            V1.SectionID=section_information.section_id
    ) ";
        
        $result22= mysqli_query($conn,$sql);
         
        $num_results5 = mysqli_num_rows($result22);
        
        $row111= mysqli_fetch_array($result22);
        if($add==0){
            $sql="UPDATE storage set add_flag = 0 WHERE student_id =  '{$s}'";
            $conn->query($sql);
        }
        
       else if($num_results5==0 ||  $row111['current_number'] >= $row111['max_number']){
            $sql="UPDATE storage set add_flag = 1 WHERE student_id =  '{$s}'";
            $conn->query($sql);
        }
        else{
            
            
            $sql35="INSERT INTO enrolment (section_id,student_id) Values ({$add},'{$s}') ";
        $conn->query($sql35);
            
            $sql45="UPDATE section_information
                     SET current_number=current_number+1
                     WHERE section_id= {$add} ";
        $conn->query($sql45);
        
        
        
        
        
        
         $sql55="UPDATE storage set add_flag = 2 WHERE student_id=  '{$s}'";
            
        $conn->query($sql55);
        
            
            
        }
        
        
        
        
        
        
        }
    
    
    echo "Processed"."<br>";
    
    $sql1="DELETE FROM status";
    $conn->query($sql1);
    $sql2="INSERT INTO `status`(`enrolment_done`, `window_open`) VALUES ('1','1')";
    $conn->query($sql2);
    
 }
    else
        {
             echo "Enrolment has already been processed or tables have been cleared";
        }
     

?>


<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<a href = "logout.php" class="logout"> LOGOUT </a>
