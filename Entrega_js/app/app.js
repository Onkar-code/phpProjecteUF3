$( function() {

    $(document).ready(function(){

        $('[type="checkbox"]').change(function(){

          if(this.checked){
             $('[type="checkbox"]').not(this).prop('checked', false);
          }
        });

    });

    $('#consulta').submit(function(e){
        const postData = {
            categoria: $('#categoria').val(),
            ordenarPrecio: $('#ordenarPrecio').val(),
            ordenarFecha: $('#ordenarFecha').val(),
            search: $('#search').val(),
            precioMax: $('#precioMax').val(),
            precioMin: $('#precioMin').val(),
        };
        $.post('query-products-filtered.php', postData,

        function(response){
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

    function noResponse(){
        let template = '<h1 id="noResult" class="pt-4" style="text-align:center;"> No se han encontrado resultados<h1>';
        $('#resultados').html(template);
    }

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

    $(document).on('click','.info-producte', function(e){
        let element = $(this)[0].parentElement.parentElement.parentElement;
        let id = $(element).attr('productId');
        window.location.href = 'producte-info.php?id=' + id;
        
        e.preventDefault();
    })

    function mapa(products){
        
        if ($('#noResult').length > 0) {
            $('#noResult').remove();
        }
        //TODO desarrollar mapa
    }

    function fetchProducts(){
        $.ajax({
            url: 'query-products.php',
            type: 'GET',
            success: function(response){
                let products = JSON.parse(response);
            }
        });
    }
});
