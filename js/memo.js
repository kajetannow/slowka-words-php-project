//import handleAlert from './handleAlert';
const start = document.querySelector('#start');
const display = document.querySelector('#display');
const timer = document.querySelector('#timer');
var content, CARDS_NUM;
var score = 0, attempts = 0, seconds = 0;
//const content = ["A", "B", "C", "D", "E", "F", "G", "H"];

var activeCards = [];
console.log(window.location)

async function fetchData(){
    let url = window.location.href.replace('memo', 'api/memo.php')
    fetch(url)
        .then((response) => {
    return response.json();
  })
    .then((data) => {
    content=data;
    console.log(data);
    CARDS_NUM = content.length*2;
    startGame();
  });
}


function finishGame(){
    var cardContainer =  document.querySelector(".memo-container");
    let finish = document.querySelector('#finish');
    clearInterval(startTimer);
    if(score==CARDS_NUM/2){
        handleAlert(`Czas: ${convertTime(seconds)}`)
        setInterval(()=>window.location.reload(true),3000);
    }else{
        handleAlert(`Czas: ${convertTime(seconds)}`, 'reject', "Nie udało się!");
        setInterval(()=>window.location.reload(true),3000);
    }
    finish.remove();
    cardContainer.remove();
}

function formatTime(time){
    if(time<10)
        return `0${time}`;
    return time;
}

function convertTime(seconds){
    return `${formatTime(Math.floor(seconds/3600))}:${formatTime(Math.floor(seconds%3600/60))}:${formatTime(Math.floor(seconds%60))}`;
}

function startTimer(){
    setInterval(()=>{
        seconds++
        timer.innerText = convertTime(seconds);
    }, 1000)
}

function generateCards(n){
    const cardContainer =  document.querySelector(".memo-container");
    for(var i=0; i<n;i++){
        var card = document.createElement("div");
        card.className = "card";
        card.classList.add("inactive");
        card.id = i;
        cardContainer.appendChild(card);
    }
    
    var cards = document.querySelectorAll('.card');
    return [...cards];
}

function refreshDisplay(){
    display.innerText = `Wynik: ${score} Próba: ${attempts}`;
}

function addAttempt(){
    attempts++;
    refreshDisplay();
}

function addScore(){
    score++;
    refreshDisplay();
    if(score>=CARDS_NUM/2)
        finishGame();
}

function randID(arr){
    return Math.floor(Math.random()*arr.length);
}

function shuffle(cards, content){
    var emptyCards = [];
    for(var i=0; i<CARDS_NUM; i++){
        emptyCards.push(i);
    }


    content.map((el)=>{        
        for(var i=0; i<2; i++){
            var randIndex = randID(emptyCards);
            var rand = emptyCards[randIndex];
            var p = document.createElement('p');
            //p.innerText = el;
            p.innerText = el[i];
            cards[rand].appendChild(p);
            cards[rand].setAttribute("type", el);
            emptyCards.splice(randIndex, 1);
        }
    })
    return cards;
}

function checkActive(){
    addAttempt();
    if(activeCards[0].getAttribute("type") === activeCards[1].getAttribute("type")){
        addScore();
        activeCards.forEach((card)=>{
            card.classList.add("correct");
            card.removeEventListener("click", displayCard);
            
        });
    }else{
        activeCards.forEach((card)=>{
            card.classList.add("incorrect");
            setTimeout(()=>{
                card.classList.remove("incorrect");
                card.classList.remove("active");
                card.classList.add("inactive");
            },1600);
           
        });
    }
    activeCards = [];
}

function displayCard(){
    this.classList.toggle("inactive");
    this.classList.toggle("active");
    activeCards.push(this);
    if(activeCards.length==2){
        setTimeout(checkActive,700);
    }
    
}

function startGame(){
    
    startTimer();
    var cards = generateCards(CARDS_NUM);
    
    cards = shuffle(cards, content);
    
    cards.forEach((card)=>{
        card.addEventListener("click", displayCard);
    })
    

    let finish = document.createElement('button');
    finish.innerText="ZAKOŃCZ";
    finish.className= "btn accept";
    finish.id = "finish";
    finish.addEventListener("click", finishGame);
    start.parentElement.appendChild(finish);
    start.remove();
}
/*
start.addEventListener("click", ()=>{
    fetchData();
    //startGame();
});*/

window.addEventListener("load", fetchData);