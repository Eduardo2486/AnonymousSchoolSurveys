<?php
require_once 'core/init.php';
include_once("./core/settings.php");

if(!isset($_SESSION['user_id'])){
	header('Location: login.php');
}else{
  $assessments = $getFromTest->getAllSurveys();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results by subject</title>
    <link rel="stylesheet" href="<?php echo PATH_CSS."reset.css"; ?>">
    
    <link rel="stylesheet" href="<?php echo PATH_CSS."app.css"; ?>">
    <style>
      .show-teacher-application-info{
        border: 1px solid #b3b3b3;
        padding: 10px;
        background-color: #e6e6e6;
        cursor: pointer;
        margin-right: 10px;
        margin-bottom: 10px;
      }
      .show-teacher-application-info:hover{
        border-color:#6a6a6a;
        background-color:#c6c6c6;
      }
      .modal-window{
        position: fixed;
        top: 0;
        background-color: rgba(0, 0, 0, 0.55);
        z-index: 10;
        width: 100%;
        height: 100%;
        overflow:auto;
      }
      .modal-window-container{
        background-color: rgb(255, 255, 255);
        width: 80%;
        margin: auto;
        height: auto;
      }
    </style>
</head>
<body>
    <?php require_once './includes/header.php'; ?>
    <div class="modal-window" id="modal-window" style="display:none;">
      <div class="modal-window-container" id="modal-window-container">
        <canvas id="myChart"></canvas>
        <div id="results">
        </div>
        <a id="download"
        download="ChartImage.jpg" 
        href="#"
        title="Download graphic">Download graphic</a>

      </div>
    </div>
    <article class="grid-container">
      <div class="grid-x align-center">
        <div class="cell medium-8">
          <a href="/cuestionario/teacherresults.php">Results by teacher</a>
          <div class="blog-post">
            <table style="margin-top:20px;">
              <thead>
                <tr>
                  <th>Subject</th>
                  <th>Teacher</th>
                  <th>Partial</th>
                  <th>Questionnaires</th>
                  <th>Actions</th>
                </tr>
              <thead>
              <tbody>
                
                <?php 
                  $tests = $assessments[0];
                  $surveys = $assessments[1];
                  $teachers = $assessments[2];
                  $subjects = $assessments[3];
                  $partials = $assessments[4];
                  
                  for($i = 0 ; $i < sizeof($tests) ; $i++){ 
                    echo "<tr>";
                    $jCounter = 0;
                    $teacherName = "";
                    $subjectName = "";
                    $partial = "";
                    for($j = 0 ; $j < sizeof($subjects) ; $j++){ 
                      if($tests[$i]["subject_id"] == $subjects[$j]["id"]){
                        echo "<td data-label='Subject' data-field='' data-id='".$subjects[$j]["id"]."''>".$subjects[$j]["subject"]." - ".$subjects[$j]["career"]. " - ".$subjects[$j]["grade"]."° ".$subjects[$j]["groupp"]. "</td>";
                        $subjectName = $subjects[$j]["subject"]." - ".$subjects[$j]["career"];
                      }
                    }
                    for($j = 0 ; $j < sizeof($teachers) ; $j++){ 
                      if($tests[$i]["teacher_id"] == $teachers[$j]["id"]){
                        echo "<td scope='row' data-label='Teacher' data-field='' data-id='".$teachers[$j]["id"]."'>".$teachers[$j]["name"]." ".$teachers[$j]["fathers_last_name"]." ".$teachers[$j]["mothers_last_name"]." - ".$teachers[$j]["enrollment"]."</td>";
                        $teacherName = $teachers[$j]["name"]." ".$teachers[$j]["fathers_last_name"]." ".$teachers[$j]["mothers_last_name"];
                      }
                    }
                    for($j = 0 ; $j < sizeof($partials) ; $j++){ 
                      if($tests[$i]["partial_id"] == $partials[$j]["id"]){
                        echo "<td data-label='Partial' data-field='' data-id='".$partials[$j]["id"]."'>".$partials[$j]["abbreviation"]." (" .$partials[$j]["date_start"]. "/" . $partials[$j]["date_end"] . ") <i>".  $partials[$j]["comment"]."</i></td>";
                        $partial = $partials[$j]["abbreviation"] . "(" . $partials[$j]["date_start"]. "/" . $partials[$j]["date_end"].")";
                      }
                    }
                    for($j = 0 ; $j < sizeof($surveys) ; $j++){ 
                      if($tests[$i]["survey_id"] == $surveys[$j]["id"]){
                        echo "<td scope='row' data-label='Questionnaires' data-field='' data-id='".$surveys[$j]["id"]."'>".$surveys[$j]["title"]."</td>";
                        $jCounter = $surveys[$j]["id"];
                      }
                    }
                    echo '<td data-surveyid="'.$jCounter.'" data-nameteacher="'.$teacherName.'" data-testid="'.$tests[$i]["id"].'" data-partial="'.$partial.'" data-subject="'.$subjectName.'"><button class="show-teacher-application-info show">Show results</button>
                    <button class="show-teacher-application-info download">Download results</button></td></tr>';
                  }
                ?>
                
              </tbody>
            </table>
            
          </div>
        </div>
      </div>
    </article>
    <script src="<?php echo PATH_JS."chart.min.js" ?>"></script>
    <script src="<?php echo PATH_JS."jquery.js" ?>"></script>
    <script src="<?php echo PATH_JS."xlsx.full.min.js" ?>"></script>
    <script src="<?php echo PATH_JS."FileSaver.min.js" ?>"></script>
    <script src="<?php echo PATH_JS."chartjs-plugin-datalabels.min.js" ?>"></script>
    <script>
      var ctx = document.getElementById('myChart');
      var nameTeacher = "";
      var myChart = new Chart(ctx, {
          type: 'bar',
          responsive: true,
          maintainAspectRatio: false,
          data: {
              labels: ['SIBE', 'EDD'],
              datasets: [{
                  label: 'Graphic of: '+nameTeacher,
                  data: [500, 19],
                  backgroundColor: [
                      'rgba(255, 99, 132, 0.2)',
                      'rgba(54, 162, 235, 0.2)',
                      'rgba(255, 206, 86, 0.2)',
                      'rgba(75, 192, 192, 0.2)',
                      'rgba(153, 102, 255, 0.2)',
                      'rgba(255, 159, 64, 0.2)'
                  ],
                  borderColor: [
                      'rgba(255, 99, 132, 1)',
                      'rgba(54, 162, 235, 1)',
                      'rgba(255, 206, 86, 1)',
                      'rgba(75, 192, 192, 1)',
                      'rgba(153, 102, 255, 1)',
                      'rgba(255, 159, 64, 1)'
                  ],
                  borderWidth: 1
              }]
          },
          options: {
              scales: {
                  yAxes: [{
                      ticks: {
                          beginAtZero: true
                      }
                  }]
              },
              responsive: true,
              legend: {
                  position: 'bottom',
                  display: true,
  
              },
              "hover": {
                "animationDuration": 0
              }
          }
      });
    </script>
    <script>
        
        document.getElementById("download").addEventListener('click', function(){
          var url_base64jp = document.getElementById("myChart").toDataURL("image/jpg");
          var a =  document.getElementById("download");
          a.href = url_base64jp;
        });

        $("#modal-window").click(function(){
          $("#modal-window").css({'display':'none'})
        });
        $("#modal-window-container").click(function(event){
          event.stopPropagation();
        });
        function s2ab(s) {
          var buf = new ArrayBuffer(s.length);
          var view = new Uint8Array(buf);
          for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
          return buf;
        }
        $(".show-teacher-application-info.show").click(function(e){
          let id = $(this).parent().attr("data-testid");
          let idsurvey = $(this).parent().attr("data-surveyid");
          let name = $(this).parent().attr("data-nameteacher")+" "+$(this).parent().attr("data-partial")+" "+ $(this).parent().attr("data-subject")+".xlsx";
          $.ajax({
              method: "POST",
              url: "/cuestionario/core/ajax/getAllAnswersTeacher.php",
              data: { id: id, surveyid:idsurvey }
          })
          .done(function( msg ) {
            msg = JSON.parse(msg);
            let test = msg[0];
            let answers = msg[1];
            let questions = msg[2];
            let data = [];
            data.push([name]);
            let valueAnswer="";
            let totalTest = 0;
            let totalTestValues = 0;
            
            let dataResults=[];
           
              for(let i = 0 ; i < questions.length ; i++){
                for(let j = 0; j < answers.length ; j++){
                 
                  if(questions[i].id == answers[j].question_id){
                    dataResults.push([questions[i].pregunta,valueAnswer]);
                    totalTestValues += parseInt(answers[j].answer);
                  }
                }
              
              totalTest = answers.length / questions.length;
            }
            console.log(totalTest,totalTestValues)
            let totalSIDE = ((totalTestValues/totalTest)*100)/150 ;
            let totalEDD = ((totalTestValues/totalTest)*5)/150 ;
            myChart.data.datasets.forEach((dataset) => {
              dataset.label = name;
              dataset.data=[totalSIDE, totalEDD];
            });
            
            myChart.update();
            $("#modal-window").css({'display':'block'});
            
          });
        });
        $(".show-teacher-application-info.download").click(function(e){
          let id = $(this).parent().attr("data-testid");
          let idsurvey = $(this).parent().attr("data-surveyid");
          let name = $(this).parent().attr("data-nameteacher")+" "+$(this).parent().attr("data-partial")+" "+ $(this).parent().attr("data-subject")+".xlsx";
          $.ajax({
              method: "POST",
              url: "/cuestionario/core/ajax/getAllAnswersTeacher.php",
              data: { id: id, surveyid:idsurvey }
          })
          .done(function( msg ) {
            msg = JSON.parse(msg);
            let test = msg[0];
            let answers = msg[1];
            let questions = msg[2];
            let data = [];
            data.push([name]);
            let valueAnswer="";
            let totalTest = 0;
            let totalTestValues = 0;
            
            let dataResults=[];
            if(answers.length > questions.length){
              for(let i = 0 ; i < questions.length ; i++){
                for(let j = 0; j < answers.length ; j++){
                  if(questions[i].id == answers[j].question_id){
                    dataResults.push([questions[i].pregunta,answers[j].answer]); 
                    totalTestValues += parseInt(answers[j].answer);
                  }
                }
              }
              totalTest = answers.length / questions.length;
            }else if(questions.length > questions.length){
              for(let i = 0 ; i < answers.length ; i++){
                for(let j = 0; j < questions.length ; j++){
                  
                  if(questions[i].id == answers[j].question_id){
                    dataResults.push([question[i].pregunta,answers[j].answer]);
                    totalTestValues += parseInt(answers[j].answer);
                  }
                }
              }
              totalTest = answers.length / questions.length;
            }else{
              for(let i = 0 ; i < questions.length ; i++){
                for(let j = 0; j < answers.length ; j++){
                 
                  if(questions[i].id == answers[j].question_id){
                    dataResults.push([questions[i].pregunta,answers[j].answer]);
                    totalTestValues += parseInt(answers[j].answer);
                  }
                }
              }
              totalTest = answers.length / questions.length;
            }
            
            let totalSIDE = ((totalTestValues/totalTest)*100)/150 ;
            let totalEDD = ((totalTestValues/totalTest)*5)/150 ;
            myChart.data.datasets.forEach((dataset) => {
              dataset.label = name;
              dataset.data=[totalSIDE, totalEDD];
            });
            
            myChart.update();
              var wb = XLSX.utils.book_new();
              wb.Props = {
                      Title: name,
                      Subject: "Results",
                      Author: "Some school",
                      CreatedDate: new Date(Date.now())
              };
              
              wb.SheetNames.push("Results");
              var ws_data = dataResults;
              var ws = XLSX.utils.aoa_to_sheet(ws_data);
              wb.Sheets["Results"] = ws;

              var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});
              
              saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), name);
          });
         
        });

    </script>
</body>
</html>