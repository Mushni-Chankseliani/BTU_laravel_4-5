@extends('layout')


@section('content')
    <table id="person-table" class="table table-dark table-hover">
        <thead>
            <th>ID</th>
            <th>name</th>
            <th>country</th>
            <th>actions</th>
        </thead>
        <tbody>
            <form id="person-form" action="{{ route('person.store') }}" method="POST">
                {{-- @csrf --}}
                <tr>
                    <td>#</td>
                    <td><input id="person-name" type="text" name="name" value="{{ request()->name }}" class="form-control"></td>
                    <td>
                        <select class="form-control" name="person-country_id" id="person-country_id">
                            <option value=""></option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                        {{-- <input id="person-country_id" type="number" name="country_id" value="{{ request()->name }}" class="form-control"> --}}
                    </td>
                    <td><button id="person-submit-button" class="btn btn-success w-100">add</button>
                </tr>
            </form>

            <?php foreach ($persons as $person): ?>
                <tr>
                    <td>{{ $person->id }}</td>
                    <td>{{ $person->name }}</td>
                    <td>
                        @foreach ($countries as $country)
                            @if($country->id == $person->country_id) 
                                {{ $country->name }}
                            @endif
                        @endforeach
                        {{-- {{ $person->country_id }} --}}
                    </td>
                    <td class="d-flex">
                        {{-- <a class="btn btn-primary mr-2">edit</a> --}}
                        <a href="{{ URL::to('person/' . $person->id . '/edit') }}" class="btn btn-primary mr-2">edit</a>
                        <button data-id="{{ $person->id }}" id="delete-button" class="btn btn-danger">Delete</button>
                        {{-- <form action="{{ route('person.delete') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $car->id }}">
              
                            <button type="submit" class="btn btn-danger">Delete</button>
                          </form> --}}
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div id="persons-list">
        @foreach ( $countries as $country )
            <div>
                @foreach ($country->persons()->get() as $persons)
                <div class="card" style="width: 18rem;">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item"><p>{{$persons->name}}</p></li>
                    </ul>
                  </div>
                @endforeach
            </div>
        @endforeach
    </div>

    <script>
        function uploadTables() {
            $("#person-table").load(location.href + " #person-table > *");
            $("#persons-list").load(location.href + " #persons-list > *");
        }
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click',"#person-submit-button", function(e) {
                var url = "{{ route('person.store')  }}";
                var type = "POST";
                
                // if($("#person-to-edit-id").val()){
                //     url = "person/" + $("#person-to-edit-id").val();
                //     type = 'PUT';
                // }
            e.preventDefault();
                $.ajax({
                    url : url,
                    type: type,
                    data : {
                        // id : $("#person-to-edit-id").val(),
                        name : $("#person-name").val(),
                        country_id : $("#person-country_id").val()
                    },
                    success: function () {
                        uploadTables();
                        
                    },
                    error: function() {
                    }
                });
            });
        });
    </script>

    <script>
        $(document).on('click','#delete-button',function(e) {
        e.preventDefault();
        var itemId = $(e.currentTarget).data("id");
            $.ajax({
                url : "person/" + itemId,
                type: "DELETE",
                success: function () {
                    uploadTables();
                },
                error: function() {
                }
            });
        });
    
    </script>

@endsection
