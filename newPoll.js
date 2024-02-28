$(function() {
    showStep();
})

function addAnswer() {
    let answersAmount = $("#answerContainer > div").length
    $("#answerContainer").append(`
        <div>
            <input type="text" class='answerInput' placeholder="Respuesta ${answersAmount+1}" name="answers[]">
            <div id="answer${answersAmount+1}ImageButton"><i class="fa-regular fa-image" style="color: #ffffff;"></i></div>
            <input type="file" id="answer${answersAmount+1}Image" name="answerImage${answersAmount+1}" accept="image/png, image/gif, image/jpeg" >
        </div>
    `)
    $(`#answer${answersAmount+1}ImageButton`).on("click", function() {
        $(`#answer${answersAmount+1}Image`).trigger("click")
    })
    $(".answerInput").on('input', function() {
        $(`form > *:gt(2)`).remove();
        $(window).off("keydown.custom").on("keydown.custom", function(event){
            if(event.keyCode == 13 || event.keyCode == 9) {
                event.preventDefault();
                let isCorrect = true;
                $(".answerInput").each(function(){
                    let question = $(this).val()
                    if (question.length == "") {
                        showNotification("error", "Complete todos los campos de respuesta")
                        isCorrect = false;
                    } else if (question.includes(";") || question.includes("--") || question.includes("/*") || question.includes("*/")) {
                        showNotification("error", "La respuesta contiene carácteres no permitidos")
                        isCorrect = false;
                    }
                });
                if (isCorrect) {
                    showStep(2);
                }
            }
        });
    });
    $("#removeAnswer").prop("disabled", false)
    if ($("#answerContainer > div").length >= 100) {
        $("#addAnswer").prop("disabled", true)
    }
}

function removeAnswer() {
    $("#answerContainer > div:last-child").remove()
    $("#addAnswer").prop("disabled", false)
    if ($("#answerContainer > div").length <= 2) {
        $("#removeAnswer").prop("disabled", true)
    }
}

function showStep(step = 0) {
    switch (step) {
        case 0:
            $("form").append(`
            <div class="nameQuestionh1">
                <input type="text" id="question" name="question" placeholder="Pregunta">
                <div id="questionImageButton"><i class="fa-regular fa-image" style="color: #ffffff;"></i></div>
                <input type="file" id="questionImage" name="questionImage" accept="image/png, image/gif, image/jpeg, image/webp" >
            </div>
            `)
            $("#question").on('input', function() {
                $(`form > *:gt(2)`).remove();
                $(window).off("keydown.custom").on("keydown.custom", function(event){
                    if(event.keyCode == 13 || event.keyCode == 9) {
                        event.preventDefault();
                        let question = $("#question").val()
                        if (question.length == "") {
                            showNotification("error", "Inserte una pregunta")
                        } else if (question.includes(";") || question.includes("--") || question.includes("/*") || question.includes("*/")) {
                            showNotification("error", "La pregunta contiene carácteres no permitidos")
                        } else {
                            showStep(step+1)
                        }
                        return false;
                    }
                });
            }).focus()
            $("#questionImageButton").on("click", function() {
                $("#questionImage").trigger("click")
            })
            break;
        case 1:
            $("form").append(`
            <div id="answerContainer">
                <div>
                    <input type="text" class='answerInput' placeholder="Respuesta 1" name="answers[]">
                    <div id="answer1ImageButton"><i class="fa-regular fa-image" style="color: #ffffff;"></i></div>
                    <input type="file" id="answer1Image" name="answerImage1" accept="image/png, image/gif, image/jpeg, image/webp" >
                </div>
                <div>
                    <input type="text" class='answerInput' placeholder="Respuesta 2" name="answers[]">
                    <div id="answer2ImageButton"><i class="fa-regular fa-image" style="color: #ffffff;"></i></div>
                    <input type="file" id="answer2Image" name="answerImage2" accept="image/png, image/gif, image/jpeg, image/webp" >
                </div>
            </div>
            <div class="buttonsForm">
                <button type="button" id="removeAnswer" disabled><i class="fa-solid fa-minus"></i></button>
                <button type="button" id="addAnswer"><i class="fa-solid fa-plus"></i></button>
            </div>
            `)
            $(".answerInput").on('input', function() {
                $(`form > *:gt(${step+1})`).remove();
                $(window).off("keydown.custom").on("keydown.custom", function(event){
                    if(event.keyCode == 13 || event.keyCode == 9) {
                        event.preventDefault();
                        let isCorrect = true;
                        $(".answerInput").each(function(){
                            let question = $(this).val()
                            if (question.length == "") {
                                showNotification("error", "Complete todos los campos de respuesta")
                                isCorrect = false;
                            } else if (question.includes(";") || question.includes("--") || question.includes("/*") || question.includes("*/")) {
                                showNotification("error", "La respuesta contiene carácteres no permitidos")
                                isCorrect = false;
                            }
                        });
                        if (isCorrect) {
                            showStep(step + 1);
                        }
                    }
                });
            });
            
            $("#answer1ImageButton").on("click", function() {
                $("#answer1Image").trigger("click")
            })
            $("#answer2ImageButton").on("click", function() {
                $("#answer2Image").trigger("click")
            })
            $("#addAnswer").click(function() {
                $(`form > *:gt(${step+1})`).remove();
                addAnswer();
            })
            $("#removeAnswer").click(removeAnswer)
            break;
        case 2:
            $("form").append(`
                <label for="dateStart">Inicio Encuesta:</label>
                <input type="datetime-local" id="dateStart" name="dateStart">
                <label for="dateFinish">Final Encuesta:</label>
                <input type="datetime-local" id="dateFinish" name="dateFinish">
            `)
            $("input[type='datetime-local']").on('input', function() {
                $(`form > *:gt(${step+4})`).remove();
                $(window).off("keydown.custom").on("keydown.custom", function(event){
                    if(event.keyCode == 13 || event.keyCode == 9) {
                        event.preventDefault();
                        let dateStartString = $("#dateStart").val()
                        let dateFinishString = $("#dateFinish").val()
                        if (!Date.parse(dateStartString)) {
                            showNotification('error', 'La fecha de inicio no es válida')
                        } else if (!Date.parse(dateFinishString)) {
                            showNotification('error', 'La fecha de fin no es válida')
                        } else if (Date.parse(dateStartString) > Date.parse(dateFinishString)){
                            showNotification('error', 'La fecha de inicio no debe ser mayor que la de fin')
                        } else {
                            showStep(step+1)
                        }
                    }
                });
            });
            break;
        case 3:
            $("form").append(`
                <input type="submit" value="Validar encuesta">
            `)
            break;
    }
    $(window).off("keydown.custom").on("keydown.custom", function(event) {
        if(event.keyCode == 13 || event.keyCode == 9) {
            event.preventDefault();
            return false;
        }
    })
}