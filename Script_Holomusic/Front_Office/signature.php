<div id='page'>

<form style="margin-left:50px; margin-top:50px;">
<p>
<i>Thank you for your inscription<br />
<br />Now you have to add your signature to complete your profile</i>
<br/><br/><br/><br/>
<canvas style="border: 1px solid #999" id="signature" width="600" height="200"></canvas><br/><br/>
<button type="button" onclick="effacer();" id="efface">Delit</button>&nbsp;
<button type="submit" name="submit">Save</button>

</p>

</form>

</div>
<script type="text/javascript">

let zoneSigner = document.getElementById("signature");
zoneSigner.addEventListener('mousedown', sourisBas);
zoneSigner.addEventListener('mousemove', sourisBouge);
zoneSigner.addEventListener('mouseup', sourisHaut);

let trace = zoneSigner.getContext('2d');
let started = false;
function sourisBas(ev)
{
started = true;
trace.beginPath();
trace.moveTo(ev.offsetX, ev.offsetY);
}
function sourisBouge(ev)
{
if (started)
{
trace.lineTo(ev.offsetX, ev.offsetY);
trace.stroke();
}
}
function sourisHaut(ev)
{
started = false;
}
function effacer()
{
trace.clearRect(0, 0, zoneSigner.width, zoneSigner.height);
}

</script>
<?php
if(isset($_POST['submit'])){
    header('location: /profil');
    exit;
}?>