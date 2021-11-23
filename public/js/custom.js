
function alerError(err){
    if (err.status == 422) { 
        dataError = err.responseJSON.errors;
        var pesan = "";
        Object.keys(dataError).map(function (val, label){
            pesan = pesan + '<b>' + val + '</b>' + ' : ' + dataError[val][0] + '<br/>';
        })
        Swal.fire(
            'Failed Input',
            pesan,
            'error'
        )
        
    }
}