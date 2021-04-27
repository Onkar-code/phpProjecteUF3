window.onload = function () {

    document.querySelector("button[type=submit]").addEventListener("click", validate);
  
    document.getElementById("name").addEventListener("change",validateName);
    document.getElementById("price1").addEventListener("change",validatePrice1);
    document.getElementById("price2").addEventListener("change",validatePrice2);
    document.getElementById("desc").addEventListener("change",validateDesc);
}

function validate(e){
    if (!validateName() || !validatePrice1() || !validatePrice2() || !validateDesc()){
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