<table>
    <tr>
        <td colSpan="7">{{$descripcionFiltro}}</td>
    </tr>
</table>
<table>

    <tr>
        <td>Año</td>
        <td>Libro</td>
        <td>Folio</td>
        <td>Apellidos y Nombres</td>
        <td>Sexo</td>
        <td>Fecha</td>
        <td>Registrado por</td>
    </tr>

    @foreach ($nacimientos as $fila)
    <tr>
        <td>{{($fila['ano_nac']) !==null?($fila['ano_nac']):($fila['ano_nac'])}}</td>
        <td>{{($fila['nro_lib']) !==null?($fila['nro_lib']):($fila['nro_lib'])}}</td>
        <td>{{($fila['nro_fol']) !==null?($fila['nro_fol']):($fila['nro_fol'])}}</td>
        <td>{{($fila['nom_nac']) !==null?($fila['nom_nac']):($fila['nom_nac'])}} {{($fila['ape_pat_na']) !==null?($fila['ape_pat_na']):($fila['ape_pat_na'])}} {{($fila['ape_mat_na']) !==null?($fila['ape_mat_na']):($fila['ape_mat_na'])}}</td>
        <td>{{($fila['sex_nac']) !==null?($fila['sex_nac']==1?'Masculino':($fila['sex_nac']==2?'Femenino':'')):''}}</td>
        <td>{{($fila['fch_nac']) !==null?($fila['fch_nac']):($fila['fch_nac'])}}</td>
        <td>{{($fila['usuario']) !==null?($fila['usuario']):($fila['usuario'])}}</td>

    </tr>
    @endforeach


</table>