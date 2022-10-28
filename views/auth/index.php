<?php
/** @var yii\web\View $this */
?>
<div class="row d-flex h-100 align-items-center" style="min-height: calc(100vh - 150px);">
    <div class="col-6 m-auto">

        <div class="card">
            <form action="" class="card-body">
                <div>
                    <label for="">Email</label>
                    <input type="email" required name="email" class="form-control" id="email">
                </div>
                <div class="mt-4">
                    <label for="">Password</label>
                    <input type="password" required name="password" class="form-control" id="password">
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary" id="btn-login" type="button">Login</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    window.onload = function()  {
        if(localStorage.token) {
            location.href = location.origin+'/user'
        }

        alert('');

        $(document).on('click', '#btn-login', function() {

            let email = $('#email').val();
            let password = $('#password').val();

            console.log(email, password)

            $.ajax({
                data : JSON.stringify({
                    email,
                    password
                }),
                contentType : 'application/json',
                type : 'POST',
                url: '/api/auth/login',
                success: function(res) {
                    console.log(res)

                    localStorage.setItem('token', res.details.token)
                    alert('berhasil')

                    location.href = '/user'
                }
            })

        })
    }
</script>