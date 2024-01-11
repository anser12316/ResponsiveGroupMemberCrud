@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Groups</h2>
        <a href="{{ route('members.index') }}" class="btn btn-primary">Members List</a>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addGroupModal">
            Add Group
        </button>

        <!-- Modal -->
        <div class="modal fade" id="addGroupModal" tabindex="-1" role="dialog" aria-labelledby="addGroupModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addGroupModalLabel">Add Group</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addGroupForm" method="POST" action="{{ route('groups.store') }}">
                            <div class="form-group">
                                <label for="groupName">Group Name</label>
                                <input type="text" class="form-control" id="groupName" name="name">
                                <span id="name_error" class="text-danger error"></span>
                            </div>
                            @csrf
                            <button type="submit" class="btn btn-primary">Save Group</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groups as $group)
                        <tr>
                            <td>{{ $group->id }}</td>
                            <td>{{ $group->name }}</td>
                            <td>
                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                    data-target="#editGroupModal{{ $group->id }}">Edit</button>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editGroupModal{{ $group->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Group</h5>

                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <form class="editGroupForm" data-group-id="{{ $group->id }}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="name">Group Name</label>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" value="{{ $group->name }}">
                                                        <span id="u_name_error" class="text-danger error"></span>
                                                    </div>
                                                    <input type="hidden" name="update_id" value="{{ $group->id }}">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete button -->
                                <form action="{{ route('groups.destroy', $group->id) }}" method="post"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $('#addGroupForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('groups.store') }}",
                type: 'POST',
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response)
                    if (response.success) {
                        $('#addGroupModal').modal('hide');
                        window.location.reload();
                    }
                },
                error: function(error) {
                    $('.error').text('');
                    $.each(error.responseJSON.errors, function(index, value) {
                        $("#" + index + "_error").text(value[0]);
                    })
                }
            });
        });

        $('.editGroupForm').on('submit', function(e) {
            console.log($(this).data('group-id'));
            e.preventDefault();
            var groupId = $(this).data('group-id');
            var url = "{{ route('groups.update') }}";
            // url = url.replace(':id', groupId);
            $.ajax({
                url: url,
                method: 'POST',
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        $('#editGroupModal' + groupId).modal('hide');
                        window.location.reload();
                    }
                },
                error: function(error) {
                    $('.error').text('');
                    $.each(error.responseJSON.errors, function(index, value) {
                        $("#" + 'u_' + index + "_error").text(value[0]);
                    });
                }
            });
        });
    });
    $(document).on('submit', '#update_edit_form', function(e) {
        e.preventDefault();
        $.ajax({
            url: "",
            type: "POST",
            data: $(this).serialize(),
            beforeSend: function() {
                $("#updatebtn").text('Processing...');
                $("#updatebtn").prop('disabled', true);
            },
            error: function(error) {
                $("#update_btn").text('Update Group');
                $("#update_btn").prop('disabled', false);
                if ('errors' in error.responseJSON) {
                    if ('errors' in error.responseJSON) {
                        $(".error").text('');
                        $.each(error.responseJSON.errors, (index, value) => {
                            $(document).find("#u_" + index + "_error").text(value[0]);
                        });
                    }
                }
            },
            success: function(data) {
                $("#update_btn").text('Update Meeting');
                $("#update_btn").prop('disabled', false);
                if (data.success) {
                    success("Meeting Updated Successfully!");
                } else {
                    error("Something Went Wrong!");
                }
            }
        });
    });
</script>
