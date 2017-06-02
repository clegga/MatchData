<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Search Details</title>
      <script type="text/javascript">
            function Redirect() {
               window.location="http://localhost/match/lookupname.html";
            }
            //function Return2() {
               //window.history.go(-1);
               //window.location="http://localhost/match/searchName.php";
            //}
      </script>
</head>
<body>
  <h2>Search Details</h2>

    <form method="post" action="">
      <table>
        <tr>
          <td>
            <input type="hidden" name="firstname" value=<?php $first_name = $_POST['firstname'];echo $first_name;?>>
            <input type="hidden" name="lastname" value=<?php $last_name = $_POST['lastname'];echo $last_name;?>>
            <input type="hidden" name="cddid" value=<?php $cdd_id = $_POST['cddid'];echo $cdd_id;?>>
            <input type="submit" name="prevPos" value="Previous Position"/>
          </td>
          <td>
            <input type="hidden" name="firstname" value=<?php $first_name = $_POST['firstname'];echo $first_name;?>>
            <input type="hidden" name="lastname" value=<?php $last_name = $_POST['lastname'];echo $last_name;?>>
            <input type="hidden" name="cddid" value=<?php $cdd_id = $_POST['cddid'];echo $cdd_id;?>>
            <input type="submit" name="job_match" value="Job Match"/>
          </td>
          <td>
            <input type="hidden" name="firstname" value=<?php $first_name = $_POST['firstname'];echo $first_name;?>>
            <input type="hidden" name="lastname" value=<?php $last_name = $_POST['lastname'];echo $last_name;?>>
            <input type="hidden" name="cddid" value=<?php $cdd_id = $_POST['cddid'];echo $cdd_id;?>>
            <input type="submit" name="employment" value="Employment"/>
          </td>
          <td>
            <input type="hidden" name="firstname" value=<?php $first_name = $_POST['firstname'];echo $first_name;?>>
            <input type="hidden" name="lastname" value=<?php $last_name = $_POST['lastname'];echo $last_name;?>>
            <input type="hidden" name="cddid" value=<?php $cdd_id = $_POST['cddid'];echo $cdd_id;?>>
            <input type="submit" name="training" value="Training"/>
          </td>
          <td>
            <input type="hidden" name="firstname" value=<?php $first_name = $_POST['firstname'];echo $first_name;?>>
            <input type="hidden" name="lastname" value=<?php $last_name = $_POST['lastname'];echo $last_name;?>>
            <input type="hidden" name="cddid" value=<?php $cdd_id = $_POST['cddid'];echo $cdd_id;?>>
            <input type="submit" name="ipt_match" value="IPT Match"/>
          </td>
        </tr>
      </table>    
    </form>             
              <form method="post" action="searchName.php">
              <table>
              <tr>
              <td>
                <input type="text" name="firstname" value=<?php $first_name = $_POST['firstname'];echo $first_name;?>>
                <input type="text" name="lastname" value=<?php $last_name = $_POST['lastname'];echo $last_name;?>>
                <input type="submit" value="Search again" name="search_again"/>
              </td>
              <td>
                <input type="button" name="search_again" value="New Search" onclick="Redirect();" />
              </td>              
              </tr>
              </table>
              </form>            

