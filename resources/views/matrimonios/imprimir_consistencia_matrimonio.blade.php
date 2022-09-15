<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        body {
            background-color: #fff;
            font-family: "DejaVu Sans";
            font-size: 10px;
            box-sizing: border-box;
            padding: 10px;
        }

        table {
            width: 90%;
            height: auto;
            border-collapse: collapse;
        }

        .tablePDF {
            width: 95%;
        }

        .tablePDF thead {
            padding: 4px;
            background-color: #8a897a;
            color: white;
        }

        .tablePDF,
        .tablePDF tr td {
            border: .5px solid #dbdbdb;
        }

        .tablePDF tr td {
            padding: 5px;
        }

        .subtitle {
            font-weight: bold;
        }

        .bordebox {
            border: 1px solid #000;
        }

        .verticalTop {
            vertical-align: top;
        }

        .texttab {

            display: block;
            margin-left: 20px;
            margin-bottom: 5px;
        }


        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .left {
            text-align: left;
        }

        .justify {
            text-align: justify;
        }

        .top {
            vertical-align: top;
        }

        footer {
            position: relative;
        }

        .pie_de_pagina {
            position: absolute;
            bottom: 0px;
            right: 0px;
            text-align: right;
        }
    </style>
</head>

<body>

    <img src="" alt="Logo" height="75px">

    <h1 style="text-decoration: underline; text-align:center">REGISTRO DE MATRIMONIOS</h1>
    <br><br>
    <p class="subtitle justify">{{$descripcionFiltro}}</p>
    <table class="tablePDF" border=0 style="font-size:10px">
        <thead>
            <th class="subtitle">Año</th>
            <th class="subtitle">Libro</th>
            <th class="subtitle">Folio</th>
            <th class="subtitle">Apellidos y Nombres Esposo</th>
            <th class="subtitle">Apellidos y Nombres Esposa</th>
            <th class="subtitle">Fecha</th>
            <th class="subtitle">Registrado por</th>
        </thead>
        
        @foreach ($matrimonios as $fila)
        <tr>
            <td>{{($fila->ano_cel) !==null?($fila->ano_cel):($fila->ano_cel)}}</td>
            <td>{{($fila->nro_lib) !==null?($fila->nro_lib):($fila->nro_lib)}}</td>
            <td>{{($fila->nro_fol) !==null?($fila->nro_fol):($fila->nro_fol)}}</td>
            <td>{{($fila->nom_mar) !==null?($fila->nom_mar):($fila->nom_mar)}}{{($fila->ape_pat_ma) !==null?($fila->ape_pat_ma):($fila->ape_pat_ma)}}{{($fila->ape_mat_ma) !==null?($fila->ape_mat_ma):($fila->ape_mat_ma)}}</td>
            <td>{{($fila->nom_esp) !==null?($fila->nom_esp):($fila->nom_esp)}}{{($fila->ape_pat_es) !==null?($fila->ape_pat_es):($fila->ape_pat_es)}}{{($fila->ape_mat_es) !==null?($fila->ape_mat_es):($fila->ape_mat_es)}}</td>
            <td>{{($fila->fch_cel) !==null?($fila->fch_cel):($fila->fch_cel)}}</td>
            <td>{{($fila->usuario) !==null?($fila->usuario):($fila->usuario)}}</td>

        </tr>
        @endforeach


    </table>
    <br>

    <footer>
        <p style="font-size:9px; " class="pie_de_pagina">Generado por: </p>
    </footer>

</html>