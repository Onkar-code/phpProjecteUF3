$(document).ready(function(){
    $(document).on('click','.info-producte', function(e){
        let id = $(this).attr('id');
        window.location.href = 'producte-info.php?id=' + id;
    })
});