let map, lat, lng;

window.onload = function () {

  loadMap();
  
  document.querySelector("button[type=submit]").addEventListener("click", validate);

  document.getElementById("name").addEventListener("blur",validateName);
  document.getElementById("surname1").addEventListener("blur",validateSurname1);
  document.getElementById("surname2").addEventListener("blur",validateSurname2);
  document.getElementById("user").addEventListener("blur",validateUser);
  document.getElementById("pass").addEventListener("blur",validatePass);
  document.getElementById("email").addEventListener("blur",validateEmail);
  document.getElementById("phone").addEventListener("blur",validatePhone);
  document.getElementById("dni").addEventListener("blur",validateDNI);
  document.getElementById("street").addEventListener("blur",validateStreet);
  document.getElementById("number").addEventListener("blur",validateNumber);
  document.getElementById("city").addEventListener("blur",validateCity);
  document.getElementById("findAddress").addEventListener("click", geocodeAddress);
  document.getElementById("saveAddress").addEventListener("click", saveAddress);

  userFeedback = document.getElementById("userFeedback");
  if (userFeedback.innerHTML != "") {
    document.getElementById("user").classList.add("is-invalid");
  }

  emailFeedback = document.getElementById("emailFeedback");
  if (emailFeedback.innerHTML != "") {
    document.getElementById("email").classList.add("is-invalid");
  }

  addressFeedback = document.getElementById("latitude");
  if (addressFeedback.value != "") {
    setSuccessAddress("La dirección sigue guardada, no te preocupes");
  }
}

function validate(e){
  if (!validateName() || !validateSurname1() || !validateSurname2() || !validateUser() 
    || !validatePass() || !validateEmail() || !validatePhone() || !validateDNI() || !validateAddress()){
      e.preventDefault();
  }
}

function validateName(){
  var nameInput = document.getElementById("name");
  return validateNotEmpty(nameInput);
}

function validateSurname1(){
  var surname1Input = document.getElementById("surname1");
  return validateNotEmpty(surname1Input);
}

function validateSurname2(){
  var surname2Input = document.getElementById("surname2");
  return validateNotEmpty(surname2Input);
}

function validateUser(){
  var userInput = document.getElementById("user");
  return validateNotEmpty(userInput);
}

function validatePass(){
  var passInput = document.getElementById("pass");
  if (!validateNotEmpty(passInput)) {
    return false;
  }

  var passValue = passInput.value.trim();
  if (passValue && isValidPass(passValue)){
      setSuccess(passInput);
      return true;
  } else {
      setError(passInput,"El formato de la contraseña no es correcto");
      return false;
  }
}

function validateEmail(){
  var emailInput = document.getElementById("email");
  if (!validateNotEmpty(emailInput)) {
    return false;
  }

  var emailValue = emailInput.value.trim();
  if (emailValue && isValidEmail(emailValue)){
      setSuccess(emailInput);
      return true;
  } else {
      setError(emailInput,"El formato del email no es correcto");
      return false;
  }
}

function validatePhone(){
  var phoneInput = document.getElementById("phone");
  if (!validateNotEmpty(phoneInput)) {
    return false;
  }

  var phoneValue = phoneInput.value.trim();
  if (phoneValue && isValidPhone(phoneValue)){
      setSuccess(phoneInput);
      return true;
  } else {
      setError(phoneInput,"El formato del teléfono no es correcto");
      return false;
  }
}

function validateDNI(){
  var dniInput = document.getElementById("dni");
  if (!validateNotEmpty(dniInput)) {
    return false;
  }

  var dniValue = dniInput.value.trim();
  if (dniValue && isValidDNI(dniValue)){
      setSuccess(dniInput);
      return true;
  } else {
      setError(dniInput,"El formato del DNI no es correcto");
      return false;
  }
}

function validateStreet(){
  var streetInput = document.getElementById("street");
  return validateNotEmpty(streetInput);
}

function validateNumber(){
  var streetInput = document.getElementById("number");
  return validateNotEmpty(streetInput);
}

function validateCity(){
  var streetInput = document.getElementById("city");
  return validateNotEmpty(streetInput);
}

function validateAddress() {
  if (document.getElementById("latitude").value == "") {
    setErrorAddress("Primero has de guardar una dirección");
    return false;
  }
  return true;
}

// COMMON FUNCTIONS

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

function isValidPass(pass){

  var re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/g;
  return re.test(pass);
}

function isValidEmail(email){

  var re = /^\w+(\.\w+)*@\w+(\.\w+){1,2}$/g;
  return re.test(email);
}

function isValidPhone(phone){

  var re = /^[^0]\d{8}$/g;
  return re.test(phone);

}

function isValidDNI(dni){

  var re = /^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKET]{1}$/g;

  if (!re.test(dni)) return false;

  // Check last letter
  var lastLetter = dni.substr(dni.length-1, dni.lenght);
  var index = parseInt(dni.substr(0, 8)) % 23;

  var dniLetters = 'TRWAGMYFPDXBNJZSQVHLCKET';
  if (dniLetters.charAt(index) == lastLetter) return true;

  return false;
}

// MAPS FUNCTIONS

function loadMap(){

  map = L.map('map').setView([41.388, 2.159], 12);
  L.esri.basemapLayer('Topographic').addTo(map);

}

function geocodeAddress(){

  var address = getAddress();
  if (!address) {
    return;
  }
  L.esri.Geocoding.geocode().text(address).run(function (err, results, response) {
    if (!err) {
      lat = results.results[0].latlng.lat;
      lng = results.results[0].latlng.lng;
      console.log("lat ="+lat+", lng = "+lng);

      // Add marker, set zoom and center map
      var marker = L.marker([lat, lng]).addTo(map);
      map.setView([lat, lng], 15);
    } else {
      console.log(err);
      alert("La geocodificación ha fallado a causa de lo siguiente: " + err);
    }
  });
}

function getAddress() {
  if (!validateStreet() | !validateNumber() | !validateCity()) {
    setErrorAddress("Rellena los campos de dirección de la izquierda y dale a Buscar")
    return;
  }
  var streetName = document.getElementById("street").value;
  var streetNumber = document.getElementById("number").value;
  var city = document.getElementById("city").value;
  var postalCode = document.getElementById("postal");
  var postalCodeValue = "";
  if (postalCode.value) {
    postalCodeValue = postalCode.value;
  }

  var address = `${streetName} ${streetNumber} ${city} ${postalCodeValue}`;
  return address;
}

function saveAddress() {
  if (!lat) {
    setErrorAddress("Primero has de buscar la dirección en el mapa y darle a Guardar");
    return;
  }

  document.getElementById("latitude").value = lat;
  document.getElementById("longitude").value = lng;
  setSuccessAddress("Se ha guardado la dirección con éxito.");
}

function setErrorAddress(message) {
  feedback = document.getElementById("feedback");
  if (feedback.classList.contains("alert-success")){
    feedback.classList.replace("alert-success", "alert-danger");
  } else {
    feedback.classList.add("alert-danger");
  }
  feedback.innerHTML = message;
}

function setSuccessAddress (message) {
  feedback = document.getElementById("feedback");
  if (feedback.classList.contains("alert-danger")){
    feedback.classList.replace("alert-danger", "alert-success");
  } else {
    feedback.classList.add("alert-success");
  }
  feedback.innerHTML = message;
}