<table>
    <tr>
        <td colspan="11" style="text-align: center;">LISTA DE COBROS</td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th width="5">N°</th>
            <th width="10">Fecha</th>
            <th width="15">Recibo</th>
            <th width="15">Tipo</th>
            <th width="10">Año</th>
            <th width="10">Nro. Libro</th>
            <th width="10">Nro. Folio</th>
            <th width="20">Tipo Recibo</th>
            <th width="20">Monto</th>
            <th width="30">Solicitante</th>
            <th width="10">Estado</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($cobros as $key => $cobro)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $cobro->fecha }}</td>
            <td>{{ $cobro->recibo }}</td>
            <td>{{ $cobro->tipo }}</td>
            <td>{{ $cobro->ano }}</td>
            <td>{{ $cobro->libro }}</td>
            <td>{{ $cobro->folio }}</td>
            <td>{{ $cobro->tiprec }}</td>
            <td>{{ $cobro->monto }}</td>
            <td>{{ $cobro->solicitant }}</td>
            <td>{{ $cobro->estado }}</td>
        </tr>
        @endforeach
    </tbody>
</table>