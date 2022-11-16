<table>
    <tr>
        <td>Año</td>
        <td>Libro</td>
        <td>Folio</td>
        <td>Apellidos y Nombres</td>
        <td>Sexo</td>
        <td>Motivo</td>
        <td>Fecha</td>
        <td>Registrado por</td>
    </tr>
    @foreach ($defunciones as $fila)
    <tr>
        <td>{{($fila['ano_des']) !==null?($fila['ano_des']):($fila['ano_des'])}}</td>
        <td>{{($fila['nro_lib']) !==null?($fila['nro_lib']):($fila['nro_lib'])}}</td>
        <td>{{($fila['nro_fol']) !==null?($fila['nro_fol']):($fila['nro_fol'])}}</td>
        <td>{{($fila['nom_des']) !==null?($fila['nom_des']):($fila['nom_des'])}} {{($fila['ape_pat_de']) !==null?($fila['ape_pat_de']):($fila['ape_pat_de'])}} {{($fila['ape_mat_de']) !==null?($fila['ape_mat_de']):($fila['ape_mat_de'])}}</td>
        <td>{{($fila['sexo']) !==null?($fila['sexo']=='M'?'Masculino':($fila['sexo']=='F'?'Femenino':'')):''}}</td>
        <td>{{($fila['motivo']) !==null?($fila['motivo']):($fila['motivo'])}}</td>
        <td>{{($fila['fch_des']) !==null?($fila['fch_des']):($fila['fch_des'])}}</td>
        <td>{{($fila['usuario']) !==null?($fila['usuario']):($fila['usuario'])}}</td>

    </tr>
    @endforeach


</table>