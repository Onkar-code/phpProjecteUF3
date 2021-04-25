window.onload = function () {

    document.querySelector("button[type=submit]").addEventListener("click", validate);

    fetchCategories();
  
    document.getElementById("name").addEventListener("blur",validateName);
    document.getElementById("price1").addEventListener("blur",validatePrice1);
    document.getElementById("price2").addEventListener("blur",validatePrice2);
    document.getElementById("desc").addEventListener("blur",validateDesc);
    document.getElementById("categoria").addEventListener("blur",validateCategoria);

    document.getElementById("foto1").addEventListener('change', (e) => {
        var fileName = document.getElementById("foto1").files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    })
    document.getElementById("foto2").addEventListener('change', (e) => {
        var fileName = document.getElementById("foto2").files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    })
    document.getElementById("foto3").addEventListener('change', (e) => {
        var fileName = document.getElementById("foto3").files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    })
}

function validate(e){
    if (!validateName() || !validatePrice1() || !validatePrice2() || !validateDesc() || !validateCategoria() || !validateFoto1() | !validateFoto2() | !validateFoto3()){
        e.preventDefault();
    }
}

function validateName(){
    var nameInput = document.getElementById("name");
    return validateNotEmpty(nameInput);
}
  
function validatePrice1(){
    var price1Input = document.getElementById("price1");
    if (!validateNotEmpty(price1Input)) {
        return false;
    }
    
    var price1Value = price1Input.value.trim();
    if (price1Value && isValidPrice(price1Value)){
        setSuccess(price1Input);
        return true;
    } else {
        setError(price1Input,"El formato del precio no es correcto");
        return false;
    }
} 
  
function validatePrice2(){
    var price2Input = document.getElementById("price2");
    if (!validateNotEmpty(price2Input)) {
        return false;
    }
    
    var price2Value = price2Input.value.trim();
    if (price2Value && isValidPrice(price2Value)){
        setSuccess(price2Input);
        return true;
    } else {
        setError(price2Input,"El formato de los céntimos no es correcto");
        return false;
    }
} 

function validateDesc(){
    var descInput = document.getElementById("desc");
    return validateNotEmpty(descInput);
}

function validateCategoria() {
    var categoriaInput = document.getElementById("categoria");
    return validateNotEmpty(categoriaInput);
}

function validateFoto1() {
    var foto1Input = document.getElementById("foto1");
    return validateNotEmpty(foto1Input);
}

function validateFoto2() {
    var foto2Input = document.getElementById("foto2");
    return validateNotEmpty(foto2Input);
}

function validateFoto3() {
    var foto3Input = document.getElementById("foto3");
    return validateNotEmpty(foto3Input);
}

function validateNotEmpty(input){
    var inputValue = input.value.trim();
    if (inputValue){
        setSuccess(input);
        return true;
    } else {
        setError(input,"El campo no puede estar vacío");
        return false;
    }
}

function setSuccess(input){
    if (input.classList.contains("is-invalid")){
        input.classList.replace("is-invalid", "is-valid");
    } else {
        input.classList.add("is-valid");
    }
}

function setError(input, message){

    if (input.classList.contains("is-valid")){
        input.classList.replace("is-valid", "is-invalid");
    } else {
        input.classList.add("is-invalid");
    }

    var feedback = input.nextElementSibling
    feedback.innerHTML = message;
}

function isValidPrice(price) {
    var re = /^\d+$/g;
    return re.test(price);
}

//Obtener las categorias mediante AJAX
function fetchCategories(){
    $.ajax({
        url: 'query-producte-categoria.php',
        type: 'GET',
        success: function(response){
            let categorias = JSON.parse(response);
            let template = '<option selected value="">Selecciona una opción</option>';
            for ( i = 1; i < categorias.length; i++) {
                template += `<option value="${categorias[i].categoriaNom}">${categorias[i].categoriaNom}</option>`
            }
            $('#categoria').html(template);
        }
    });
}