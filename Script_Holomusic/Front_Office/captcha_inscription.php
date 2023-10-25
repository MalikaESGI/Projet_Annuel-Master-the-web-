<?php
session_start();
if (!isset($_SESSION['registration_data'])) {
  header('Location: /inscription');
  exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Captcha</title>
        <link rel="stylesheet" href="../CSS/Captcha.css">
    </head>
    <body>
        <div id="captcha" class=""></div>
        <div id="success"></div>
        <div id="message"></div>
        <div class="boutton">
        <button id="submit-button" onclick="submitPuzzle()">Submit</button>
      </div>
        <script>
  let imageFileNames = [];
  let successPuzzle = ["1.jpg", "3.jpg", "2.jpg", "4.jpg"];
  let currentPosition = [];
      let successElement = document.getElementById("success");
      let submitButton = document.getElementById("submit-button");
      let basePath = "./asset/captcha/";

function shuffleArray(arr) {
  arr.sort(() => Math.random() - 0.5);
}
function generateCaptcha() {
  if (imageFileNames.length > 0) {
      return;
    }
  const size = 2;  
  const puzzleSize = 360;

  const board = document.getElementById("captcha");
  board.style.width = puzzleSize + "px";
  board.style.height = puzzleSize + "px";

  const imageSize = Math.floor(puzzleSize / size);

  const xhr = new XMLHttpRequest();
  xhr.open("GET", "getRandomFolder");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const responseText = xhr.responseText;
      imageFileNames = JSON.parse(responseText);
      shuffleArray(imageFileNames);

      currentPosition = [...imageFileNames];

      let counter = 0;

      for (let i = 0; i < size; i++) {
        for (let j = 0; j < size; j++) {
          let tile = document.createElement("img");
          tile.id = imageFileNames[counter];
          tile.src = basePath + imageFileNames[counter]+ '?t=' + Date.now();
          tile.style.objectFit = "cover";
          tile.style.objectPosition = "center center";
          tile.style.width = imageSize + "px";
          tile.style.height = imageSize + "px";
          tile.style.position = "absolute";
          tile.style.top = i * imageSize + "px";
          tile.style.left = j * imageSize + "px";
          captcha.appendChild(tile);

          tile.addEventListener("dragstart", dragStart);
          tile.addEventListener("dragover", dragOver);
          tile.addEventListener("dragenter", dragEnter);
          tile.addEventListener("dragleave", dragLeave);
          tile.addEventListener("drop", dragDrop);
          tile.addEventListener("dragend", dragEnd);

          counter++;
        }
      }
    }
  };
  xhr.send();
}

let currentTile;
let otherTile;

function dragStart() {
  currentTile = this;
}

function dragOver(e) {
  e.preventDefault();
}

function dragEnter(e) {
  e.preventDefault();
}

function dragLeave() {}

function dragDrop() {
  otherTile = this;
}

function dragEnd() {
  let currentImgId = currentTile.id;
  let otherImgId = otherTile.id;

  let currentImgSrc = currentTile.src;
  let otherImgSrc = otherTile.src;

  currentTile.src = otherImgSrc;
  otherTile.src = currentImgSrc;

  let idClicked = currentPosition.indexOf(currentImgId);
  let idDropped = currentPosition.indexOf(otherImgId);

 
  [currentPosition[idClicked], currentPosition[idDropped]] = [currentPosition[idDropped], currentPosition[idClicked]];
}
function submitPuzzle() {
  let success = true;
  for (let i = 0; i < successPuzzle.length; i++) {
    let imageName = currentPosition[i].substring(currentPosition[i].lastIndexOf('/') + 1).split("/").pop();
    let successImage = successPuzzle[i];
    if (imageName !== successImage) {
      success = false;
      console.log(imageName);
      console.log(successImage);
      break; 
    }
  }

  if (success) {
    console.log("success");
    alert("You are not a robot, you can access your account.");
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "register_user", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
        window.location.href = "/connexion";
      }
    }
    xhr.send();
  } else {
    console.log("NO.");
    alert("Please try again. The CAPTCHA is not correct.");
  }
}  
 document.addEventListener("DOMContentLoaded", generateCaptcha);
</script>
</body>
</html>
