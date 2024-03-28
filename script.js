
  var selectedColor = [];
  var clickedDate = [];
  var textValues = {};

  $(document).ready(function() {
    $('.date-cell').on('click', function() {
      clickedDate.push($(this).data('date'));
      $('#colorPopup').show();

      $('.color-button').off('click');

      $('.color-button').on('click', function() {
        selectedColor.push($(this).data('color'));
        $('[data-date="' + clickedDate[clickedDate.length - 1] + '"]').css('background-color', selectedColor[selectedColor.length - 1]);
        $('#colorPopup').hide();
        console.log(clickedDate, selectedColor);
      });
    });
  });
    function salvar() {
    $('.texto-input').each(function() {
        var inputId = $(this).attr('id');
        var inputText = $(this).val();

        console.log('Input ID:', inputId);
        console.log('Input Text:', inputText);

        textValues[inputId] = inputText;
    });

    // Verifica se há algum campo de texto sem uma cor selecionada
    $('.texto-input').each(function() {
        var inputId = $(this).attr('id');
        if (!selectedColor.includes(inputId)) {
        selectedColor.push(inputId);
        }
    });

    var dataToSend = {
        selectedColor: selectedColor,
        clickedDate: clickedDate,
        textValues: textValues
    };

    $.ajax({
        url: 'salvar.php',
        method: 'POST',
        data: dataToSend,
        success: function(response) {
        console.log(response.mensagem);
        console.log('Text Values:', response.textValues);
        alert("Valores salvos com sucesso!");
        },
        error: function(xhr, status, error) {
        console.log(error);
        }
    });
    }