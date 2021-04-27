let map, lat, lng;

$(document).ready(function(){
    document.getElementById("precioMax").addEventListener("blur",validatePrice);
    document.getElementById("precioMin").addEventListener("blur",validatePrice);
    var regex = /^\d*[.]?\d*$/;
    //comprobación form Rango precios
    $("#precioMax").on("input", function(){
        var inputVal = $(this).val();
        if(regex.test(inputVal)){
            $(this).removeClass("error").addClass("success");
        } else{
            $(this).removeClass("success").addClass("error");
        }
    });

    $("#precioMin").on("input", function(){
        var inputVal = $(this).val();
        if(regex.test(inputVal)){
            $(this).removeClass("error").addClass("success");
        } else{
            $(this).removeClass("success").addClass("error");
        }
    });

    //comprobación form Search Box
    const regex_serach = /^(?:[A-Za-z]+)(?:[A-Za-z0-9 _]*)$/;
    $("#search").on("input", function(){
        var inputVal = $(this).val();
        if(regex_serach.test(inputVal) && inputVal.length < 201 || inputVal.length == 0){
            $(this).removeClass("error").addClass("success");
        } else{
            $(this).removeClass("success").addClass("error");
        }
    });
    function validatePrice(){
        let precioMax = $('#precioMax').val();
        let precioMin = $('#precioMin').val();
        console.log(precioMax + " " +  precioMax);
        if ( precioMax < precioMin ){
            setErrorPrice("El precio máximo ha de ser mayor que el precio mínimo.");
            
        } else {
            setSuccessPrice();
            
        }
    }

    function setErrorPrice(message) {
        feedback = document.getElementById("feedback");
        feedback.classList.add("alert-danger");
        feedback.innerHTML = message;
        $('#precioMax').removeClass("success").addClass("error");
        $('#precioMin').removeClass("success").addClass("error");
    }
      
    function setSuccessPrice() {
        feedback = document.getElementById("feedback");
        if (feedback.classList.contains("alert-danger")){
            feedback.classList.remove("alert-danger");
        }
        $('#precioMax').removeClass("error").addClass("success");
        $('#precioMin').removeClass("error").addClass("success");
    }
});

$( function() {
    //Obtener categoria mediante ajax
    fetchCategories();
    fetchProductes();

    $(document).ready(function(){
        $('[type="checkbox"]').change(function(){
          if(this.checked){
             $('[type="checkbox"]').not(this).prop('checked', false);
          }
        });
    });

    //Aplicar filtros y obtener datos con AJAX    
    $('#consulta').submit(function(e){
        const postData = {
            categoria: $('#categoria').val(),
            ordenarPrecio: $('#ordenarPrecio').val(),
            ordenarFecha: $('#ordenarFecha').val(),
            search: $('#search').val(),
            precioMax: $('#precioMax').val(),
            precioMin: $('#precioMin').val(),
        };
        console.log(postData.precioMin);
        $.post('query-products-filtered.php', postData, function(response){
            let products = JSON.parse(response);
            if ( "resultado" in products){
                //hide
                hideOrShow(document.getElementById("card-container"), "hide");
                hideOrShow(document.getElementById("resMapa"), "hide");
                //show
                hideOrShow(document.getElementById("noResult"), "show");

            }else{
                if ($('#checkbox').is(':checked')) {
                    hideOrShow(document.getElementById("noResult"), "hide");
                    hideOrShow(document.getElementById("resMapa"), "hide");
                    hideOrShow(document.getElementById("card-container"), "show");
                    cards(products);
                }else{
                    hideOrShow(document.getElementById("noResult"), "hide");
                    hideOrShow(document.getElementById("card-container"), "hide");
                    hideOrShow(document.getElementById("resMapa"), "show");
                    mapa(products);
                }
            }                
        })
        e.preventDefault();
    });

    function hideOrShow(x, accion){
        if ( accion == "hide"){
            x.style.display = "none";
        } else {
            x.style.display = "block";
        }
    }

    //Listado en cards
    function cards(products){
        let template = '';
        for (var i=0; i < products.length; i++){
            template +=
            `<div productId="${products[i].id}"id="cards-content" class="col align-self-center ">
              <div class="card" style="width: 18rem;">
                <img src='imagenes/`+products[i].foto+`' class="card-img-top" style="max-height:250px; max-width: 250px; object-fit:contain">
                <div class="card-body">
                  <h5 class="card-title">`+products[i].nom+`</h5>
                  <h6 class="card-subtitle mb-2 text-muted">`+products[i].preu+`</h6>
                  <a href="#" class="info-producte btn btn-primary">Mes informació</a>
                </div>
              </div>
            </div>`;
        }
        $('#cardList').html(template);
    }

    //Redirección a producte info
    $(document).on('click','.info-producte', function(e){
        let element = $(this)[0].parentElement.parentElement.parentElement;
        let id = $(element).attr('productId');
        window.location.href = 'producte-info.php?id=' + id;
        e.preventDefault();
    })

    //Mapa
    function mapa(products){
        loadMap();
        products.forEach( producte => { 
            lat = producte.latitud;
            lng = producte.longitud;
            var marker = L.marker([lat, lng]).addTo(map);
            // map.setView([lat, lng], 15);
            marker.bindPopup(`<div productId="${producte.id}"id="cards-content" class="col align-self-center ">
            <div class="card" style="width: 18rem;">
              <img src='imagenes/`+producte.foto+`' class="card-img-top" id="marker-img" style="max-height:100px; max-width: 100px; object-fit: contain;">
              <div class="card-body">
                <h5 class="card-title">`+producte.nom+`</h5>
                <h6 class="card-subtitle mb-2 text-muted">`+producte.preu+`</h6>
                <a href="#" class="info-producte btn btn-primary">Mes informació</a>
              </div>
            </div>
          </div>`);    

            marker.on('click', () => {
                marker.openPopup();
            });
        });
    }

    // MAPS FUNCTIONS
    function loadMap(){

        map = L.map('map').setView([41.388, 2.159], 12);
        L.esri.basemapLayer('Topographic').addTo(map);
    }

    //obtener todos los productos mediante AJAX
    function fetchProductes(){
        $.ajax({
            url: 'query-products.php',
            type: 'GET',
            async: false,
            success: function(response){
                let products = JSON.parse(response);
                hideOrShow(document.getElementById("noResult"), "hide");
                hideOrShow(document.getElementById("resMapa"), "hide");
                hideOrShow(document.getElementById("card-container"), "show");
                cards(products);
            }   
        });
    }

    //obtener las categorias mediante AJAX
    function fetchCategories(){
        $.ajax({
            url: 'query-producte-categoria.php',
            type: 'GET',
            async: false,
            success: function(response){
                let categorias = JSON.parse(response);
                let template = '<option value="Todas">Todas las categorias </option>';
                for ( i = 1; i < categorias.length; i++) {
                    template += `<option value="${categorias[i].categoriaNom}">${categorias[i].categoriaNom}</option>`
                }
                $('#categoria').html(template);
            }   
        });
    }
});
