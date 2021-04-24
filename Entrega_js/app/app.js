$(document).ready(function(){
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
        if(regex_serach.test(inputVal) && inputVal.length < 201){
            $(this).removeClass("error").addClass("success");
        } else{
            $(this).removeClass("success").addClass("error");
        }
    });
});

$( function() {
    //Obtener categoria mediante ajax
    fetchCategories();

    $(document).ready(function(){
        $('[type="checkbox"]').change(function(){
          if(this.checked){
             $('[type="checkbox"]').not(this).prop('checked', false);
          }
        });
    });

    //Apliar filtros y obtener datos con AJAX    
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
                noResponse();
            }else{
                if ($('#checkbox').is(':checked')) {
                    cards(products);
                }else{
                    alert("Has de elegir el tipo de vista. Si has elegido mapa, aún esta por desarrollarse");
                }
            }                
        })
        e.preventDefault();
    });

    function objLength(obj){
        var i=0;
        for (var x in obj){
          if(obj.hasOwnProperty(x)){
            i++;
          }
        } 
        return i;
    }

    //consulta sin resultados
    function noResponse(){
        let template = '<h1 id="noResult" class="pt-4" style="text-align:center;"> No se han encontrado resultados<h1>';
        $('#resultados').html(template);
    }

    //Listado en cards
    function cards(products){

        if ($('#noResult').length > 0) {
            $('#noResult').remove();
            let card = `<div id="card-container" class="container-fluid py bg-primary">
                <div id="cardList" class="row">
                </div>
            </div>`;
            $('#resultados').html(card);
        }
        if ($('#cards-content').length > 0) {
            $('#cards-content').remove();
        }
        let template = '';
        for (var i=0; i < products.length; i++){
            template +=
            `<div productId="${products[i].id}"id="cards-content" class="col align-self-center ">
              <div class="card" style="width: 18rem;">
                <img src='imagenes/`+products[i].foto+`' class="card-img-top" >
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

    //TODO desarrollar mapa
    function mapa(products){
        if ($('#noResult').length > 0) {
            $('#noResult').remove();
        }
    }

    //obtener todos los productos mediante AJAX
    function fetchProducts(){
        $.ajax({
            url: 'query-products.php',
            type: 'GET',
            success: function(response){
                let products = JSON.parse(response);
            }
        });
    }

    //obtener las categorias mediante AJAX
    function fetchCategories(){
        $.ajax({
            url: 'query-producte-categoria.php',
            type: 'GET',
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
