$(function() {
    setEvents()
})

function setEvents() {
    $(".showAnswer").off().on("click", function() {
        $(this).parent().find(".answer").css("display", "")
        $(this).removeClass("showAnswer")
        $(this).addClass("hideAnswer")
        $(this).html('<i class="fa-solid fa-eye-slash"></i>')
        setEvents();
    })
    $(".hideAnswer").off().on("click", function() {
        $(this).parent().find(".answer").css("display", "none")
        $(this).removeClass("hideAnswer")
        $(this).addClass("showAnswer")
        $(this).html('<i class="fa-solid fa-eye"></i>')
        setEvents()
    })
}