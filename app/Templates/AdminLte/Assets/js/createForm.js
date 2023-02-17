let qTemplate = document.querySelector('template#question-template').content;
let aTemplate = document.querySelector('template#answer-template').content;
let questionNumber = 0;

function createQuestion(){
    let crt = document.querySelectorAll('.question-row');
    console.log(crt.length);
    let questionsDiv = document.getElementById('questions');
    let newRow = qTemplate.cloneNode(true);
    questionsDiv.appendChild(newRow);
}

// function createQuestion(){
//     let newQuestion = getNewQuestion(questionNumber);
//     let questionsDiv = document.getElementById('questions');
//     questionsDiv.appendChild(newQuestion);
//     questionNumber++;
// }

function createQuestionNew(){
    let questionRow = document.createElement('div');
        questionRow.classList.add('row', 'question-row');
    let questionLabelDiv = document.createElement('div');
        questionLabelDiv.classList.add('col-md-3', 'text-right');
    let questionLabel = document.createElement('label');
        questionLabel.classList.add('control-label');
        questionLabel.setAttribute('for', 'question'+questionNumber);
        questionLabel.innerHTML = 'Question <font color="#CC0000">*</font>';



    let questionInputDiv = document.createElement('div');
        questionInputDiv.classList.add('col-md-6');
    let questionInput = document.createElement('input');
        questionInput.setAttribute('type', 'text');
        questionInput.setAttribute('id', 'question'+questionNumber);
        questionInput.setAttribute('placeholder', 'Question');
        questionInput.setAttribute('name', 'questions[]');
        questionInput.classList.add('form-control');



    let answerTypeRow = document.createElement('div');
        answerTypeRow.classList.add('row', 'answer-type-row');
        // continue creating the structure, then append all of them


    let answersRow = document.createElement('div');
        answersRow.classList.add('row', 'answers');



    let separatorRow = document.createElement('div');
        separatorRow.classList.add('row', 'separator-row');

    questionNumber += 1;
}

function answerType(event){
    console.log(event);
    let selected = event.target.value;
    let answersDiv = event.target.parentNode.parentNode.nextSibling.nextSibling;
    let newAnswer = aTemplate.cloneNode(true);
    answersDiv.appendChild(newAnswer);
    if(selected > 1){
        
    }
}

function addAnswer(event){
    let newAnswer = aTemplate.cloneNode(true);
    let answersDiv = event.target.parentNode.parentNode.parentNode.parentNode;
    answersDiv.appendChild(newAnswer);
}

$('#content').ready(function(){
    createQuestion();

    $('.add-question').on('click', function(event){
        let questionsDiv = document.getElementById('questions');
        let newRow = qTemplate.cloneNode(true);
        questionsDiv.appendChild(newRow);
    });
});

function getNewQuestion(questionNumber){
    $.ajax({
        url : 'admin/forms/createQuestion/' + questionNumber,
        type : 'POST',
        dataType:'json',
        success : function(data) {              
            console.log(data);
        },
        error : function(request,error)
        {
            console.log("Request: "+JSON.stringify(request));
        }
    });
}