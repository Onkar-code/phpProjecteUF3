window.onload = function () {

    document.querySelector("button[type=submit]").addEventListener("click", validate);

    var feedback = document.getElementById("feedback");
    if (feedback.innerHTML != "") {
        feedback.classList.add("alert-danger");
    }
  
    document.getElementById("user").addEventListener("blur",validateUser);
    document.getElementById("pass").addEventListener("blur",validatePass);
}

function validate(e){
    if (!validateUser() || !validatePass()){
        e.preventDefault();
    }
  }
  
  function validateUser(){
    var userInput = document.getElementById("user");
    return validateNotEmpty(userInput);
  }
  
  function validatePass(){
    var passInput = document.getElementById("pass");
    return validateNotEmpty(passInput);
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