let map, lat, lng;

$( function() {
    document.getElementById("precioMax").addEventListener("blur",validatePrice);
    document.getElementById("precioMin").addEventListener("blur",validatePrice);

    //Obtener categorias y productos mediante ajax
    fetchCategories();
    fetchProductes();

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
        $.post('query-products-filtered.php', postData, function(response){
            let products = JSON.parse(response);
            if ( "resultado" in products){
                //hide
                hideOrShow(document.getElementById("card-container"), "hide");
                hideOrShow(document.getElementById("resMapa"), "hide");
                //show
                hideOrShow(document.getElementById("noResult"), "show");

            }else{
                if ($('#list').is(':checked')) {
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
            `<div productId="${products[i].id}"id="cards-content" class="col align-self-center">
              <div class="card my-2" style="width: 18rem;">
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

function validatePrice(){
    var maxPrice = document.getElementById("precioMax");
    var minPrice = document.getElementById("precioMin");
    var maxValid = validateSinglePrice(maxPrice);
    var minValid = validateSinglePrice(minPrice);
    console.log(maxValid);
    if (!maxValid || !minValid) {
        return;
    }
    var feedback = document.getElementById("price-feedback");
    if (maxPrice.value < minPrice.value){
        feedback.innerHTML = "El precio máximo ha de ser mayor que el precio mínimo";
        feedback.classList.add("alert-danger");
    } else {
        feedback.innerHTML = "";
        feedback.classList.remove("alert-danger");
    }
}

function validateSinglePrice(price) {
    var regex = /^\d*[.]?\d*$/;
    if (regex.test(price.value)) {
        price.classList.remove("is-invalid");
        return true;
    }
    else {
        price.classList.add("is-invalid");
            var feedback = document.getElementById("price-feedback");
        feedback.innerHTML = "";
        feedback.classList.remove("alert-danger");
        return false;
    }
}