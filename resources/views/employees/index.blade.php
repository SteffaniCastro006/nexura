@extends('layouts.master')


@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Lista de Empleados</h1>
        </div>
        <div class="col-md-10 col-sm-12"></div>
        <div class="col-md-2 col-sm-12" style="text-align: end;">
            <a href="{{ route('employees.create') }}" class="btn btn-primary" alt="Editar">
                <i class="fas fa-user-plus"></i>
                Crear
            </a>
        </div>
        <div class="col-md-12">
            <table class="table" style="width:100%">
                <thead>
                    <tr>
                    <th scope="col">
                        <i class="fas fa-user"></i>
                        Nombre
                    </th>
                    <th scope="col">
                        <i class="fas fa-at"></i>
                        Email
                    </th>
                    <th scope="col">
                        <i class="fas fa-venus-mars"></i>
                        Sexo
                    </th>
                    <th scope="col">
                        <i class="fas fa-briefcase"></i>
                        Area
                    </th>
                    <th scope="col">
                        <i class="fas fa-envelope"></i>
                        Boletín 
                    </th>
                    <th scope="col">Modificar</th>
                    <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')

@php
$edit_route = route("employees.edit", ["employee" => 'id-here']);
$delete_route = route("employees.destroy", ["employee" => 'id-here']);
@endphp

<script>

    $(document).delegate('.delete-item', 'click', function () {
        let confirmation = confirm('¿Estás seguro que deseas eliminar este elemento?');

        if (!confirmation) return;

        $(this).closest('form').submit();
    });

    $(document).ready(function () {

		const table = $('.table').DataTable({
            searching: false,
            processing: true,
            serverSide: true,
            orderCellsTop: true,
            lengthChange: false,
            ajax: {
                url: '{{ route('employees.index') }}',
                dataFilter: function(data){
                    var json = JSON.parse( data );
                    json.recordsTotal = json.last_page;
                    json.recordsFiltered = json.total;
        
                    return JSON.stringify( json );
                },
                data: function(data, settings){
                    const page = $('.table').DataTable().page.info().page;

                    for(let key in data.order){
                        const column = data.order[key].column;

                        data.order[key].column_name = settings.aoColumns[column].data;
                    }
                    
                    data.page = page + 1;
                }
            },
            columns: [
                { data: 'name' },
                { data: 'email' },
                { data: 'sex', render: function(data){
                    return (data == 'F') ? 'Femenino' : 'Masculino';
                } },
                { data: 'area.name' },
                { data: 'newsletter' , render: function(data){
                    return (data == 1) ? 'Si' : 'No';
                } },
                { data: 'actions', render: function(data, type, row, meta){

                    var edit = `<a href="{{ $edit_route }}" alt="Editar">
                        <i class="fas fa-edit"></i>
                    </a>`;

                    let actions = edit.replaceAll('id-here', row.id);

                    return `${actions}`;
                }, className: 'actions-column', orderable: false, searchable: false},
                { data: 'actions', render: function(data, type, row, meta){

                    var delete_ = `<form class="delete-form" method="POST" action="{{ $delete_route }}">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                            <a href="#" class="delete-item" alt="Eliminar">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                       </form>`;

                    let actions = delete_.replaceAll('id-here', row.id);

                    return `${actions}`;
                }, className: 'actions-column', orderable: false, searchable: false},
            ],
            order: [[ 0, "desc" ]]
        });

    });
    
</script>
@endsection