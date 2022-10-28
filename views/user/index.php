<?php
/** @var yii\web\View $this */
?>


<div class="container">
    <button class="btn btn-primary my-4" data-bs-toggle="modal" data-bs-target="#modalId" type="button">Buat</button>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="50">No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th class="text-center" width="200">Action</th>
            </tr>
        </thead>
        <tbody>
           
        </tbody>
    </table>
</div>


<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Buat User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-2">
                        <label for="">Nama</label>
                        <input class="form-control mb-1" type="text" id="first_name" placeholder="First Name">
                        <input class="form-control" type="text" id="last_name" placeholder="Last Name">
                    </div>
                    <div class="mb-2">
                        <label for="">Email</label>
                        <input class="form-control" type="text" id="email">
                    </div>
                    <div class="mb-2">
                        <label for="">Password</label>
                        <input class="form-control" type="text" id="password">
                    </div>
                    <div>
                        <label for="">Status</label>
                        <select name="is_active" id="is_active" class="form-control">
                            <option value="">Pilih</option>
                            <option value="1">Enable</option>
                            <option value="0">Disable</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-save-user">Save</button>
            </div>
        </div>
    </div>
</div>


<script>
    
    function load_data() {
        
        
        $.ajax({
            type : 'GET',
            url: '/api/user',
            headers: {
                "Authorization": "Bearer "+localStorage.getItem('token')
            },
            success: function(res) {
                console.log(res);
                $('table tbody').html('')

                res.details.forEach((i, n) => {

                    let status = '<span class="badge bg-success">Active</span>';

                    if(i.is_active != 1) {
                        status = '<span class="badge bg-secondary">Disabled</span>';
                    }

                    $('table tbody').append(`
                        <tr>
                            <td>${n+1}</td>
                            <td>${i.first_name +' '+ i.last_name}</td>
                            <td>${i.email}</td>
                            <td>
                                ${status}
                            </td>
                            <td class="text-center">
                                <button class="btn btn-primary">Update</button>
                                <button class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                    `);
                })
            }
        });
    }

    var modalAddUser;

    window.onload = function() {
        modalAddUser = new bootstrap.Modal(document.getElementById('modalId'))

        load_data();


        $('#btn-save-user').on('click', function() {
            $.ajax({
                type : 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    first_name: $('#first_name').val(),
                    last_name: $('#last_name').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                    is_active: $('#is_active').val(),
                }),
                url: '/api/user',
                headers: {
                    "Authorization": "Bearer "+localStorage.getItem('token')
                },
                success: function(res) {
                    modalAddUser.hide();
                    alert("Berhasil");
                    load_data();
                }
            })
        })

    }
</script>