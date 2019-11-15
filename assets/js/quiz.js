(function () {
  var allQuestions = [{
    question: "The tree sends downroots from its branches to the soil is know as:",
    options: ["Oak", "Pine", "Banyan", "Palm", "Ammar"]
  }, {
    question: "Electric bulb filament is made of",
    options: ["Copper", "Aluminum", "lead", "Tungsten"]
  },];

  var quesCounter = 0;
  var selectOptions = [];
  var quizSpace = $('#quiz');

  nextQuestion();

  $('#next').click(function () {
    chooseOption();
    if (isNaN(selectOptions[quesCounter])) {
      alert('Please select an option !');
    } else {
      quesCounter++;
      nextQuestion();
    }
  });

  $('#prev').click(function () {
    chooseOption();
    quesCounter--;
    nextQuestion();
  });

  function createElement(index) {
    var element = $('<div>', {id: 'question'});
    var header = $('<p>Pertanyaan ke-' + (index + 1) + ' :</p>');
    element.append(header);

    var question = $('<h4 mt-1>').append(allQuestions[index].question);
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
      url: "PHP/addAnswer.php",
      success: function (response) {
        alert("Data Anda Telah Diinput");
      }
    });
  }

  function displayResult() {
    var correct = 0;
    for (var i = 0; i < selectOptions.length; i++) {
      // if (selectOptions[i] === allQuestions[i].answer) {
      //   correct++;
      // }
      simpanJawaban(questionArray[i], siswa, sekolah, seletOption[i]);
    }
    var greet = $('<p>',{id: 'hasil'});
    greet.append('Selamat Kamu Telah Selesai dalam Ujian ini');
    return greet;
  }
})();