@extends('layouts.main')

@section('content')
    <h1>Lista de tareas</h1>
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Pending</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $item)
                        <tr>
                            <td>{{ $item->description}}</td>
                            @if ($item->is_done === 0)
                                <td>Yes</td>  
                            @endif
                            <td>
                                <button type="button" class="btn btn-primary">Done</button>
                            </td>
                        </tr>
                    @endforeach
                    
                    
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-1-12">
            <label>Create Task</label>
            <br>
            <div class="form-group">
                <input type="text" class="form-control" name="description" id="description" aria-describedby="helpId" placeholder="">
                <br>
                <button type="button" class="btn btn-primary" onclick="createTask()">Create</button>

            </div>
        </div> 
    </div>

@endsection

@push('layout_end_body')
<script>
     function createTask() {
        let theDescription = $('#description').val();
        $.ajax({
            url: '{{ route('tasks.store') }}',
            method: 'POST',
            headers:{
                'Accept': 'application/json',
                'X-CSRF-Token': $('meta[name="csrf-token"').attr('content')
            },
            data: {
                description: theDescription
            }
        })
        .done(function(response) {
            console.log('Éxitoso', response);
        })
        .fail(function(jqXHR, response) {
            console.log('Fallido', response);
        });
    }

</script>    


@endpush