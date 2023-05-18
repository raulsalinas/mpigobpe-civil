<table>
    <tr>
        <td>Año</td>
        <td>Libro</td>
        <td>Folio</td>
        <td>Apellidos</td>
        <td>Nombres</td>
        <td>Motivo</td>
        <td>Fecha Defun.</td>
        <td>Registrado por</td>
        <td>Fecha registro</td>
        <td>Observa</td>
    </tr>
    @foreach ($data as $fila)
    <tr>
        <td>{{($fila['ano_eje']) !==null?($fila['ano_eje']):($fila['ano_eje'])}}</td>
        <td>{{($fila['nro_lib']) !==null?($fila['nro_lib']):($fila['nro_lib'])}}</td>
        <td>{{($fila['nro_fol']) !==null?($fila['nro_fol']):($fila['nro_fol'])}}</td>
        <td>{{($fila['ape_des']) !==null?($fila['ape_des']):($fila['ape_des'])}}</td>
        <td>{{($fila['nom_des']) !==null?($fila['nom_des']):($fila['nom_des'])}}</td>
        <td>{{($fila['motivo_defuncion']) !==null?($fila['motivo_defuncion']):($fila['motivo_defuncion'])}}</td>
        <td>{{($fila['fch_des']) !==null?($fila['fch_des']):($fila['fch_des'])}}</td>
        <td>{{($fila['usuario']) !==null?($fila['usuario']):($fila['usuario'])}}</td>
        <td>{{($fila['fch_reg']) !==null?($fila['fch_reg']):($fila['fch_reg'])}}</td>
        <td>{{($fila['observa']) !==null?($fila['observa']):($fila['observa'])}}</td>

    </tr>
    @endforeach


</table>