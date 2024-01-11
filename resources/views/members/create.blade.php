@extends('layouts.app')

@section('content')
    <h1>Create Member</h1>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createMemberModal">
        Create Member
    </button>

    <!-- Create Member Modal -->
    <div class="modal fade" id="createMemberModal" tabindex="-1" role="dialog" aria-labelledby="createMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createMemberModalLabel">Create Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('members.store') }}" method="post">
                        @csrf

                        <label for="email">Email:</label>
                        <input type="email" name="email" required>
                        <br>

                        <label for="first_name">First Name:</label>
                        <input type="text" name="first_name" required>
                        <br>

                        <label for="last_name">Last Name:</label>
                        <input type="text" name="last_name" required>
                        <br>

                        <label for="phone_no">Phone Number:</label>
                        <input type="text" name="phone_no" required>
                        <br>

                        {{-- <label for="add_to_group">Add to Group:</label>
                        <input type="text" name="add_to_group">
                        <br> --}}

                        <label for="group_id">Groups:</label>
                        <select name="group_id[]" multiple>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                        <br>

                        <button type="submit" class="btn btn-primary">Create Member</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create Member</h2>

        

        <form action="{{ route('members.store') }}" method="post">
            @csrf

            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control">

            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" class="form-control">

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" class="form-control">

            <label for="phone_no">Phone Number:</label>
            <input type="text" name="phone_no" class="form-control">
            <label for="phone_no">Group:</label>

            @foreach ($groups as $group)
                <li class="list-group-item">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="group_id[]" value="{{ $group->id }}"
                            data-group-name="{{ $group->name }}">
                        {{ $group->name }}
                    </label>
                </li>
            @endforeach
           

            <button type="submit" class="btn btn-success mt-3">Create Member</button>
        </form>
        
    </div>

    {{-- <!-- Modal -->
    <div class="modal fade" id="selectGroupsModal" tabindex="-1" role="dialog" aria-labelledby="selectGroupsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selectGroupsModalLabel">Select Groups</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        @foreach ($groups as $group)
                            <li class="list-group-item">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="group_id[]"
                                        value="{{ $group->id }}" data-group-name="{{ $group->name }}">
                                    {{ $group->name }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div> --}}
{{-- @endsection --}} 
