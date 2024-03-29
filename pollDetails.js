let votes = []

let graphType= "bar"
Chart.defaults.color = "#effbff";
Chart.defaults.font.family = "'Raleway', sans-serif;"

$(function() {
    $("#barChartButton").click(function() {
      graphType = "bar";
      $(this).prop("disabled", true)
      $("#pieChartButton").prop("disabled", false)
      Chart.getChart("graph").destroy()
      createGraph();
    })
    $("#pieChartButton").click(function() {
      graphType = "pie";
      $(this).prop("disabled", true)
      $("#barChartButton").prop("disabled", false)
      Chart.getChart("graph").destroy()
      createGraph();
    })
    $("#saveChanges").click(function() {
      let questionVisibility = $("#questionVisibility").find(":selected").val()
      let answerVisibility = $("#answerVisibility").find(":selected").val()

      $("#hiddenForm").html(`
        <input type="hidden" name="QuestionVisibility" value="${questionVisibility}">
        <input type="hidden" name="AnswerVisibility" value="${answerVisibility}"> 
      `).submit()
    })
    $("#questionVisibility").on("change", changeAnswerVisibilityOptions)
})

function getVotes(votesFromPost) {
  votes = votesFromPost
  createGraph()
}

function createGraph() {
    
      new Chart(
        document.getElementById('graph'),
        {
          type: graphType,
          data: {
            labels: votes.map(row => row.answer),
            datasets: [
              {
                label: 'Votos',
                data: votes.map(row => row.count)
              }
            ]
          },
          options: {
            responsive: true,
            mantainAspectRatio: true
          }
        }
      );
}

function changeAnswerVisibilityOptions() {
  let questionVisibility = $("#questionVisibility").find(":selected").val()
  console.log(questionVisibility)
  switch (questionVisibility) {
    case "hidden":
      $("#AnswerVisibilityPrivateOption").prop("selected", false).prop("disabled", true)
      $("#AnswerVisibilityPublicOption").prop("selected", false).prop("disabled", true)
      $("#AnswerVisibilityHiddenOption").prop("selected", true)
      break;
    case "private":
      if ($("#AnswerVisibilityPublicOption").is(":selected")) {
        $("#AnswerVisibilityPrivateOption").prop("selected", true);
      }
      $("#AnswerVisibilityPublicOption").prop("selected", false).prop("disabled", true)
      $("#AnswerVisibilityPrivateOption").prop("disabled", false)
      break;
    case "public":
      $("#AnswerVisibilityPrivateOption").prop("disabled", false)
      $("#AnswerVisibilityPublicOption").prop("disabled", false)
      break;
  }
}