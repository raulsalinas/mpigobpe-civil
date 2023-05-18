<table>
    <tr>
        <td>Año</td>
        <td>Libro</td>
        <td>Folio</td>
        <td>Apellido de Marido</td>
        <td>Nombres de Marido</td>
        <td>Ubigeo de Marido</td>
        <td>Nombres del Esposa</td>
        <td>Ubigeo de Esposa</td>
        <td>Fecha Celebración</td>
        <td>Fecha Inscripción</td>
        <td>Concición</td>
        <td>Observa</td>
    </tr>
    @foreach ($data as $fila)
    <tr>
        <td>{{($fila['ano_eje']) !==null?($fila['ano_eje']):($fila['ano_eje'])}}</td>
        <td>{{($fila['nro_lib']) !==null?($fila['nro_lib']):($fila['nro_lib'])}}</td>
        <td>{{($fila['nro_fol']) !==null?($fila['nro_fol']):($fila['nro_fol'])}}</td>
        <td>{{($fila['ape_mar']) !==null?($fila['ape_mar']):($fila['ape_mar'])}}</td>
        <td>{{($fila['nom_mar']) !==null?($fila['nom_mar']):($fila['nom_mar'])}}</td>
        <td>{{($fila['ubigeo_marido']) !==null?($fila['ubigeo_marido']):($fila['ubigeo_marido'])}}</td>
        <td>{{($fila['ape_esp']) !==null?($fila['ape_esp']):($fila['ape_esp'])}}</td>
        <td>{{($fila['nom_esp']) !==null?($fila['nom_esp']):($fila['nom_esp'])}}</td>
        <td>{{($fila['ubigeo_esposa']) !==null?($fila['ubigeo_esposa']):($fila['ubigeo_esposa'])}}</td>
        <td>{{($fila['usuario']) !==null?($fila['usuario']):($fila['usuario'])}}</td>
        <td>{{($fila['fch_cel']) !==null?($fila['fch_cel']):($fila['fch_cel'])}}</td>
        <td>{{($fila['fch_reg']) !==null?($fila['fch_reg']):($fila['fch_reg'])}}</td>
        <td>{{($fila['condic']) !==null?($fila['condic']):($fila['condic'])}}</td>
        <td>{{($fila['observa']) !==null?($fila['observa']):($fila['observa'])}}</td>

    </tr>
    @endforeach


</table>