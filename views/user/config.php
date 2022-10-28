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

                res.details.forEach((item, i) => {
                    $('table tbody').append(`
                        <tr>
                            <td><input class="form-control" name="key" value="${item.key}"></td>
                            <td><input class="form-control" name="value" value="${item.value}"></td>
                            <td>
                                <button class="btn btn-primary">S</button>
                                <button class="btn btn-danger" data-id="${item.id}">D</button>
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
                        <button class="btn btn-primary">S</button>
                        <button class="btn btn-danger">D</button>
                    </td>
                </tr>
            `);
        })
    }
</script>