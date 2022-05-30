function productAction(id, action)
{
    if(action=='delete')
    {
        // modal excluir
        link='excluir('+id+')';
        $("#excluir_button").attr('onclick',link)
        $(".id-product-excluir").html(id);
        $("#modal").show();
    }
}

function excluir(id)
{
    console.log(id);
    $.post('../../app/model/Entity/delete.php',{id},
    function()
    {
        location.reload();
    });
}


function modal_close()
{
    $("#modal").hide();
}