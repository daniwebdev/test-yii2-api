<?php
/** @var yii\web\View $this */
?>

<div class="container">
    <button class="btn btn-primary mb-3" id="btn-add-config">Add</button>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Key</th>
                <th>Value</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

        </tbody>
    </table>
</div>


<script>

    function load_data() {
        
        $.ajax({
            type : 'GET',
            url: '/api/config',
            headers: {
                "Authorization": "Bearer "+localStorage.getItem('token')
            },
            success: function(res) {
                console.log(res)

                $('table tbody').html('')

                res.details.forEach((item, i) => {
                    $('table tbody').append(`
                        <tr>
                            <td><input class="form-control" name="key" value="${item.key}"></td>
                            <td><input class="form-control" name="value" value="${item.value}"></td>
                            <td>
                                <button class="btn btn-primary save-config">S</button>
                                <button class="btn btn-danger delete" data-id="${item.id}">D</button>
                            </td>
                        </tr>
                    `);
                })
            }
        });
    }
    window.onload = function() {
        load_data();


        $('#btn-add-config').on('click', function() {
            $('table tbody').append(`
                <tr>
                    <td><input class="form-control" name="key" value=""></td>
                    <td><input class="form-control" name="value" value=""></td>
                    <td>
                        <button class="btn btn-primary save-config">S</button>
                        <button class="btn btn-danger delete">D</button>
                    </td>
                </tr>
            `);
        });


        $(document).on('click', '.delete', function() {
            let c = confirm("Anda yakin hapus config ini ?");
            let id = $(this).data('id');

            if(c) {
                if(id == undefined) {
                    $(this).closest('tr').remove();
                } else {
                    let el = this;
                    $.ajax({
                        method: "DELETE",
                        url: '/api/config/'+id,
                        headers: {
                            "Authorization": "Bearer "+localStorage.getItem('token')
                        },
                        success: function(res) {
                            console.log(res);
                            alert("Berhasil")
                            $(el).closest('tr').remove();
                        }
                    })
                }
            }
        });

        $(document).on('click', '.save-config', function() {
            let key = $(this).closest('tr').find('[name="key"]').val();
            let value = $(this).closest('tr').find('[name="value"]').val()  ;
            console.log(key, value);

            data = {};

            data[key] = value;


            let c = confirm('Anda yakin ?');

            if(c) {
                $.ajax({
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    method: "POST",
                    url: '/api/config',
                    headers: {
                        "Authorization": "Bearer "+localStorage.getItem('token')
                    },
                    success: function(res) {
                        console.log(res);
                        alert("Berhasil")
                    }
                })
            }
        })
    }
</script>