var dateObj = new Date();
var month = dateObj.getUTCMonth() + 2;
var day = dateObj.getUTCDate();
var year = dateObj.getUTCFullYear();
var myDate = month+"-"+day+"-2020"; 

const MyCalendar = new HelloWeek({
    selector: '.hello-week',
    lang: 'es',
    langFolder: './dist/langs/',
    format: "DD-MM-YYYY",
    weekShort: true,
    monthShort: false,
    multiplePick: false,
    defaultDate: false,
    todayHighlight: true,
    disablePastDays: true,
    disabledDaysOfWeek: false,
    disableDates: false,
    weekStart: 0,
    daysHighlight: false,
    range: false,
    minDate: false,
    maxDate: myDate,
    nav: ['◀', '▶'],
    onLoad: updateInfo,
    onChange: updateInfo,
    onSelect: updateInfo
});

/*------------------------------------------------------------------*/

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

date.onclick = function() {
    datepicker.style.position = "static"
    open(datepicker);
	destinos.style.visibility = "hidden";
    origenes.style.visibility = "hidden";
    changeIcon(openCalendarBtn);
}

function changeIcon(idIcon){
    if(idIcon.className == "fas fa-chevron-down arrow"){
        $(idIcon).removeClass('fa-chevron-down arrow').addClass('fa-times');
    }else{
        $(idIcon).removeClass('fa-times').addClass('fa-chevron-down arrow');
    }
}

function restoreIcon(idIcon){
    if(idIcon.className == "fas fa-times"){
        $(idIcon).removeClass('fa-times').addClass('fa-chevron-down arrow');
    }
}

function open(openElement){
    if(openElement.style.visibility == "visible"){ 
        openElement.style.visibility = "hidden";
        if(openElement == datepicker){
            datepicker.style.position = "fixed";
        }
    }else{  
        openElement.style.visibility = "visible";
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

consultar_viaje.onclick = function(){
    var tOrigen = textOrigen.innerText;
    var tDestino = textDestino.innerText;
    var tFecha = selectDate.innerText;

    var dia = tFecha.substring(0,2);
    var mes = tFecha.substring(3,5);
    var año = tFecha.substring(6);

    mes = parseInt(mes) - 1;

    var d = new Date(año, mes, dia);
    var weekday = new Array(7);
    weekday[0] = "Domingo";
    weekday[1] = "Lunes";
    weekday[2] = "Martes";
    weekday[3] = "Miércoles";
    weekday[4] = "Jueves";
    weekday[5] = "Viernes";
    weekday[6] = "Sábado";

    var dia_semana = weekday[d.getDay()];

    if(tOrigen != "Origen" && tDestino != "Destino"){
        consultar_viaje.href = "viajes.php?"+"origen="+ tOrigen+ "&destino=" + tDestino + "&dia=" + dia_semana + "&fecha=" + tFecha;
    }else{
        consultar_viaje.href = "reservas.php?vError=true";
    }
}

/*----------------------------------------------------------------------*/

	function updateInfo() {
		if (this.getToday()) {
			selectDate.innerHTML = this.getToday();
		}

		if (this.lastSelectedDay) {
            if (selectDate.innerHTML = this.lastSelectedDay){
                
            }       	
		}
	}

/*----------------------------------------------------------------------*/
