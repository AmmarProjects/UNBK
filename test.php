<?php
    include "getSoal.php";
    include "rsa.php";

    $ID_Siswa = $_GET['id'];
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Computer Based Test - UNBK 2</title>
    <meta name="description" content="Dashboard CBT">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/png" href="images/favicon.png" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/lib/datatable/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    >
</head>

<body>
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <header id="header" class="header">
            <div class="top-left">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./"><img src="images/logo.svg" alt="Logo"></a>
                </div>
            </div>
            <div class="top-right">
                <div class="header-menu">
                    <div class="header-left">
                        <button class="search-trigger"><i class="fa fa-bars"></i></button>
                    </div>
                    <p name="siswa" id="siswa" hidden><?php echo $ID_Siswa?></p>
                    <p class="text-white mt-3" name="sekolah" id="sekolah">MAN 2 Madiun</p>
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="images/user.svg" alt="User Avatar">
                            
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#"><i class="fa fa-power -off"></i>Logout</a>
                        </div>
                    </div>

                </div>
            </div>
        </header>
        <!-- /#header -->
        <!-- Header-->
    </div><!-- /#right-panel -->
    <div class="content">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="quiz"></div>

                            <div class="card-bottom m-4">
                                <a href="#" class="btn btn-secondary" id="prev">Kembali</a>
                                <a href="#" class="btn btn-success" id="next">Lanjut</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div><!-- .animated -->
    </div><!-- .content -->

    <div class="clearfix"></div>

    <!-- Right Panel -->

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>

    <script src="assets/js/main.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- <script src="assets/js/quiz.js"></script> -->
    <script>
        (function () {
            var allQuestions = [
            <?php
                $numItems = count($result);
                $x = 0;
                foreach($result as $data):
                    if (++$x === $numItems) {
                        echo'{
                            id_soal: "'.$data["id_soal"].'",
                            question: "'.decrypt($data["soal"],$private_secret_key).'",
                            options: ["'.decrypt($data["opsi_A"],$private_secret_key).'", "'.decrypt($data["opsi_B"],$private_secret_key).'", "'.decrypt($data["opsi_C"],$private_secret_key).'", "'.decrypt($data["opsi_D"],$private_secret_key).'", "'.decrypt($data["opsi_E"],$private_secret_key).'"]
                        }';
                    }else{
                        echo'{
                            id_soal: "'.$data["id_soal"].'",
                            question: "'.decrypt($data["soal"],$private_secret_key).'",
                            options: ["'.decrypt($data["opsi_A"],$private_secret_key).'", "'.decrypt($data["opsi_B"],$private_secret_key).'", "'.decrypt($data["opsi_C"],$private_secret_key).'", "'.decrypt($data["opsi_D"],$private_secret_key).'", "'.decrypt($data["opsi_E"],$private_secret_key).'"]
                        },';
                    }
                endforeach;
            ?>];

            var quesCounter = 0;
            var selectOptions = [];
            var quizSpace = $('#quiz');

            nextQuestion();

            $('#next').click(function () {
                chooseOption();
                    quesCounter++;
                    nextQuestion();
            });

            $('#prev').click(function () {
                chooseOption();
                quesCounter--;
                nextQuestion();
            });

            function createElement(index) {
                var element = $('<div>', {
                    id: 'question'
                });
                var header = $('<p>Soal ke-' + (index + 1) + ' :</p>');
                element.append(header);

                var question = $('<h4 class="mt-1">').append(allQuestions[index].question);
                element.append(question);

                var radio = radioButtons(index);
                element.append(radio);

                return element;
            }

            function radioButtons(index) {
                var radioItems = $('<ul class="m-1">');
                var item;
                var input = '';
                for (var i = 0; i < allQuestions[index].options.length; i++) {
                    item = $('<li class="mt-1 ml-4" type="A">');
                    input = '<input type="radio" name="answer" value=' + i + ' />';
                    input += allQuestions[index].options[i];
                    item.append(input);
                    radioItems.append(item);
                }
                return radioItems;
            }

            function chooseOption() {
                selectOptions[quesCounter] = +$('input[name="answer"]:checked').val();
            }

            function nextQuestion() {
                quizSpace.fadeOut(function () {
                    $('#question').remove();
                    if (quesCounter < allQuestions.length) {
                        var nextQuestion = createElement(quesCounter);
                        quizSpace.append(nextQuestion).fadeIn();
                        if (!(isNaN(selectOptions[quesCounter]))) {
                            $('input[value=' + selectOptions[quesCounter] + ']').prop('checked', true);
                        }
                        if (quesCounter === 1) {
                            $('#prev').show();
                        } else if (quesCounter === 0) {
                            $('#prev').hide();
                            $('#next').show();
                        }
                    } else {
                        var scoreRslt = displayResult();
                        quizSpace.append(scoreRslt).fadeIn();
                        $('#next').hide();
                        $('#prev').hide();
                    }
                });                
            }

            function simpanJawaban(soal, siswa, sekolah, jawaban) {
                $.ajax({
                type: "POST",
                data: "soal=" + soal + "&siswa=" + siswa + "&sekolah=" + sekolah + "&jawaban=" + jawaban,
                url: "../UNBK/addAnswer.php",
                    success: function (response) {
                        // alert("Data Anda Telah Diinput");
                    }
                })
            }


            function displayResult() {
                var siswa = $("#siswa").text();
                var sekolah = $("#sekolah").text();
                var answ = "";
                for (var i = 0; i < selectOptions.length; i++) {
                if (selectOptions[i] === 0) {
                  answ = "A";
                }else if(selectOptions[i] === 1){
                    answ = "B";
                }else if(selectOptions[i] === 2){
                    answ = "C";
                }else if(selectOptions[i] === 3){
                    answ = "D";
                }else if(selectOptions[i] === 4){
                    answ = "E";
                }else{
                    answ = "ERROR";
                }
                simpanJawaban(allQuestions[i].id_soal, siswa, sekolah, answ);
                }
            }



        })();
    </script>

    <script src="assets/js/lib/data-table/datatables.min.js"></script>
    <script src="assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
    <script src="assets/js/lib/data-table/dataTables.buttons.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
    <script src="assets/js/lib/data-table/jszip.min.js"></script>
    <script src="assets/js/lib/data-table/vfs_fonts.js"></script>
    <script src="assets/js/lib/data-table/buttons.html5.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.print.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.colVis.min.js"></script>
    <script src="assets/js/init/datatables-init.js"></script>

</body>

</html>