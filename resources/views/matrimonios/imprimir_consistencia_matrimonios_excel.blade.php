<table>
    <tr>
        <td colSpan="7">{{$descripcionFiltro}}</td>
    </tr>
</table>
<table>

<table>
    <tr>
        <td>Año</td>
        <td>Libro</td>
        <td>Folio</td>
        <td>Apellidos y Nombres Esposo</td>
        <td>Apellidos y Nombres Esposa</td>
        <td>Fecha</td>
        <td>Registrado por</td>
    </tr>

    @foreach ($matrimonios as $fila)
    <tr>
        <td>{{($fila['ano_cel']) !==null?($fila['ano_cel']):($fila['ano_cel'])}}</td>
        <td>{{($fila['nro_lib']) !==null?($fila['nro_lib']):($fila['nro_lib'])}}</td>
        <td>{{($fila['nro_fol']) !==null?($fila['nro_fol']):($fila['nro_fol'])}}</td>
        <td>{{($fila['nom_mar']) !==null?($fila['nom_mar']):($fila['nom_mar'])}} {{($fila['ape_pat_ma']) !==null?($fila['ape_pat_ma']):($fila['ape_pat_ma'])}} {{($fila['ape_mat_ma']) !==null?($fila['ape_mat_ma']):($fila['ape_mat_ma'])}}</td>
        <td>{{($fila['nom_esp']) !==null?($fila['nom_esp']):($fila['nom_esp'])}} {{($fila['ape_pat_es']) !==null?($fila['ape_pat_es']):($fila['ape_pat_es'])}} {{($fila['ape_mat_es']) !==null?($fila['ape_mat_es']):($fila['ape_mat_es'])}}</td>
        <td>{{($fila['fch_cel']) !==null?($fila['fch_cel']):($fila['fch_cel'])}}</td>
        <td>{{($fila['usuario']) !==null?($fila['usuario']):($fila['usuario'])}}</td>

    </tr>
    @endforeach


</table>