<div class="block permissions_container">
    @foreach($permission_groups as $permission_group)
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="card">
            <div class="header bg-blue-grey">
                <h2>
                    {{ $permission_group->name }} Access
                </h2>
            </div>
            <div class="body">
                @foreach($permission_group->permissions as $permission)
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{ Form::checkbox('permission[]', $permission->id, (!empty($role) ? ($role->permissions->contains('id', $permission->id)) : 0), array('class' => 'name', 'id' => 'role_' . $permission->id)) }}
                        <label for="role_{{ $permission->id }}">{{ $permission->name }}</label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
</div>
