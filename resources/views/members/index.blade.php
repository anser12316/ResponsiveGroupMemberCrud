@extends('layouts.app')

@section('content')
    <h1>Members List</h1>

    <div class="mb-3">
        <a href="{{ route('groups.store') }}" class="btn btn-primary">Groups</a>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createMemberModal">
            Create Member
        </button>
    </div>

    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone Number</th>
                <th>Groups</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

            <!-- Create Member Modal -->
            <div class="modal fade" id="createMemberModal" tabindex="-1" role="dialog"
            aria-labelledby="createMemberModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createMemberModalLabel">Create Member</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="createMemberForm" action="{{ route('members.store') }}" method="post">

                            @csrf

                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="first_name">First Name:</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="last_name">Last Name:</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="phone_no">Phone Number:</label>
                                <input type="text" name="phone_no" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="group_id">Groups:</label>
                                <select name="group_id[]" class="form-control" multiple>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Create Member</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

            @foreach ($members as $member)
                <tr>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->first_name }}</td>
                    <td>{{ $member->last_name }}</td>
                    <td>{{ $member->phone_no }}</td>
                    <td>
                        @foreach ($member->groups as $group)
                            {{ $group->name }}<br>
                        @endforeach
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-link edit_member" data-id="{{ $member->id }}"
                            data-page="{{ $members->currentPage() }}" data-toggle="modal"
                            data-target="#editMemberModal{{ $member->id }}">
                            <span class="text-dark">Edit</span>
                        </button>
                        <form action="{{ route('members.destroy', [$member->id, $members->currentPage()]) }}"
                            method="post" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-link delete_member"
                                data-id="{{ $member->id }}" data-page="{{ $members->currentPage() }}">
                                <span class="text-danger">Delete</span>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
        <!-- Update Member Modal -->
        <div class="modal fade" id="editMemberModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content" id="editMembmerModalData">
                
                </div>
            </div>
        </div>

    <div class="mt-3">
        {{ $members->links() }}
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <script>
        // Create member on the same page
        $(document).ready(function() {
            $('#createMemberForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('members.store') }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        console.log(response);
                        $('#createMemberModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });
        });

        function redirectPage(page) {
            console.log(page);
            var redirect = "{{ route('members.index', ['page' => '_page']) }}";
            redirect = redirect.replace('_page', page);
            console.log(redirect);
            window.location.href = redirect;
        }

        // Edit
        $(document).on('click', '.edit_member', function() {
            var edit_id = $(this).data('id');
            var currentPage = $(this).data('page');
            var url = "{{ route('members.edit', [':id', ':page']) }}";
            url = url.replace(':id', edit_id);
            url = url.replace(':page', currentPage);
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    console.log(response);
                    $("#editMembmerModalData").html(response);
                    $("#editMemberModal").modal('show');
                }
            });
        });

        // Update
        $(document).ready(function() {
            $('.update-member-btn').on('click', function() {
                var memberId = $(this).data('member-id');
                var formId = '#updateMemberForm' + memberId;

                $.ajax({
                    url: "{{ route('members.update', ['member' => $member->id, 'page' => $members->currentPage()]) }}",
                    type: 'POST',
                    data: $(formId).serialize(),
                    success: function(response) {
                        console.log(response);
                        $('#editMemberModal' + memberId).modal('hide');
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });
        });

        // Delete
        $(document).on('click', '.delete_member', function() {
            var del_id = $(this).data('id');
            var currentPage = $(this).data('page');
            var url = "{{ route('members.destroy', [':id', ':page']) }}";
            url = url.replace(':id', del_id);
            url = url.replace(':page', currentPage);
            if (confirm('Are You Sure To Delete The Member?')) {
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response) {
                        if (response.success) {
                            alertify.success("Member Deleted Successfully!");
                            redirectPage(response.page);
                        } else {
                            alertify.error("Something Went Wrong!");
                        }
                    }
                });
            } else {
                return false;
            }
        });
    </script>
@endsection

