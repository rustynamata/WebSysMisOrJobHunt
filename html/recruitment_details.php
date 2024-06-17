<!DOCTYPE html>
<?php
session_start();
$data = $_SESSION['data'];
function greet($array) {
    if (count($array) > 2) {
        foreach ($array as $key => $value) {
            echo htmlspecialchars($value). "<br>";}
    } else {
        echo htmlspecialchars($array[0]). "<br>";
    }
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/recruitment_details.css">
        <title>Mis-Or_JobHunt</title>
    </head>
    <body>
        <main>
            <div id="Fill_out">
                <div class="maincont">

                    <div class="engrc">
                        <p>Company: <span><?php echo htmlspecialchars($data[0]['CompanyName']);?></span></p>
                        <p>Job Title: <span><?php echo htmlspecialchars($data[0]['Jobtitle']);?></span></p>
                        <p>Job Type: <span><?php echo htmlspecialchars($data[0]['EmploymentType']);?></span></p>
                        <p>Salary: <span><?php echo htmlspecialchars($data[0]['Salary']);?></span></p>
                        <p>Educational Attainment: <span><?php echo htmlspecialchars($data[0]['HighestEducAttainment']);?></span></p>
                        <p>Qualifications:</p>
                        <div class="qualification">
                        <?php greet($_SESSION['Other_Requirements'] );?>
                        </div>
                        <p>Skill Competencies:</p>
                        <div class="competencies">
                            <?php greet($_SESSION['SkillandCompetency'] );?>
                        </div>
                        <p>Working Condition:</p>
                        <div class="workcon">
                        <?php greet($_SESSION['WorkingCondition'] );?>
                        </div>
                        <p>Compensation and Benefits:</p>
                        <div class="compensation">
                        <?php greet($_SESSION['CompensationBenefits'] );?>
                        </div>
                        <p>Steps for Applying</p>
                        <div class="steps">
                        <?php greet($_SESSION['HowToApply'] );?>
                        </div>
                    </div>
                    <div class="details">

                    </div>
                    <div class="aders">
                        
                    </div>
                </div>
                <button id = "Apply" onclick = "onclicked()">Apply</button>
            </div>
        </main>
        <script>
            function onclicked() {
                var userId = <?php echo json_encode($data[0]['user_id']); ?>;
                const jobcode = <?php echo json_encode($data[0]['JobtitleCode']); ?>;
                const jobtt = <?php echo json_encode($data[0]['Jobtitle']); ?>;
                let formData = new FormData;
                formData.append('id', userId);
                formData.append('from', 'applicant');
                formData.append('jobcode', jobcode);
                formData.append('jobtt', jobtt);
                fetch('../php/notify.php', {
                    method: 'POST',
                    body: formData
                    })
                .then(response => response.json())
                .then(data => {
                if (data.success) {}})
                        console.log(userId);
                    }
            </script>
        </body>
</html>