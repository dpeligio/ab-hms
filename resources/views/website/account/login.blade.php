<form id="login-form"{{-- action="{{ route('login') }}" method="POST" --}}>
    @csrf
    <div class="modal" id="login" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog {{-- modal-dialog-centered  --}}modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Login</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label style="color: red" id="error-msg"></label>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control" name="email" autocomplete="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group">
                        <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#register" data-href="{{ route('client.register') }}">
                            Doesn't have an account? Register Here
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal-ajax">Cancel</button>
                    <button class="btn btn-default text-success" type="submit"><i class="fas fa-save"></i> Login</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(function(){
        $('#login-form').on('submit', function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#error-msg").html("");
            $.ajax({
                type:'POST',
                url:'/login',
                data: {
                    email: $('#email').val(),
                    password: $('#password').val()
                },
                success:function(response) {
                    if(response.error_msg){
                        console.log(response.error_msg)
                        $("#error-msg").html(response.error_msg);
                    }
                    if(response.redirect){
                        console.log(response.redirect)
                        window.location.href = response.redirect;
                    }
                }
            });
        });
    })
</script>