<?php

  $dbc = mysqli_connect('localhost','clegga','test','matchjob_manc') or die('Error connecting to SQL database');

    if(isset($_POST['prevPos']))
    {
        //echo("You clicked button one!");
        //and then execute a sql query here
        $query = "SELECT c.`CDD_id`, 
        CAST(AES_DECRYPT(c.`CDD_forename`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) AS forename, 
        CAST(AES_DECRYPT(c.`CDD_surname`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) AS surname, 
        k.`CVP_position_no` AS CVPpositionno,
        k.`CVP_position` AS CVPPosition,
        k.`CVP_DIR_id` AS CVPDirID,
        k.`CVP_DIR_desc` AS CVPDIRDesc,
        k.`CVP_DSA_id` AS CVPDSAID,
        k.`CVP_DSA_name` AS CVPDSAName,
        k.`CVP_grade` AS CVPGrade,
        k.`CVP_position_dateStart` AS CVPPositionDateStart,
        k.`CVP_end_of_contract` AS CVPEndOfContract,
        k.`CVP_datetimeInserted` AS DateTimeInserted
        FROM candidate c
        LEFT OUTER JOIN cdd_prev_position k on `CDD_id` = `CVP_CDD_id`
        WHERE c.`CDD_id` = '$cdd_id' 
        ORDER BY surname, CVPpositionno ASC; ";

        $result = mysqli_query($dbc,$query) or die('Error querying the database');

        echo "Here are your results for".": "."$first_name" ." ". "$last_name" . '<br/>';
        //echo $result;
        echo "<table>
        <tr>
        <th>CVP Position No</th>
        <th>CVP Position</th>
        <th>CVP Dir ID</th>
        <th>CVP Dir Description</th>
        <th>CVP DSA id</th>
        <th>CVP DSA Name</th>
        <th>CVP Grade</th>                
        <th>CVP Position Date Start</th>
        <th>CVP End Of Contract</th>
        <th>Date Time Inserted</th>
        </tr>";
        while ($row = mysqli_fetch_array($result))
          {
          echo "<tr>";
          echo "<td>" . $row['CVPpositionno'] . "</td>";
          echo "<td>" . $row['CVPPosition'] . "</td>";
          echo "<td>" . $row['CVPDirID'] . "</td>";
          echo "<td>" . $row['CVPDIRDesc'] . "</td>";
          echo "<td>" . $row['CVPDSAID'] . "</td>";
          echo "<td>" . $row['CVPDSAName'] . "</td>";
          echo "<td>" . $row['CVPGrade'] . "</td>";
          echo "<td>" . $row['CVPPositionDateStart'] . "</td>";
          echo "<td>" . $row['CVPEndOfContract'] . "</td>";
          echo "<td>" . $row['DateTimeInserted'] . "</td>";
         echo "</tr>";
          }
        echo "</table>";
    }
    else if (isset($_POST['job_match']))
    {
    //echo"button 2";
      $query = "SELECT c.`CDD_id`, 
      CAST(AES_DECRYPT(c.`CDD_forename`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) AS forename, 
      CAST(AES_DECRYPT(c.`CDD_surname`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) AS surname, 
      n.`JOB_name` AS jobName,
      n.`JOB_position_no` AS jobPositionNo,
      l.`MCH_date_matched` AS dateMatched,
      l.`MCH_HBL_value_contacted` AS HBLValueContacted,
      l.`MCH_dateContacted` AS dateContacted,
      l.`MCH_HBL_value_interest_shown` AS HBLValueInterestShown,
      l.`MCH_HBL_value_interviewed` AS HBLValueInterviewed,
      l.`MCH_HBL_value_successful` AS HBLValueSuccessful,
      p.`FBK_date_interview` AS DateInterview,
      p.`FBK_manager_name` AS ManagerName,
      p.`FBK_candidate_feedback` AS CandidateFeedback,
      p.`FBK_strengths_feedback` AS StrengthsFeedback,
      p.`FBK_weaknesses_feedback` AS WeaknessesFeedback,
      p.`FBK_areas_for_development_feedback` AS AreasForDev
      FROM candidate c
      LEFT OUTER JOIN cdd_job_match l on `CDD_id` = `MCH_CDD_id`
      LEFT OUTER JOIN job n on `JOB_id` = `MCH_JOB_id`
      LEFT OUTER JOIN feedback p on `FBK_JOB_id` = `JOB_id`
      WHERE c.`CDD_id` = '$cdd_id' 
      ORDER BY surname,dateMatched ASC;";

        $result = mysqli_query($dbc,$query) or die('Error querying the database');

        echo "Here are your results for".": "."$first_name" ." ". "$last_name" . '<br/>';
        //echo $result;
        echo "<table>
        <tr>
        <th>Job Name</th>
        <th>Job Position No</th>
        <th>Date Matched</th>
        <th>HBL Value Contacted</th>
        <th>Date Contacted</th>
        <th>HBL Value Interest Shown</th>
        <th>HBL Value Interviewed</th>                
        <th>HBL Value Successful</th>
        <th>Date Interview</th>
        <th>Manager Name</th>
        <th>Candidate Feedback</th>
        <th>Strengths Feedback</th>
        <th>Weaknesses Feedback</th>
        <th>Areas for development</th>
        </tr>";
        while ($row = mysqli_fetch_array($result))
          {
          echo "<tr>";
          echo "<td>" . $row['jobName'] . "</td>";
          echo "<td>" . $row['jobPositionNo'] . "</td>";
          echo "<td>" . $row['dateMatched'] . "</td>";
          echo "<td>" . $row['HBLValueContacted'] . "</td>";
          echo "<td>" . $row['dateContacted'] . "</td>";
          echo "<td>" . $row['HBLValueInterestShown'] . "</td>";
          echo "<td>" . $row['HBLValueInterviewed'] . "</td>";
          echo "<td>" . $row['HBLValueSuccessful'] . "</td>";
          echo "<td>" . $row['DateInterview'] . "</td>";
          echo "<td>" . $row['ManagerName'] . "</td>";
          echo "<td>" . $row['CandidateFeedback'] . "</td>";
          echo "<td>" . $row['StrengthsFeedback'] . "</td>";
          echo "<td>" . $row['WeaknessesFeedback'] . "</td>";
          echo "<td>" . $row['AreasForDev'] . "</td>";
         echo "</tr>";
          }
        echo "</table>";
    }
    else if (isset($_POST['employment']))
    {
    //echo"button 3";
      $query = "SELECT c.`CDD_id`, 
      CAST(AES_DECRYPT(c.`CDD_forename`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) AS forename, 
      CAST(AES_DECRYPT(c.`CDD_surname`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) AS surname, 
      m.`CEMP_postName` AS postName,
      m.`CEMP_directorate` AS directorate,
      m.`CEMP_organisation` AS organisation,
      m.`CEMP_dateStart` AS dateStart,
      m.`CEMP_dateEnd` AS dateEnd,
      m.`CEMP_grade` AS grade,
      m.`CEMP_finalSalary` AS finalSalary,
      m.`CEMP_specialist` AS specialist,
      m.`CEMP_HQJC_id` AS HQJCID,
      m.`CEMP_HQEL_id` AS HQELID,
      m.`CEMP_duties` AS duties,
      m.`CEMP_reasonForLeaving` AS reasonForLeaving
      FROM candidate c
      LEFT OUTER JOIN cdd_employment m on `CDD_id` = `CEMP_CDD_id`
      WHERE c.`CDD_id` = '$cdd_id' 
      ORDER BY surname ASC;";
    
        $result = mysqli_query($dbc,$query) or die('Error querying the database');

        echo "Here are your results for".": "."$first_name" ." ". "$last_name" . '<br/>';
        //echo $result;
        echo "<table>
        <tr>
        <th>Post Name</th>
        <th>Directorate</th>
        <th>Organisation</th>
        <th>Date Start</th>
        <th>Date End</th>
        <th>Grade</th>
        <th>Final Salary</th>                
        <th>Specialist</th>
        <th>HQJC id</th>
        <th>HQEL id</th>
        <th>Duties</th>
        <th>Reason for leaving</th>
        </tr>";
        while ($row = mysqli_fetch_array($result))
          {
          echo "<tr>";
          echo "<td>" . $row['postName'] . "</td>";
          echo "<td>" . $row['directorate'] . "</td>";
          echo "<td>" . $row['organisation'] . "</td>";
          echo "<td>" . $row['dateStart'] . "</td>";
          echo "<td>" . $row['dateEnd'] . "</td>";
          echo "<td>" . $row['grade'] . "</td>";
          echo "<td>" . $row['finalSalary'] . "</td>";
          echo "<td>" . $row['specialist'] . "</td>";
          echo "<td>" . $row['HQJCID'] . "</td>";
          echo "<td>" . $row['HQELID'] . "</td>";
          echo "<td>" . $row['duties'] . "</td>";
          echo "<td>" . $row['reasonForLeaving'] . "</td>";
         echo "</tr>";
          }
        echo "</table>";     
      }
    else if (isset($_POST['training']))
    {
    //echo"button 3";
      $query = "SELECT c.`CDD_id`, 
        CAST(AES_DECRYPT(c.`CDD_forename`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) AS forename, 
        CAST(AES_DECRYPT(c.`CDD_surname`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) AS surname, 
        q.`CTRN_qualification` AS qualification,
        q.`CTRN_provider` AS provider,
        q.`CTRN_grade` AS grade,
        q.`CTRN_dateAchieved` AS dateAchieved

        FROM candidate c
        LEFT OUTER JOIN cdd_training_record q on `CDD_id` = `CTRN_CDD_id`
        WHERE c.`CDD_id` = '$cdd_id' 
        ORDER BY surname ASC;";
    
        $result = mysqli_query($dbc,$query) or die('Error querying the database');

        echo "Here are your results for".": "."$first_name" ." ". "$last_name" . '<br/>';
        //echo $result;
        echo "<table>
        <tr>
        <th>Qualification</th>
        <th>Provider</th>
        <th>Grade</th>
        <th>Date Achieved</th>
        </tr>";
        while ($row = mysqli_fetch_array($result))
          {
          echo "<tr>";
          echo "<td>" . $row['qualification'] . "</td>";
          echo "<td>" . $row['provider'] . "</td>";
          echo "<td>" . $row['grade'] . "</td>";
          echo "<td>" . $row['dateAchieved'] . "</td>";
          echo "</tr>";
          }
        echo "</table>";     
      }
    else if (isset($_POST['ipt_match']))
    {
    //echo"button 3";
      $query = "SELECT c.`CDD_id`, 
      CAST(AES_DECRYPT(c.`CDD_forename`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) AS forename, 
      CAST(AES_DECRYPT(c.`CDD_surname`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) AS surname, 
      i.`PMCH_date_matched` AS matched, 
      i.`PMCH_dateContacted` AS contacted,
      i.`PMCH_ranking` AS ranking,
      i.`PMCH_exact_match` AS exactMatch,
      i.`PMCH_max_exact_match` AS maxExactMatch,
      i.`PMCH_score` AS score,
      i.`PMCH_max_score` AS maxscore,
      i.`PMCH_score_percent` AS scorePercent,
      i.`PMCH_IPT_PRL_id` AS iptPRLid,
      i.`PMCH_CDD_PRS_id` AS cddPRSid,
      i.`PMCH_CDD_grade` AS CDDGrade,
      i.`PMCH_CDD_contractHour` AS cddContractHour,
      i.`PMCH_CDD_IPT_dateEndAnticipated` AS cddIPTdateEndAnticipated,
      j.`PASM_PMCH_date_matched` as dateMatched,
      j.`PASM_dateAssigned` AS dateAssigned,
      j.`PASM_name_PMlead` AS namePMLead,
      j.`PASM_email_Pmlead` AS emailPMLead,
      j.`PASM_dateAssignmentStarted` AS dateAssignStart,
      j.`PASM_dateAssignmentEnd` AS dateAssignEnd,
      j.`PASM_dueDateCheck_1stWeek` AS dueDateCheck1stWeek,
      j.`PASM_checkDone_1stWeek` AS CheckDone1stWeek,
      j.`PASM_dueDateCheck_1stMonth` AS dueDateCheck1stMonth,
      j.`PASM_checkDone_1stMonth` AS Check1stMonth,
      j.`PASM_dueDateCheck_final` AS dueDateCheckFinal,
      j.`PASM_checkDone_final` AS CheckDoneFinal,
      j.`PASM_dueDateCheck_followUp` AS dueDateCheckFollowUp,
      j.`PASM_checkDone_followUp` AS CheckDoneFollowUp,
      j.`PASM_extensionDetails` AS extensionDetails,
      j.`PASM_comments` AS comments
      FROM candidate c
      LEFT OUTER JOIN cdd_ipt_match i on `CDD_id` = `PMCH_CDD_id`
      LEFT OUTER JOIN assignment_management j on `PMCH_CDD_id` = `PASM_PMCH_CDD_id`
      WHERE c.`CDD_id` = '$cdd_id' 
      ORDER BY surname, matched ASC;";
    
        $result = mysqli_query($dbc,$query) or die('Error querying the database');

        echo "Here are your results for".": "."$first_name" ." ". "$last_name" . '<br/>';
        //echo $result;
        echo "<table>
        <tr>
        <th>Date Matched</th>
        <th>Date Contacted</th>
        <th>Ranking</th>
        <th>Exact Match</th>
        <th>Max Exact Match</th>
        <th>Score</th>
        <th>Max Score</th>                
        <th>Score Percent</th>
        <th>IPT PRL id</th>
        <th>CDD PRS id</th>
        <th>CDD grade</th>
        <th>CDD contract Hour</th>
        <th>CDD IPT Date End Anticipated</th>
        <th>Date Matched</th>
        <th>Date Assigned</th>
        <th>Name PM Lead</th>
        <th>Email PM Lead</th>
        <th>Date Assignment Started</th>        
        <th>Date Assignment End</th>
        <th>Due Date Check 1st Wk</th>
        <th>Check Done 1st Wk</th>
        <th>Due Date Check 1st Mth</th>
        <th>Check Done 1st Mth</th>
        <th>Due Date Check Final</th>
        <th>Check Done Final</th>
        <th>Due Date Check Followup</th>
        <th>Check Done Followup</th>
        <th>Extension Details</th>        
        <th>Comments</th>        
        </tr>";
        while ($row = mysqli_fetch_array($result))
          {
          echo "<tr>";
          echo "<td>" . $row['matched'] . "</td>";
          echo "<td>" . $row['contacted'] . "</td>";
          echo "<td>" . $row['ranking'] . "</td>";
          echo "<td>" . $row['exactMatch'] . "</td>";
          echo "<td>" . $row['maxExactMatch'] . "</td>";
          echo "<td>" . $row['score'] . "</td>";
          echo "<td>" . $row['maxscore'] . "</td>";
          echo "<td>" . $row['scorePercent'] . "</td>";
          echo "<td>" . $row['iptPRLid'] . "</td>";
          echo "<td>" . $row['cddPRSid'] . "</td>";
          echo "<td>" . $row['CDDGrade'] . "</td>";
          echo "<td>" . $row['cddContractHour'] . "</td>";
          echo "<td>" . $row['cddIPTdateEndAnticipated'] . "</td>";
          echo "<td>" . $row['dateMatched'] . "</td>";
          echo "<td>" . $row['dateAssigned'] . "</td>";
          echo "<td>" . $row['namePMLead'] . "</td>";
          echo "<td>" . $row['emailPMLead'] . "</td>";
          echo "<td>" . $row['dateAssignStart'] . "</td>";
          echo "<td>" . $row['dateAssignEnd'] . "</td>";
          echo "<td>" . $row['dueDateCheck1stWeek'] . "</td>";
          echo "<td>" . $row['CheckDone1stWeek'] . "</td>";
          echo "<td>" . $row['dueDateCheck1stMonth'] . "</td>";
          echo "<td>" . $row['Check1stMonth'] . "</td>";
          echo "<td>" . $row['dueDateCheckFinal'] . "</td>";
          echo "<td>" . $row['CheckDoneFinal'] . "</td>";
          echo "<td>" . $row['dueDateCheckFollowUp'] . "</td>";
          echo "<td>" . $row['CheckDoneFollowUp'] . "</td>";
          echo "<td>" . $row['extensionDetails'] . "</td>";
          echo "<td>" . $row['comments'] . "</td>";

         echo "</tr>";
          }
        echo "</table>";     
      }
?>


</body>
</html>
