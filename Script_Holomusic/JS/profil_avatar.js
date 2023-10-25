let buttonChanger = document.getElementById("changeB");
let buttonSave = document.getElementById("saveB");
let sessionId;

fetch('get_session_data').then((response) => {
    return response.json();
}).then((data) => {
    sessionId = data;
    
    let changeMode = false;

    buttonChanger.addEventListener("click", (event) => {
        event.preventDefault();
        let avatarIMG = document.getElementById("userAvatar")
        if(avatarIMG){
            avatarIMG.remove();
        }
        changeMode = true;
        buttonSave.disabled = false;
        let defaultAvatar = document.getElementById('visage1');
        defaultAvatar.style.display = 'block';
        activateDragAndDrop();
    });

    buttonSave.addEventListener("click", (event) => {
        event.preventDefault();
        changeMode = false;
        buttonSave.disabled = true;

        let canvas = document.createElement('canvas');
        canvas.width = 600;
        canvas.height = 560;

        let context = canvas.getContext('2d');
        let images = Array.from(document.querySelectorAll('.visage, .barbe, .cheveux, .oeil')).filter(img => {
            return window.getComputedStyle(img).display === 'block';
        });
        
        images.forEach((img, index) => {
            context.drawImage(img, 0, 0, canvas.width, canvas.height);
        });

        let dataURL = canvas.toDataURL();
        let blob = dataURItoBlob(dataURL); 

        let fileName = 'avatar' + '_' + sessionId + '.png';

        let formData = new FormData();
        formData.append('image', blob, fileName); 
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'save_avatar', true);
        xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log('Image enregistrée avec succès!');
        }
        };

        xhr.send(formData);
    });

    
    initializeAvatar();
});

function dataURItoBlob(dataURI) {
        let byteString = atob(dataURI.split(',')[1]);
        let mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
        let arrayBuffer = new ArrayBuffer(byteString.length);
        let int8Array = new Uint8Array(arrayBuffer);

        for (let i = 0; i < byteString.length; i++) {
            int8Array[i] = byteString.charCodeAt(i);
        }

        return new Blob([int8Array], {type: mimeString});
    }

    function activateDragAndDrop() {
        let draggables = document.querySelectorAll(".draggable");
        let avatar = document.querySelector(".avatar");
        let draggingElement = null;
        
        draggables.forEach(draggable => {
            draggable.addEventListener('dragstart', () => {
                draggable.classList.add('dragging');
                draggingElement = draggable;
            });
            draggable.addEventListener('dragend', (event) => {
                draggable.classList.remove('dragging')
            });
            draggable.addEventListener('drop', (event) => {
            });
        });

        avatar.addEventListener('drop', (event) => {
            event.preventDefault();
            let droppedElementId = event.dataTransfer.getData("text/plain");
            let classDragging = draggingElement.classList[1];
            if (draggingElement) {
                let delimiter = ".";
                str = draggingElement.src.slice(45);
                let index = str.indexOf(delimiter);
                if (index !== -1) {
                    let newStr = str.slice(0, index);
                    let item = newStr.slice(0, -1);
                    getAvatarImage(newStr, item);
                }
            }
        });

        avatar.addEventListener('dragover', (event) => {
            event.preventDefault();
        });

    }
    function getAvatarImage(image, classname) {
        let imageV = document.querySelectorAll('.' + classname);
        imageV.forEach((element, index) => {
            element.style.display = 'none';
        });
        let imageRec = document.getElementById(image);
        imageRec.style.display = 'block';
    }
    
    function initializeAvatar() {
        let avatarDiv = document.querySelector('.avatar');

        let userAvatarFilename = 'avatar_' + sessionId + '.png';

        let avatarImg = new Image();
        avatarImg.onload = function() {
            avatarImg.id = 'userAvatar';
            avatarImg.className = 'visage col-12';
            avatarImg.style = "display: block;";
            avatarDiv.appendChild(avatarImg);
        }
        avatarImg.onerror = function() {
            document.getElementById('visage1').style.display = 'block';
        }
        avatarImg.src = 'https://holomusic.ddns.net/uploads/avatar/' + userAvatarFilename;
    }
