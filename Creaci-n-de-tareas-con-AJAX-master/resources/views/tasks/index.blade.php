@extends('layouts.main')

@section('content')
    <h1>Lista de tareas</h1>
    <div class="row">
        <div class="col-12">
            <table class="table" id = "table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Pending</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $item)
                        <tr id = "{{$item->id}}">
                            <td>{{ $item->id}}</td>
                            <td>{{ $item->description}}</td>
                            @if ($item->is_done === 0)
                                <td id = "{{$item->id}}-pendiente">Yes</td>
                                  
                            @else
                                <td id = "{{$item->id}}-pendiente">No</td>
                            @endif
                            <td>
                                <button type="button" class="btn btn-primary" onclick = "updateTask({{$item->id}})">Done</button>
                            </td> 
                            <td>
                                <form action="">
                                    <input id= "id" type="hidden" value = "{{$item->id}}">
                                    <button type="button" class="btn btn-primary" onclick = "deleteTask({{$item->id}},this)">Delete</button>
                                </form>
                                
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

            $('.table tbody').append('<tr id= '+ response.id +'><td>' + response.id + '</td><td>' + response.description + '</td><td id = "'+response.id+'-pendiente">Yes</td><td><button type="button" class="btn btn-primary" onClick = "updateTask('+response.id+')">Done</button></td><td><input id= "id" type="hidden" value = " '+ response.id +'"><button type="button" class="btn btn-primary" onclick = "deleteTask('+ response.id +', this)">Delete</button></td></tr>')
            $('#description').val('');
        })
        .fail(function(jqXHR, response) {
            console.log('Fallido', response);
        });
    }
    function deleteTask(id, r){
        console.log(id);
        let str = 'http://ajax.test/tasks/'+id+''
        console.log(r.parentNode.parentNode.parentNode);
        var i = r.parentNode.parentNode.rowIndex;
        if (i === undefined) {
            i = r.parentNode.parentNode.parentNode.rowIndex;
        }
        console.log(i);
        $.ajax({
            url: str,
            method: 'DELETE',
            headers:{
                'Accept': 'application/json',
                'X-CSRF-Token': $('meta[name="csrf-token"').attr('content')
            }
        })
        document.getElementById("table").deleteRow(i);
        
    }
    function updateTask(id){
        let status = "true"
        let str = 'http://ajax.test/tasks/'+id+''
        console.log(str);
        $.ajax({
            url: str,
            method: 'PUT',
            headers:{
                'Accept': 'application/json',
                'X-CSRF-Token': $('meta[name="csrf-token"').attr('content')
            },
            data:{
                id:id,
                status:status    
            }
        }).done(function(response) {
            console.log("Exito")
            let idStr = ''+id+'-pendiente'
            document.getElementById(idStr).innerHTML = "No"
        })
        .fail(function(jqXHR, response) {
            console.log('Fallido', response);
        });

    }

</script>    


@endpush