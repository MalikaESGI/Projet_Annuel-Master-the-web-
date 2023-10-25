const artistes = [
    { song: "Happy Birthday Mr.President", artiste: "Marilyn Monroe" },
    { song: "Bohemian Rhapsody", artiste: "Queen" },
    { song: "Like a Rolling Stone", artiste: "Bob Dylan" },
    { song: "Hey Jude", artiste: "The Beatles" },
    { song: "Thriller", artiste: "Michael Jackson" },
    { song: "La Vie en rose", artiste: "Édith Piaf" },
    { song: "Emmenez-moi", artiste: "Charles Aznavour" },
    { song: "Allumer le feu", artiste: "Johnny Hallyday" },
    { song: "La Valse à mille temps", artiste: "Jacques Brel" },
    { song: "Pour que tu m'aimes encore", artiste: "Céline Dion" },
    { song: "Sous le ciel de Paris", artiste: "Yves Montand" },
    { song: "Les Champs-Élysées", artiste: "Joe Dassin" },
    { song: "Les mots bleus", artiste: "Christophe" },
    { song: "La Bohème", artiste: "Charles Aznavour"  },
    { song: "Je te donne", artiste:  "Jean-Jacques Goldman et Michael Jones" },
    { song: "Je suis malade", artiste: "Serge Lama" },
    { song: "Que je t'aime", artiste: "Johnny Hallyday" },
    { song: "Laissez-moi danser", artiste: "Dalida" },
    { song: "Les mots d'amour", artiste: "Michel Sardou" },
    { song: "Comme d'habitude", artiste: "Claude François" },
    { song: "Évidemment", artiste: "France Gall" },
    { song: "Joe le taxi", artiste: "Vanessa Paradis" },
];

let responseTable = [];
let questionTable = [];
let index = 0;
let attempt = 3;

const submitBtn = document.querySelector("#submitBtn");
const restartBtn = document.querySelector("#restartBtn");
const start = document.querySelector("#start");

var modal = document.getElementById("quizModal");

// Ouvrez le pop-up
window.onload = function() {
    modal.style.display = "block";
}

var span = document.getElementsByClassName("close")[0];
span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function getRandomSong() {
    const random = Math.floor(Math.random() * artistes.length);
    const song = artistes[random].song;
    const artiste = artistes[random].artiste;
    return { song, artiste };
}

function displayQuestion() {
    let newSong = getRandomSong();
    while (questionTable.includes(newSong)) {
        newSong = getRandomSong();
    }
    questionTable.push(newSong);
    document.querySelector("#songName").textContent = questionTable[index].song;
    index++;
}

start.addEventListener("click", (event) => {
    event.preventDefault();
    start.style.display = "none";
    document.querySelector(".div-question").style.display = "block";
    displayQuestion();
});

submitBtn.addEventListener("click", (event) => {
    event.preventDefault();
    const answerInput = document.querySelector("#answerInput").value.trim();

    if (answerInput === "") {
        document.querySelector("#errorMessage").style.display = "block";
        const p = document.createElement("p");
        p.textContent = "Please answer the question.";
        document.querySelector("#errorMessage").textContent = p.textContent;
        return;
    }

    responseTable.push(answerInput);
    document.querySelector("#answerInput").value = "";
    
    if (attempt > 1) {
        displayQuestion();
    } else if (attempt === 1) {
        document.querySelector(".div-question").style.display = "none";
        document.querySelector("#resultDiv").style.display = "block";
        let check = 0;
        for (let i = 0; i < questionTable.length; i++) {
            if (!questionTable[i].artiste.toLowerCase().includes(responseTable[i].toLowerCase())) {
                let html = `
                <li style="color:black" >What is the name of the artist who sang this song? ${questionTable[i].song}</li>
                <p style="color:black">You should have answered this: ${questionTable[i].artiste}</p>
                `;
                document.querySelector("#answersList").innerHTML += html;
                check++;
            }
        }
        if (check === 0 && responseTable.length === questionTable.length) {
            document.querySelector("#resultDiv").style.display = "none";
            document.querySelector("#successMessage").style.display = "block";
            const p = document.createElement("p");
            p.textContent = "Congratulations! You have answered all the questions!";
            document.querySelector("#successMessage").textContent = p.textContent;
        }
    }
    
    attempt--;
});

restartBtn.addEventListener("click", (event) => {
    event.preventDefault();
    document.querySelector("#resultDiv").style.display = "none";
    document.querySelector("#successMessage").style.display = "none";
    document.querySelector("#errorMessage").style.display = "none";
    document.querySelector(".div-question").style.display = "none";
    start.style.display = "block";
    questionTable = [];
    responseTable = [];
    index = 0;
    attempt = 3;
    displayQuestion(); 
});
