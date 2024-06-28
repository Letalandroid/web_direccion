function soloNumeros(event) {
    var numero = event.keyCode || event.which;
    if ((numero> 0 && numero <33)||(numero >= 48 && numero <= 57) || (numero >= 96 && numero <= 105) || (numero == 8) || (numero == 46) || (numero == 37) || (numero == 39)) {
        return true;
    } else {
        alert('Solo se permiten Números.');
        return false;
    }
}

function soloLetras(event) {
    var letras = event.keyCode;
    if ((letras > 0 && letras < 33) || 
    (letras > 64 && letras < 91) || 
    (letras > 96 && letras < 123) || 
    (letras == 241 || letras == 209) || 
    (letras >= 37 && letras <= 40)||
    (letras >= 221)) {
        return true;
    } else {
        alert('Solo se permiten Letras y teclas permitidas.');
        return false;
    }
}
