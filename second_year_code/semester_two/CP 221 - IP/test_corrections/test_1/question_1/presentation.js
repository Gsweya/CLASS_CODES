// changing the status id to show; Slide 1 of 5

var position = 0;
var timer;


function initializePresentation(){
    let slides = document.querySelectorAll(".slide");
    let status = document.getElementById("status");

    let slide_1 = slides[0];
    position = 0;
    
    for (x of slides) {
        x.style = "display:none; ";
    }
    // add images 
    for (let i = 0 ; i < slides.length; i++) {
        slides[i].innerHTML = `<img src="./images/image_${i + 1}.jpg">`;
    }

    slide_1.style = `display:block;`; 
    
    status.innerText = "Slide 1 of 5"; 

}


function changeSlide(a){
    let slides = document.querySelectorAll(".slide");
    let status = document.getElementById("status");

    for (x of slides) {
        x.style = "display:none; ";
    } 
    
    position += a;
    
    if (position >= 0 && position <= slides.length - 1){ 

        slides[position].style = `display:block`;
        status.innerText = `Slide ${position + 1} of 5`;

    } else if (position === -1) {
        position = slides.length - 1;
        slides[position].style = `display:block`;
        status.innerText = `Slide ${position + 1} of 5`;

    } else if (position === slides.length) {
        position = 0;
        slides[position].style = `display:block`;
        status.innerText = `Slide ${position + 1} of 5`;
    }
   

}

function goToSlide(a){

    let slides = document.querySelectorAll(".slide");
    let status = document.getElementById("status");
    
    for (x of slides) {
        x.style = "display:none; ";
    }

    slides[a].style = `display:block`;
    status.innerText = `Slide ${a + 1} of ${slides.length}`;
    
    position = a;

}

function startAutoPlay(){
    let slides = document.querySelectorAll(".slide");
    let status = document.getElementById("status");

    for (x of slides) {
        x.style = "display:none; ";
    }
    

    changeSlide(1);
    timer = setTimeout(startAutoPlay, 5000);
}


function stopAutoPlay(){  
    clearTimeout(timer);

}