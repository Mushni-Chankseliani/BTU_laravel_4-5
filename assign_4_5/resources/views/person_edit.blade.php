@extends('layout')


@section('content')

    <form method="PUT" action="{{ route('person.update', $person->id) }}" id="edit-person-table" onsubmit="updatePerson(event)">
        <div class="col-4 mb-3">
            <label for="name">Name</label>
            <input class="form-control" type="text" name="name" id="person-name" value="{{ $person -> name }}">
        </div>
        <div class="col-4 mb-3">
            <label for="country_id">country</label>

            <select class="form-control" name="country_id" id="country_id">
                <option value=""></option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" {{ $country->id == $person->country_id ? 'selected' : '' }}>{{ $country->name }}</option>
                @endforeach
            </select>

        </div>
        <div class="col-4">
            <button id="submit-edit" class="btn btn-primary">Edit</button>
        </div>
    </form>
@endsection

<script>
    function updatePerson(e) {
        e.preventDefault();
        var serializedForm = $(e.target).serialize();
        var url = $(e.target).attr('action');
        $.ajax({
            url: url + '?' + serializedForm,
            type: 'PUT',
            data: {},
            success: function(data) {
                alert(data.message);
            },
            error: function() {

            }
        })
    }
</script>