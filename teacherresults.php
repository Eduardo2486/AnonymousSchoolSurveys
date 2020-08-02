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
    <title>Teacher results</title>
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
          <a href="/cuestionario/home.php">Results by subject</a>
          <div class="blog-post">
            <table style="margin-top:20px;">
              <thead>
                <tr>
                  <th>Teacher</th>
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
                  
  
                  
                    for($j = 0 ; $j < sizeof($teachers) ; $j++){ 
                        echo "<td scope='row' data-label='Teacher' data-field='' data-id='".$teachers[$j]["id"]."'>".$teachers[$j]["name"]." ".$teachers[$j]["fathers_last_name"]." ".$teachers[$j]["mothers_last_name"]." - ".$teachers[$j]["enrollment"]."</td>";
                        $teacherName = $teachers[$j]["name"]." ".$teachers[$j]["fathers_last_name"]." ".$teachers[$j]["mothers_last_name"];
                        echo '<td data-teacherid="'.$teachers[$j]["id"].'" data-surveyid="" data-nameteacher="'.$teacherName .'"><button class="show-teacher-application-info show">Show results</button></tr>';
                      
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
                  label: 'Graphic of the teacher: '+nameTeacher,
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
              }
          }
      });
    </script>
    <script>
        document.getElementById("download").addEventListener('click', function(){
          var url_base64jp = document.getElementById("myChart").toDataURL("image/jpg");
          var a =  document.getElementById("download");
          a.href = url_base64jpg;
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
        function getAverangePerSubject(test, answers, questions){
            let idsQuestions = [];
            let valueAnswer="";
            let totalTest = 0;
            let totalTestSet = false;
            let totalTestValues = 0;
            let dataResults =[];
              for(let i = 0 ; i < questions.length ; i++){
                for(let j = 0; j < questions[i].length ; j++){
                  if(!idsQuestions.includes(questions[i][j].id)){
                    idsQuestions.push(questions[i][j].id);
                  }
                  if(!totalTestSet){
                    if(answers[i].question_id === questions[i][j].id){
                      totalTest = questions[i].length;
                      totalTestSet = true;
                    }
                  }
                }
              }
              for(let i = 0 ; i < answers.length ; i++){
                totalTestValues += parseInt(answers[i].answer);
              }
              return (totalTestValues/totalTest);
        }
        $(".show-teacher-application-info.show").click(function(e){
          let id = $(this).parent().attr("data-teacherid");
          let name = $(this).parent().attr("data-nameteacher")+".xlsx";
          $.ajax({
              method: "POST",
              url: "/cuestionario/core/ajax/getTotalOfTestsFilled.php",
              data: { id: id }
          })
          .done(function( msg ) {
            msg = JSON.parse(msg);
            console.log(msg);
            let test = msg[0];
            let questions = msg[1];
            let answers = msg[2];
            let data = [];
            data.push([name]);
            let valueAnswer="";
            let totalTest = 0;
            let totalTestValues = 0;
            
            let dataResults=[];
            let totalMatter = [];
            for(let i = 0 ; i < answers.length ; i++){
                let result;
                result = getAverangePerSubject(test, answers[i], questions);
                totalMatter.push((((result)*100)/150).toFixed(3));
                totalMatter.push((((result)*5)/150).toFixed(3));
            }
            myChart.data.datasets.forEach((dataset) => {
              dataset.label = name;
              dataset.data=totalMatter;
            });
            myChart.data.labels = totalMatter;
            myChart.update();
            $("#modal-window").css({'display':'block'});
            
          });
        });
        

    </script>
</body>
</html>