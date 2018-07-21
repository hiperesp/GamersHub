function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function eraseCookie(name) {   
    document.cookie = name+'=; Max-Age=-99999999;';  
}

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

if(document.querySelectorAll(".background").length>0){
    var randomBg = getRandomInt(1, 14);
    for(i in document.querySelectorAll(".background")) {
        if(typeof document.querySelectorAll(".background")[i]==="object"){
           document.querySelectorAll(".background")[i].style.backgroundImage = "linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),url('/assets/images/background/"+favoriteMap+"/"+randomBg+".jpg')";
        }
    }
}

if(document.querySelectorAll("#hamburgerButton").length>0){
    document.querySelector("#hamburgerButton").onclick = function(){
    	if(document.querySelector("#hamburgerMenu").style.display=="inline"){
    		document.querySelector("#hamburgerMenu").style.display = "none";
    	} else {
    		document.querySelector("#hamburgerMenu").style.display = "inline";
    	}
    }
}
function toggleDarkMode(){
    if(document.querySelectorAll(".toggleDarkMode-Light").length>0 && document.querySelectorAll(".toggleDarkMode-Dark").length>0){
        if(getCookie("darkmode")=="true"){
            setCookie("darkmode", "false");
            document.querySelector("body").classList.remove("dark");
            for(i in document.querySelectorAll(".toggleDarkMode-Dark")){
                if(typeof document.querySelectorAll(".toggleDarkMode-Dark")[i]==="object"){
                    document.querySelectorAll(".toggleDarkMode-Dark")[i].style.display = "inline";
                }
            }
            for(i in document.querySelectorAll(".toggleDarkMode-Light")){
                if(typeof document.querySelectorAll(".toggleDarkMode-Light")[i]==="object"){
                    document.querySelectorAll(".toggleDarkMode-Light")[i].style.display = "none";
                }
            }
        } else {
            setCookie("darkmode", "true");
            document.querySelector("body").classList.add("dark");
            for(i in document.querySelectorAll(".toggleDarkMode-Light")){
                if(typeof document.querySelectorAll(".toggleDarkMode-Light")[i]==="object"){
                    document.querySelectorAll(".toggleDarkMode-Light")[i].style.display = "inline";
                }
            }
            for(i in document.querySelectorAll(".toggleDarkMode-Dark")){
                if(typeof document.querySelectorAll(".toggleDarkMode-Dark")[i]==="object"){
                    document.querySelectorAll(".toggleDarkMode-Dark")[i].style.display = "none";
                }
            }
        }
    }
}

//Toggle 2x pra remover a duplicidade dos botões "Modo claro e Modo noturno"...
//O primeiro remove a duplicidade
//O segundo deixa como o user salvou.
toggleDarkMode();
toggleDarkMode();
