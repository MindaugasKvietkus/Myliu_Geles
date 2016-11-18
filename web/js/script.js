var slider = document.getElementById("slider");
var sliderControl = document.getElementById("sliderControl");
var lineTop = document.getElementById("line-top");
var lineMiddle = document.getElementById("line-middle");
var lineBottom = document.getElementById("line-bottom");

function closeMenu(){
    slider.style.height = "0px";
    sliderControl.className = "menu";
    lineTop.style.background = "";
    lineMiddle.style.background = "";
    lineBottom.style.background = "";
}

sliderControl.onclick = function(){
    if(slider.style.height == "0px" || !slider.style.height){
        slider.style.height = "100%";
        sliderControl.className += " open";
        lineTop.style.background = "#ffa200";
        lineMiddle.style.background = "#ffa200";
        lineBottom.style.background = "#ffa200";
    }
    else{
        closeMenu();
    }
};

var ul = document.getElementById('ul');

ul.addEventListener('click', function(e) {
    if (e.target.tagName === 'A' || 'LI'){
        closeMenu();
    }
});