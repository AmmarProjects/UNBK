(function () {
  var allQuestions = [{
    question: "The tree sends downroots from its branches to the soil is know as:",
    options: ["Oak", "Pine", "Banyan", "Palm", "Ammar"]
  }, {
    question: "Electric bulb filament is made of",
    options: ["Copper", "Aluminum", "lead", "Tungsten"]
  }, {
    question: "Non Metal that remains liquid at room temprature is",
    options: ["Phophorous", "Bromine", "Clorine", "Helium"]
  }, {
    question: "Which of the following is used in Pencils ?",
    options: ["Graphite", "Silicon", "Charcoal", "Phosphorous"]
  }, {
    question: "Chemical formula of water ?",
    options: ["NaA1O2", "H2O", "Al2O3", "CaSiO3"]
  }, {
    question: "The gas filled in electric bulb is ?",
    options: ["Nitrogen", "Hydrogen", "Carbon Dioxide", "Oxygen"]
  }, {
    question: "Whashing soda is the comman name for",
    options: ["Sodium Carbonate", "Calcium Bicarbonate", "Sodium Bicarbonate", "Calcium Carbonate"]
  }, {
    question: "Which gas is not known as green house gas ?",
    options: ["Methane", "Nitrous oxide", "Carbon Dioxide", "Hydrogen"]
  }, {
    question: "The hardest substance availabe on earth is",
    options: ["Gold", "Iron", "Diamond", "Platinum"]
  }, {
    question: "Used as a lubricant",
    options: ["Graphite", "Silica", "Iron Oxide", "Diamond"]
  }];

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
    var element = $('<div>', {
      id: 'question'
    });
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

  function simpanKategori(){
    var konfirmasi=confirm("Apakah Anda ingin menambah kategori tersebut?");
    if(konfirmasi==true){
      var nama = $("#namakategori").val();
      var keterangan = $("#keterangankategori").val();
      $.ajax({
        type:"POST",
        data:"namakat="+nama+"&keterangankat="+keterangan,
        url:"PHP/insertkategori.php",
        success:function(response){
          $("#tabelkategori").html("");
          $("#namakategori").val("");
          $("#keterangankategori").val("");
          $("#formtambahkategori").css("display","none");
          tampilKategori();
          alert(response);
        }
      })
    }
  }
  
})();