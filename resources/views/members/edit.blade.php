<div class="modal-header">
    <h5 class="modal-title" id="editMemberModalLabel">Edit Member</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form action="{{ route('members.update', $member->id) }}" method="post">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ $member->email }}">
        </div>

        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" class="form-control" value="{{ $member->first_name }}">
        </div>

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" class="form-control" value="{{ $member->last_name }}">
        </div>

        <div class="form-group">
            <label for="phone_no">Phone Number:</label>
            <input type="text" name="phone_no" class="form-control" value="{{ $member->phone_no }}">
        </div>


        <div class="form-group">
            <label for="group_id">Groups:</label>
            <select name="group_id[]" class="form-control" multiple>
                @foreach ($groups as $group)
                    <option value="{{ $group->id }}"
                        {{ in_array($group->id, $member->groups->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $group->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Member</button>
    </form>
</div>
