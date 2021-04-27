$( function() {
    fetchTasks();
    
    //obtener producto por id mediante AJAX
    function fetchTasks(){
        var urlParams = new URLSearchParams(window.location.search);
        let id = urlParams.get('id');
        $.post('query-producte-individual.php', {id: id}, function(response){
            producte = JSON.parse(response);
            producteInfo(producte);
        })
    }
    
    //renderizar en el DOM la tabla con la info del producto
    function producteInfo(producte){
        console.log(producte);
        let template = `<div id="table-content"
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
                                        <td class='data'>${producte[0].data_publicacio}</td>
                                        <td class='descripcio'>${producte[0].descripcio}</td>
                                    </tr>                  
                                </tbody>
                            </table>
                        </div>
                        <div class='imagenes'>
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img class="d-block w-100" src='imagenes/${producte[0].foto1}' alt="First slide">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src='imagenes/${producte[0].foto2}' alt="Second slide">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src='imagenes/${producte[0].foto3}' alt="Third slide">
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>`;
        $('#table-info').html(template);
    }

});