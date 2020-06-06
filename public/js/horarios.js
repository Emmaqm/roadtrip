placeholderO.onclick = function(){
    open(origenes);
	destinos.style.visibility = "hidden";
    changeIcon(openOrigenesBtn);
    restoreIcon(openDestinosBtn);
}

placeholderD.onclick = function(){
    if(textOrigen.innerText != "Origen"){   
        open(destinos);
        origenes.style.visibility = "hidden";
        changeIcon(openDestinosBtn);
        restoreIcon(openOrigenesBtn);
    }
}

function changeIcon(idIcon){
    if(idIcon.className == "fas fa-chevron-down arrow"){
        $(idIcon).removeClass('fa-chevron-down arrow').addClass('fa-times');
    }else{
        $(idIcon).removeClass('fa-times').addClass('fa-chevron-down arrow');
    }
}

function open(openElement){
    if(openElement.style.visibility == "visible"){ 
        openElement.style.visibility = "hidden";
    }else{  
        openElement.style.visibility = "visible";
    }
}

function restoreIcon(idIcon){
    if(idIcon.className == "fas fa-times"){
        $(idIcon).removeClass('fa-times').addClass('fa-chevron-down arrow');
    }
}


function addOrigen(liOrigen){
	var origenText = liOrigen.innerText;
	textOrigen.innerText = origenText;
    origenes.style.visibility = "hidden";
    changeIcon(openOrigenesBtn);
    textDestino.innerText = "Destino";


    $.get("cargar_destinos.php", {origen:origenText}).done(function(data){
        $("#destinos").html(data);
        })
}

function addDestino(liDestino){
	var destinoText = liDestino.innerText;
	textDestino.innerText = destinoText;
    destinos.style.visibility = "hidden";
    changeIcon(openDestinosBtn);
}

function displayHorarios(day){
    var origenText = textOrigen.innerText;
    var destinoText = textDestino.innerText;

    if(origenText != "Origen" && destinoText != "Destino"){
        $.get("cargar_horarios.php", {origen:origenText, destino:destinoText, dia:day}).done(function(data){
            $("#horariosTable").html(data);
        })
    }

}