$( function() {
    fetchTasks();
     
    //obatener producto por id mediante AJAX
    function fetchTasks(){
        var urlParams = new URLSearchParams(window.location.search);
        let id = urlParams.get('id');
        console.log(id);
        $.post('query-producte-individual.php', {id: id}, function(response){
            producte = JSON.parse(response);
            producteInfo(producte);
        })
    }
    
    //renderizar en el DOM la tabla con la info del producto
    function producteInfo(producte){
        let template= '';
        if ($('#load-text').length > 0) {
            $('#load-text').remove();
        }
        template = `<div id="table-content"
                    <div class='table'><table class='cards-table'>
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Preu(€)</th>
                                        <th>Categoria</th>
                                        <th>Publicació</th>
                                        <th>Descripció</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class='nom'>${producte[0].nom}</td>
                                        <td class='preu'>${producte[0].preu}</td>
                                        <td class='categoria'>${producte[0].categoria}</td>
                                        <td class='data'>${producte[0].data}</td>
                                        <td class='descripcio'>${producte[0].descripcio}</td>
                                    </tr>                  
                                </tbody>
                            </table>
                        </div>
                        <div id='carouselExampleControls' class='carousel slide' data-ride='carousel'>
                        <div class='carousel-inner'>
                        <div class='carousel-item active'>
                            <img src='imagenes/${producte[0].foto1}' class='h-50 w-100' >
                        </div>
                        <div class='carousel-item'>
                            <img src='imagenes/${producte[0].foto2}' class='h-50 w-100' >
                        </div>
                        <div class='carousel-item'>
                            <img src='imagenes/${producte[0].foto3}' class='h-50 w-200'  >
                        </div>
                    </div>`;
        $('#table-info').html(template);
    }

});