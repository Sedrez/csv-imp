const csvToArray = (csvStr, delimiter = ",") => {
    csvStr = csvStr.trim();
    console.log(csvStr);
    const headers = csvStr.slice(0, csvStr.indexOf("\n")).split(delimiter);
    const rows = csvStr.slice(csvStr.indexOf("\n") + 1).split("\n");
    const csvArray = rows.map(function (row) {
        const values = row.split(delimiter);
        const objectRows = headers.reduce(function (objectRow, header, index) {
            objectRow[header] = values[index];
            return objectRow;
        }, {});
        return objectRows;
    });
    return csvArray;
}

const printMsg = (msg, style) => {
    $("#printMsg").html('');
    let divMsg = '<div class="alert alert-'+style+' alert-dismissible fade show" role="alert">'
    divMsg += msg
    divMsg += '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>'
    divMsg += '</div>';
    $("#printMsg").append(divMsg);
}

const renderDataTable = (jsonData, table) => {
    var td = '';
    
    $(table+' tbody').empty();
    $(table).show();
    
    $.each(jsonData, function(id, row){
        $.each(row, function(id, data){ 
            if (data == null){
                data = '';
            }
            else{
                var website = new RegExp('^(http[s]?:\\/\\/(www\\.)?|ftp:\\/\\/(www\\.)?|www\\.){1}([0-9A-Za-z-\\.@:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?');
                if (website.test(data) && id == "website")
                    td += '<td><a class="btn btn-primary" href="'+data+'" target="_blanck">Acessar</a></td>';
                else
                    td += '<td>'+data+'</td>';
            }
        });
        $(table+' > tbody:last').append('<tr>' + td + '</tr>');
        td = '';
    });
}