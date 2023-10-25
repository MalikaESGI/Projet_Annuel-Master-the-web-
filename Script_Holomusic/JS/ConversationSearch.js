let sessionId;
let tableBodyMessage = document.querySelector('#searchResultsMessage');
let tableHead = document.querySelector('#searchResultsConversationHead');
let newConvButton = document.getElementById('addConv');
let closeFloatWindow = document.querySelector('.close');
let floatWindow = document.getElementById('newConv');
let subNewConv = document.getElementById('subNewConvForm');
let textArea = document.getElementById('messageInput');

fetch('get_session_data').then((response) => {
    return response.json();
}).then((data) => {
    sessionId = data;
    return fetch('messagerie_back');
}).then((response) => {
    return response.json();
}).then((data) => {
    displayConversation(data, sessionId);
}).catch((error) => {
    console.log('Une erreur s\'est produite :', error);
});


subNewConv.addEventListener('submit',(event)=>{
    event.preventDefault();
    let usernameInput = document.getElementById('usernameInput').value;
    let newMessageTextInput = document.getElementById('NewmessageInput').value;

    console.log(usernameInput, newMessageTextInput, sessionId);
    
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/createNewConversation', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (xhr.status === 200) {
            alert('Message envoyé avec succès');
        } else {
            alert('Une erreur est survenue lors de l\'envoi du message');
        }
    };
    xhr.send(`text=${newMessageTextInput}&Sender=${sessionId}&Reciever=${usernameInput}`);
    floatWindow.style.display='none';
    newMessageTextInput= '';
})


closeFloatWindow.addEventListener('click',(event)=>{
    event.preventDefault();
    floatWindow.style.display='none';
})
newConvButton.addEventListener('click',(event)=> {
    event.preventDefault();
    floatWindow.style.display='block';

})


function displayConversation(users, sessionId) {
    let tableBody = document.querySelector('#searchResultsConversation');
    tableBody.innerHTML = '';
    localStorage.setItem('idConversationActive', '');
    for (let i = 0; i < users.length; i++) {
        let user = users[i];
        let row = document.createElement('tr');
        let divisions = Object.values(user);
        let cell = document.createElement('td');
        let link = document.createElement('input');
        let idConversation = encodeURIComponent(divisions[0]);
        link.type = "button";
        link.id = idConversation;
        link.className = "convButton btn btn-secondary col-12";
        if (divisions[1] === sessionId) {
            link.value = divisions[4];
            cell.appendChild(link);
            row.appendChild(cell);
        }
        if (divisions[3] === sessionId) {
            link.value = divisions[2];
            cell.appendChild(link);
            row.appendChild(cell);
        }
        tableBody.appendChild(row);
    }
    addButtons();
}

function addButtons() {
    let convButtons = document.querySelectorAll('.convButton');

    if (convButtons.length > 0) {
        convButtons.forEach((element) => {
            element.addEventListener('click', (event) => {
                fetch('messageFromConversation_back?idConversation=' + element.id)
                    .then((response) => {
                        return response.json();
                    })
                    .then((data) => {
                        displayMessage(data, sessionId, element);
                    })
                    .catch((error) => {
                        console.log('Une erreur s\'est produite :', error);
                    });
                localStorage.setItem('idConversationActive', element.id);
                localStorage.setItem('nameConversationActive', element.value);
            });
        });
    }
}

setInterval(fetchNewMessages, 5000);
function displayMessage(messages, sessionId) {
    let elementValue = localStorage.getItem('nameConversationActive');
    tableHead.innerHTML = elementValue;
    tableBodyMessage.innerHTML = '';
    tableBodyMessage.style.height = '355px';
    tableBodyMessage.style.overflowY = 'scroll';
    tableBodyMessage.style.display = 'block';
    tableBodyMessage.className='text-center';
    for (let i = 0; i < messages.length; i++) {
        let message = messages[i];
        let row = document.createElement('tr');
        let divisions = Object.values(message);
        let cell = document.createElement('td');
        cell.style.width = '100%';
        if (divisions[2] === sessionId) {
            cell.innerHTML = divisions[1];
            cell.className = 'btn btn-primary text-end';
            row.appendChild(cell);
        }
        if (divisions[3] === sessionId) {
            cell.innerHTML = divisions[1];
            cell.className = 'btn btn-primary text-start';
            row.appendChild(cell);
        }
        tableBodyMessage.appendChild(row);
    }
    tableBodyMessage.scrollTop = tableBodyMessage.scrollHeight;

}


document.getElementById('myForm').addEventListener('submit', function (e) {
    e.preventDefault();
    message = textArea.value;
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/sendMessage', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
        xhr.onload = function () {
            if (xhr.status === 200) {
                alert('Message envoyé avec succès');
            } else {
                alert('Une erreur est survenue lors de l\'envoi du message');
            }
        };
        xhr.send(`text=${message}&Sender=${sessionId}&Reciever=${localStorage.getItem('nameConversationActive')}&Conversation=${localStorage.getItem('idConversationActive')}`);
        textArea.value='';
});

function fetchNewMessages() {
    let xhr = new XMLHttpRequest();
    let idConversationActive = localStorage.getItem('idConversationActive');
    xhr.open('POST', '/messageFromConversation_back?idConversation=' + idConversationActive, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            let newMessages = JSON.parse(xhr.responseText);
            displayMessage(newMessages, sessionId);
        } else {
            console.error('Une erreur est survenue lors de la récupération des nouveaux messages.');
        }
    };
    xhr.send();
}

