<table>
    <tr>
        <td>Año</td>
        <td>Libro</td>
        <td>Folio</td>
        <td>Nombres del Nacido</td>
        <td>Apellido Paterno del Nacido</td>
        <td>Apellido Matero del Nacido</td>
        <td>Sexo</td>
        <td>Fecha de Nacimiento</td>
        <td>Ubigeo</td>
        <td>Nombres del Padre</td>
        <td>Apellidos del Padre</td>
        <td>Nombres de la Madre</td>
        <td>Apellidos de la Madre</td>
        <td>Fecha de Inscripción</td>
        <td>Condición</td>
        <td>Observa</td>
    </tr>
    @foreach ($data as $fila)
    <tr>
        <td>{{($fila['ano_eje']) !==null?($fila['ano_eje']):($fila['ano_eje'])}}</td>
        <td>{{($fila['nro_lib']) !==null?($fila['nro_lib']):($fila['nro_lib'])}}</td>
        <td>{{($fila['nro_fol']) !==null?($fila['nro_fol']):($fila['nro_fol'])}}</td>
        <td>{{($fila['nom_nac']) !==null?($fila['nom_nac']):($fila['nom_nac'])}}</td>
        <td>{{($fila['ape_pat_nac']) !==null?($fila['ape_pat_nac']):($fila['ape_pat_nac'])}}</td>
        <td>{{($fila['ape_mat_nac']) !==null?($fila['ape_mat_nac']):($fila['ape_mat_nac'])}}</td>
        <td>{{($fila['sex_nac']) !==null?($fila['sex_nac']):($fila['sex_nac'])}}</td>
        <td>{{($fila['fch_nac']) !==null?($fila['fch_nac']):($fila['fch_nac'])}}</td>
        <td>{{($fila['ubigeo_desc']) !==null?($fila['ubigeo_desc']):($fila['ubigeo_desc'])}}</td>
        <td>{{($fila['nom_pad']) !==null?($fila['nom_pad']):($fila['nom_pad'])}}</td>
        <td>{{($fila['ape_pad']) !==null?($fila['ape_pad']):($fila['ape_pad'])}}</td>
        <td>{{($fila['nom_mad']) !==null?($fila['nom_mad']):($fila['nom_mad'])}}</td>
        <td>{{($fila['ape_mad']) !==null?($fila['ape_mad']):($fila['ape_mad'])}}</td>
        <td>{{($fila['fch_ing']) !==null?($fila['fch_ing']):($fila['fch_ing'])}}</td>
        <td>{{($fila['condic']) !==null?($fila['condic']):($fila['condic'])}}</td>
        <td>{{($fila['observa']) !==null?($fila['observa']):($fila['observa'])}}</td>
 

    </tr>
    @endforeach


</table>