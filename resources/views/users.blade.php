@extends('layouts.app')

@section('content')
<div class="container">
    <ul class="nav nav-tabs" id="userRoleTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab">
                Users
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="roles-tab" data-bs-toggle="tab" data-bs-target="#roles" type="button" role="tab">
                Roles & Permissions
            </button>
        </li>
    </ul>

    <div class="tab-content mt-4" id="userRoleTabContent">
        {{-- TAB USERS --}}
        <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="users-tab">
        <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white shadow-sm rounded-3">
            <h4 class="fw-bold mb-0 text-primary">
                <i class="bi bi-people me-2"></i> Daftar User
            </h4>
            <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="bi bi-plus-circle"></i>
                <span>Tambah User</span>
            </button>
        </div>
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach ($user->getRoleNames() as $role)
                                    <span class="badge border rounded 
                                        @if($role === 'admin') border-danger text-danger 
                                        @elseif($role === 'dokter') border-success text-success 
                                        @elseif($role === 'petugas') border-primary text-primary 
                                        @elseif($role === 'kasir') border-info text-info
                                        @else border-secondary text-secondary @endif">
                                        <i class="bi bi-person-badge me-1"></i> {{ ucfirst($role) }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-warning edit-user"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-email="{{ $user->email }}"
                                    data-role="{{ $user->getRoleNames()->first() ?? '' }}"
                                    data-bs-toggle="modal" data-bs-target="#editUserModal">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-user"
                                    data-id="{{ $user->id }}"
                                    data-bs-toggle="modal" data-bs-target="#deleteUserModal">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- TAB ROLES & PERMISSIONS --}}
        <div class="tab-pane fade" id="roles" role="tabpanel" aria-labelledby="roles-tab">
            <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white shadow-sm rounded-3">
                <h4 class="fw-bold mb-0 text-success">
                    <i class="bi bi-shield-lock me-2"></i> Daftar Roles
                </h4>
                <button class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                    <i class="bi bi-plus-circle"></i>
                    <span>Tambah Role</span>
                </button>
            </div>
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Role</th>
                        <th>Permissions</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>
                                @foreach ($role->permissions as $perm)
                                    <span class="badge border rounded border-info text-info">
                                        <i class="bi bi-shield-check me-1"></i> {{ ucfirst($perm->name) }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-warning edit-role"
                                    data-id="{{ $role->id }}"
                                    data-name="{{ $role->name }}"
                                    data-permissions="{{ $role->permissions->pluck('name') }}"
                                    data-bs-toggle="modal" data-bs-target="#editRoleModal">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-role"
                                    data-id="{{ $role->id }}"
                                    data-bs-toggle="modal" data-bs-target="#deleteRoleModal">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('user.store') }}">
            @csrf
            <div class="modal-header"><h5>Tambah User</h5></div>
            <div class="modal-body">
                <div class="mb-2"><label>Nama</label><input type="text" name="name" class="form-control" required></div>
                <div class="mb-2"><label>Email</label><input type="email" name="email" class="form-control" required></div>
                <div class="mb-2"><label>Password</label><input type="password" name="password" class="form-control" required></div>
                <div class="mb-2">
                    <label>Role</label>
                    <select name="role" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" id="editUserForm">
            @csrf @method('PUT')
            <div class="modal-header"><h5>Edit User</h5></div>
            <div class="modal-body">
                <input type="hidden" name="id" id="edit-user-id">
                <div class="mb-2"><label>Nama</label><input type="text" name="name" id="edit-user-name" class="form-control"></div>
                <div class="mb-2"><label>Email</label><input type="email" name="email" id="edit-user-email" class="form-control"></div>
                <div class="mb-2"><label>Password (kosongkan jika tidak ganti)</label><input type="password" name="password" class="form-control"></div>
                <div class="mb-2">
                    <label>Role</label>
                    <select name="role" id="edit-user-role" class="form-select">
                        <option value="">-- Pilih Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus user ini?
            </div>
            <div class="modal-footer">
                <form id="deleteUserForm" method="POST">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('roles.store') }}">
            @csrf
            <div class="modal-header"><h5>Tambah Role</h5></div>
            <div class="modal-body">
                <div class="mb-2"><label>Nama Role</label><input type="text" name="name" class="form-control" required></div>
                <div class="mb-2">
                    <label>Permissions</label><br>
                    @foreach ($permissions as $perm)
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $perm->name }}" id="add-role-perm-{{ $perm->id }}">
                            <label class="form-check-label" for="add-role-perm-{{ $perm->id }}">{{ $perm->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" id="editRoleForm">
            @csrf @method('PUT')
            <div class="modal-header"><h5>Edit Role</h5></div>
            <div class="modal-body">
                <input type="hidden" name="id" id="edit-role-id">
                <div class="mb-2"><label>Nama Role</label><input type="text" name="name" id="edit-role-name" class="form-control" required></div>
                <div class="mb-2">
                    <label>Permissions</label><br>
                    @foreach ($permissions as $perm)
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input edit-role-perm" name="permissions[]" value="{{ $perm->name }}" id="edit-role-perm-{{ $perm->id }}">
                            <label class="form-check-label" for="edit-role-perm-{{ $perm->id }}">{{ $perm->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRoleModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus role ini?
            </div>
            <div class="modal-footer">
                <form id="deleteRoleForm" method="POST">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(function(){
        // Mengisi data pada modal Edit User
        $('.edit-user').on('click', function(){
            let id = $(this).data('id');
            let name = $(this).data('name');
            let email = $(this).data('email');
            let role = $(this).data('role');
            
            $('#editUserForm').attr('action', `/user/${id}`);
            $('#edit-user-name').val(name);
            $('#edit-user-email').val(email);
            $('#edit-user-role').val(role);
        });

        // Mengisi data pada modal Hapus User
        $('.delete-user').on('click', function(){
            let id = $(this).data('id');
            $('#deleteUserForm').attr('action', `/user/${id}`);
        });

        // Mengisi data pada modal Edit Role
        $('.edit-role').on('click', function(){
            let id = $(this).data('id');
            let name = $(this).data('name');
            let permissions = $(this).data('permissions');

            $('#editRoleForm').attr('action', `/roles/${id}`);
            $('#edit-role-name').val(name);

            // Reset semua checkbox permission
            $('.edit-role-perm').prop('checked', false);

            // Cek checkbox yang sesuai dengan permissions dari role
            if(permissions && permissions.length > 0) {
                permissions.forEach(function(p){
                    $(`.edit-role-perm[value="${p}"]`).prop('checked', true);
                });
            }
        });

        // Mengisi data pada modal Hapus Role
        $('.delete-role').on('click', function(){
            const roleId = $(this).data('id');
            $('#deleteRoleForm').attr('action', `/roles/${roleId}`);
        });
    });
</script>
@endpush
@endsection