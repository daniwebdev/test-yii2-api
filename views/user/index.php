<?php
/** @var yii\web\View $this */
?>


<div class="container">
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


<script>
    window.onload = () => {

        $.get('/api/user', res=> {
            console.log(res.details);
        });

        $.ajax({
            type : 'GET',
            url: '/api/user',
            headers: {
                "Authorization": "Bearer "+localStorage.getItem('token')
            },
            success: function(res) {
                console.log(res);

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
        })

    }
</script>