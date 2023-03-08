var i = 0;
var txt = "Hey, Ready to manage your finance?";
var speed = 100;

function typeWriter() {
  if (i < txt.length) {
    document.getElementById("typing").innerHTML += txt.charAt(i);
    if(txt.charAt(i) === ','){
        document.getElementById("typing").innerHTML += "<br>"
    }
    i++;
    setTimeout(typeWriter, speed);
  }
}

window.onload = typeWriter;