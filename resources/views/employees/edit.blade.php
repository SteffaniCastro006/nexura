@extends('layouts.master')


@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <h1>Crear Empleado</h1>
                </div>

                <div class="alert alert-primary" role="alert" id="alert" style="display:none;">
                    Los campos con asterisco (*) son obligatorios
                </div>

                <form id="employeeForm" action="{{ route('employees.update', ['employee' => $employee->id]) }}" method="POST">
                    @method('PUT')
                    {{ csrf_field() }}
                    <div class="row">
                        <label class="col-md-2 form-label" for="name">
                            <strong>Nombre Completo *</strong>
                        </label>
                        <input class="col-md-9 form-control" type="text" name="name" id="name" placeholder="Nombre Completo del Empleado" value="{{ $employee->name }}">
                    </div>
                    <div class="row">
                        <label class="col-md-2 form-label" for="email">
                            <strong>Correo Electronico *</strong>
                        </label>
                        <input class="col-md-9 form-control" type="email" name="email" id="email" placeholder="Correo Electronico" value="{{ $employee->email }}">
                    </div> 

                    <div class="row">
                        <label class="col-md-2 form-label" for="sex">
                            <strong>Sexo *</strong>
                        </label>
                        <div class="col-md-9">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sex" id="M" value="M" @if ($employee->sex == 'M') checked @endif>
                                <label class="form-check-label" for="M">
                                    Masculino
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sex" id="F" value="F" @if ($employee->sex == 'F') checked @endif>
                                <label class="form-check-label" for="F">
                                    Femenino
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-md-2 form-label" for="area">
                            <strong>Area *</strong>
                        </label>
                        <select class="form-select col-md-9" name="area_id">
                            @foreach($areas as $key => $area)
                                <option value="{{ $key }}" @if ($employee->area_id == $key) selected @endif> {{ $area }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <label class="col-md-2 form-label" for="description">
                            <strong>Description *</strong>
                        </label>
                        <textarea class="form-control col-md-9" name="description" rows="3" placeholder="Descripcion de la Experiencia del Empleado">{{ $employee->description }}</textarea>
                    </div>

                    <div class="row">
                        <label class="col-md-2 form-label" for="roles">
                            <strong>Roles *</strong>
                        </label>
                        <div class="col-md-9">
                            @foreach($roles as $key => $rol)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $key }}" @if (in_array($key, $roles_id)) checked @endif>
                                    <label class="form-check-label" for="roles">
                                        {{ $rol }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8" style="margin-top: 10px;">
                            <button type="submit" id="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>

@endsection


<style>
    .form-control {
        display: inline-block !important;
        width: 80% !important;
        margin-bottom: 10px !important;
    }

    .form-select{
        display: inline-block !important;
        width: 80% !important;
        margin-bottom: 10px !important;
        margin-top: 10px !important;
    }
</style>

@section('scripts')

<script>
    $(document).ready(function() {
	
	    $('#submit').click(function(event) {
            $("#employeeForm").validate({
                invalidHandler: function(event, validator) {
                    // 'this' refers to the form
                    var errors = validator.numberOfInvalids();
                    if (errors > 0) 
                        $("#alert").show();
                    
                }, 
                event: "blur",
                rules: {
                    name: { required: true},
                    email: { required: true},
                    sex: { required: true},
                    area_id: { required: true},
                    description: { required: true},
                    roles: { required: true}
                },
                messages: {
                    name: "",
                    email: "",
                    sex: "",
                    area_id: "",
                    description: "",
                    roles: ""
                },
                debug: false,errorElement: "label",
                errorPlacement: function(error, element) 
                {
                    if ( element.is(":radio") ) 
                    {
                        error.appendTo( element.parents('.container') );
                    }
                    else 
                    { // This is the default behavior 
                        error.insertAfter( element );
                    }
                },
                submitHandler: function(form) {

                    event.preventDefault();
                    $("#alert").hide();

                    let confirmation = confirm('¿Estás seguro que editar crear este elemento?');

                    if (!confirmation) return;
                    
                    form.submit();
                    
                }
            });
        });
    });
</script>
@endsection