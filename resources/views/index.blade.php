<!DOCTYPE html>
<html>
<head>
    <title>CSV Imp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.5/r-2.2.9/datatables.min.css"/>
    <link href="css/dvstrtm_jqp_graph.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/dvstrtm_jqp_graph.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/r-2.2.9/datatables.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script>
        const csvToArray = (csvStr, delimiter = ",") => {
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
            var data = '';
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
        const countValid = (data) => {
            var count = [];
            count['email'] = 0;
            count['last_name'] = 0;
            count['gender'] = 0;

            $.each(data, function(id, column){
                let valid = String(column.email)
                            .toLowerCase()
                            .match(
                                /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                            );
                if (valid)
                    count['email']++;
                if (column.last_name.trim() != '')
                    count['last_name']++;
                if (column.gender.trim() != '')
                    count['gender']++;
            });
            return count;
        };

        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const execDataTable = (table, data) => {
                if ($.fn.DataTable.isDataTable(table))
                    $(table).DataTable().destroy(); 

                renderDataTable(data, table);
                $(table).DataTable({
                    language: {
                        url: 'translation/pt-BR.json'
                    }
                });
                $('#loadingTable').toggleClass('d-none');
            }
            const execDataChart = (graph, data) => {
                var count = countValid(data);
                var total = data.length;
                var dataChart = [
                    {
                        label: 'E-mails Inválidos',
                        color:['red'],
                        value: [total-count['email']]
                    },
                    {
                        label: 'E-mails Válidos',
                        color:['green'],
                        value: [count['email']]
                    },
                    {
                        label: 'Sem Sobrenome',
                        color:['red'],
                        value: [total-count['last_name']]
                    },
                    {
                        label: 'Com Sobrenome',
                        color:['green'],
                        value: [count['last_name']]
                    },
                    {
                        label: 'Sem Gênero',
                        color:['red'],
                        value: [total-count['gender']]
                    },
                    {
                        label: 'Com Gênero',
                        color:['green'],
                        value: [count['gender']]
                    }
                ]
                $(graph).html('');
                $(graph).dvstrtm_graph({
                    theme: 'light',
                    title: 'Qualidade dos Registros Importados',
                    description: '',
                    unit: '',
                    better: '',
                    type: 'number',
                    separate: false,
                    labels: true,
                    grid_wmax: total,
                    grid_part: 5,
                    points: [],
                    graphs: dataChart
                });
            }
            const renderDataChart = (chart) => {
                $.ajax({
                    type:'GET',
                    url:"{{ route('customers.data_chart') }}",
                    contentType: "json",
                    processData: false,
                    success:function(data){
                        execDataChart(chart, data);
                    }
                });      
               
            }
            const renderDataList = (table) => {
                $('#loadingTable').toggleClass('d-none');
                $.ajax({
                    type:'GET',
                    url:"{{ route('customers.data_list') }}",
                    contentType: "json",
                    processData: false,
                    success:function(data){
                        execDataTable(table, data);    
                    }
                });            
            }
            renderDataList('#customerTable');
            renderDataChart('#customerGraph');
            
            $(document).on('change','#csvFile' , function(){ 
                $("#printMsg").html('');
                $('#loading').toggleClass('d-none');
                const csvObj = $(this);
                const csv = csvObj.prop('files')[0];

                const reader = new FileReader();

                reader.onload = function (e) {
                    const csvStr = e.target.result;
                    const dataJson = JSON.stringify(csvToArray(csvStr));
                    $.ajax({
                        type:'POST',
                        url:"{{ route('customers.store') }}",
                        data:dataJson,
                        contentType: "json",
                        processData: false,
                        success:function(data){
                              
                            if($.isEmptyObject(data.error)){
                                renderDataList('#customerTable');
                                renderDataChart('#customerGraph');
                                printMsg(data.success+'<br>Arquivo: '+csvObj.val().split('\\').pop(), 'success');
                            }else{
                                printMsg(data.error+'<br>Arquivo: '+csvObj.val().split('\\').pop(), 'danger');
                            }
                            $('#loading').toggleClass('d-none');
                            csvObj.val('');  
                        }
                    });
                };

                reader.readAsText(csv); 
            });
        });
    </script>
</head>
    <body>
        <div class="container-sm">
            <div class="row mb-3 mt-5">
                <div class="col">
                   <h2>Importação de Clientes</h2>
                </div>
            </div>
            <div class="row mb-3 mt-5">
                <div class="col">
                    <label for="csvFile" class="form-label">Arquivo CSV</label>
                    <input class="form-control" type="file" id="csvFile" accept=".csv">
                </div>
            </div>
            <div id="printMsg"></div>
            <div class="text-center">
                <div id='loading' class="spinner-border d-none" role="status"></div>
            </div> 
            <div class="row mb-5 mt-5">
                <div class="col">
                    <table id="customerTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Sobrenome</th>
                                <th>E-mail</th>
                                <th>Gênero</th>
                                <th>IP</th>
                                <th>Empresa</th>
                                <th>Cargo</th>
                                <th>Cidade</th>
                                <th>Site</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <div class="text-center">
                        <div id='loadingTable' class="spinner-border d-none" role="status"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-5 mt-5">
                <div class="col">
                    <div id="customerGraph" class="graph__block"></div>
                </div>
            </div>
        </div>
    </body>
</html>
 

