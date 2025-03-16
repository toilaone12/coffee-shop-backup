<!-- Modal -->
<link rel="stylesheet" href="{{asset('./front-end/css/login.css')}}">
<?php
    use Illuminate\Support\Facades\Cookie;
    $json_remember = Cookie::get('json_remember_customer');
    if(isset($json_remember)){
        $arrRemember = json_decode($json_remember);
        $remember = $arrRemember->remember;
        $email = $arrRemember->email;
        $password = $arrRemember->password;
    }else{
        $email = '';
        $password = '';
        $remember = '';
    }
?>
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog d-flex justify-content-center">
        <div class="modal-content form-login">
            <div class="section">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 text-center align-self-center py-2">
                            <div class="section pb-5 pt-5 pt-sm-2 text-center">
                                <h6 class="mb-0 pb-3 fs-16"><span>Đăng nhập </span><span>Đăng ký</span></h6>
                                <input class="checkbox" type="checkbox" id="reg-log" name="reg-log" />
                                <label for="reg-log"></label>
                                <div class="card-3d-wrap mx-auto">
                                    <div class="card-3d-wrapper">
                                        <div class="card-front">
                                            <div class="center-wrap">
                                                <div class="section text-center">
                                                    <h4 class="mb-4 pb-3 fs-24">Đăng nhập</h4>
                                                    <form class="login-customer">
                                                        <div class="form-group position-relative">
                                                            <input type="email" name="email" class="form-style" placeholder="Email" id="logemail" autocomplete="off" value="{{$email ? $email : old('email')}}">
                                                            <span class="icon-at input-icon"></span>
                                                            <span class="text-danger error-email"></span>
                                                        </div>
                                                        <div class="form-group position-relative mt-2">
                                                            <input type="password" name="password" class="form-style" placeholder="Mật khẩu" id="logpass" autocomplete="off" value="{{$password ? $password : old('password')}}">
                                                            <span class="icon-lock input-icon"></span>
                                                            <span class="text-danger error-password"></span>
                                                        </div>
                                                        <div class="custom-control custom-checkbox mb-3 text-left">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck" name="remember" {{$remember ? 'checked' : ''}}>
                                                            <label class="custom-control-label fs-15" for="customCheck">Lưu mật khẩu</label>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary btn-outline-primary mt-4 px-4 fs-16">Đăng nhập</button>
                                                    </form>
                                                    <p class="mb-0 mt-4 text-center forgot-password cursor-pointer">Quên mật khẩu?</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-back">
                                            <div class="center-wrap">
                                                <div class="section text-center">
                                                    <h4 class="mb-4 pb-3 fs-24">Đăng ký</h4>
                                                    <form class="register-customer">
                                                        <div class="form-group position-relative">
                                                            <input type="text" name="name" class="form-style" placeholder="Họ và tên" id="logname" autocomplete="off">
                                                            <span class="icon-user input-icon"></span>
                                                            <span class="text-danger error-name"></span>
                                                        </div>
                                                        <div class="form-group position-relative mt-2">
                                                            <input type="email" name="email" class="form-style" placeholder="Email" id="logemailregister" autocomplete="off">
                                                            <span class="icon-at input-icon"></span>
                                                            <span class="text-danger error-email"></span>
                                                        </div>
                                                        <div class="form-group position-relative mt-2">
                                                            <input type="password" name="password" class="form-style" placeholder="Mật khẩu" id="logpassregister" autocomplete="off">
                                                            <span class="icon-lock input-icon"></span>
                                                            <span class="text-danger error-password"></span>
                                                        </div>
                                                        <div class="form-group position-relative mt-2">
                                                            <input type="password" name="repassword" class="form-style" placeholder="Nhập lại mật khẩu" id="logrepass" autocomplete="off">
                                                            <span class="icon-lock input-icon"></span>
                                                            <span class="text-danger error-repassword"></span>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary btn-outline-primary mt-4 px-4 fs-16">Xác nhận</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('customer.modal')
<!-- Modal -->