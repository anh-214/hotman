@extends('frontend.layouts.app')
@section('title')
    Thông tin tài khoản
@endsection
@push('css')
    <style>
        #avatar img{
            width: 250px;
           
        }
        #avatar {
            position: relative;
            width: 250px;
        }
        #uploadAvatar label {
            width: 250px;
            padding: 2% 0 2% 0;
            margin: 0;
        }
        #avatar #uploadAvatar{
            position: absolute;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.486);
            width: 250px;
            
            text-align: center;
            align-items: center;
            visibility: hidden;
        }
        #avatar:hover #uploadAvatar{
            visibility: visible;
        }
        .updateInformation{
            display: none;
        }
        .cropAndCut{
            display: none
        }
        #image {
        display: block;
        max-width: 100% !important;
        }
        .preview {
        overflow: hidden;
        width: 160px !important; 
        height: 160px !important;
        margin: 10px !important;
        border: 1px solid red !important;
        }
        .modal-lg{
        max-width: 700px !important;
        
        }
        #crop{
            margin-top: 20px;
        }
        .go-to-updateInformation{
            cursor: pointer;   
        }
    </style>
@endpush

@push('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>    
@endpush

@section('content')
    <div class="js">
    <!-- Start changePassword -->
	<section id="contact-us" class="contact-us section">
		<div class="container">
				<div class="contact-head">
					<div class="row">
                        <div class="col-lg-8 col-12 information">
                            <div class="form-main">
                                <div class="title d-flex justify-content-between">
                                    <h4>Thông tin tài khoản</h4>
                                    <a type="button" class="go-to-updateInformation">Cập nhật thông tin</a>
                                </div>
                                <div id="avatar">
                                    <img src="{{$image}}" alt="">
                                    <div id="uploadAvatar">
                                        <label for="file">
                                        <i class="fas fa-camera" style="color: white;font-size:20pt"></i>
                                        <input type="file" id="file" style="display: none" name="image" accept="image/gif,image/jpeg,image/jpg,image/png" multiple="" data-original-title="upload photos">
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <p>Họ và tên: {{$user->name}}</p>
                                    <p>Email: {{$user->email}}</p>
                                    <p>Số điện thoại: @if($user->phonenumber == null) 
                                        <span class="go-to-updateInformation" style="color: red">Vui lòng cập nhật số điện thoại</span>
                                        @else
                                        {{$user->phonenumber}}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
						<div class="col-lg-8 col-12 updateInformation">
							<div class="form-main">
								<div class="title d-flex justify-content-between">
									<h4>Cập nhật thông tin</h4>
                                    <i class="fas fa-arrow-left update-back-to-information"></i>
								</div>
								<form id="updateInformationForm" class="form" method="POST" action="{{url('/user/information')}}">
                                    @csrf
									<div class="row">
										<div class="col-lg-12 col-12">
											<div class="form-group">
												<label>Họ và tên:<span>*</span></label>
												<input class="form-control" name="name" type="text" placeholder="" value="{{$user->name}}">
                                                <div class="invalid-feedback" id="errorName">
                                                </div>
											</div>
										</div>
										
										<div class="col-lg-12 col-12">
											<div class="form-group">
												<label>Số điện thoại<span>*</span></label>
												<input class="form-control" name="phonenumber"  placeholder="" value="{{$user->phonenumber}}">
                                                <div class="invalid-feedback" id="errorPhoneNumber">
                                                </div>
											</div>	
										</div>
										<div class="col-12">
											<div class="form-group button">
												<button type="button" class="btn" id="btnUpdateInformation">Cập nhật thông tin</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="col-lg-8 col-12 cropAndCut">
							<div class="form-main">
								<div class="title d-flex justify-content-between">
									<h4>Cắt ảnh</h4>
                                    <i class="fas fa-arrow-left back-to-information"></i>
								</div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <img id="image">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="preview"></div>
                                    </div>
                                </div>
                                <div>
                                    <button type="button" id="crop" class="btn btn-primary">Upload Avatar</button>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</section>
	<!--/ End change Password -->
    </div>


@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>

<script>
    $(document).ready(function(){
        $('.update-back-to-information').click(function(){
            $('.information').show();
            $('.updateInformation').hide();
        })
        $('.go-to-updateInformation').click(function(){
            $('.information').hide();
            $('.updateInformation').show();
        })
        $("#btnUpdateInformation").click(function(){

            $name = $('input[name=name]');
            $phonenumber = $('input[name=phonenumber]');
            let $regexPhone = /^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/
            let $checkName = false;
            let $checkPhone = false;

            if ($name.val() == ''){
                $name.addClass('is-invalid')
                $("#errorName").text("Trường này không được để trống") 
                $checkName = false
            } else if($name.val().length < 5 ){
                $name.addClass('is-invalid')
                $("#errorName").text("Trường này phải trên 5 kí tự")
                $checkName = false
            } else {
                $name.removeClass('is-invalid')
                $("#errorName").text("")
                $checkName = true
            }
            if ($phonenumber.val() == ''){
                $phonenumber.addClass('is-invalid')
                $("#errorPhoneNumber").text("Trường này không được để trống")
                $checkPhone = false
            } else if ($regexPhone.test($phonenumber.val()) == false){
                $phonenumber.addClass('is-invalid')
                $("#errorPhoneNumber").text("Nhập đúng định dạng số điện thoại")
                $checkPhone = false
            } else {
                $phonenumber.removeClass('is-invalid')
                $("#errorPhoneNumber").text("")
                $checkPhone = true
            }
            if ($checkName == true && $checkPhone == true){
                $('#updateInformationForm').submit();
            }
        })
    })
</script>
<script>
    $(document).ready(function(){
            var image = document.getElementById('image');
            var cropper;
            $("#uploadAvatar").on("change", "#file", function(e){
                image.src = '';
                var files = e.target.files;
                var done = function (url) {
                    image.src = url;
                    $('.information').hide();
                    $('.cropAndCut').show()
                };
                var reader;
                var file;
                var url;
                if (files && files.length > 0) {
                    file = files[0];
                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function (e) {
                        done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
                cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
                });
            });

            $('.back-to-information').click(function(){
                cropper.destroy();
                cropper == null;
                image.src = '';
                $('.information').show();
                $('.updateInformation').hide();
                $('.cropAndCut').hide();
            })
            $('#crop').click(function(){
                canvas = cropper.getCroppedCanvas({
                        width: 160,
                        height: 160,
                });
                canvas.toBlob(function(blob) {
                    url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(blob); 
                    reader.onloadend = function() {
                        var base64data = reader.result; 
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "/user/information",
                            data: {"_token": "{{ csrf_token() }}", 'upload': base64data},
                            success: function(data){
                                if (data.result == 'success'){
                                    window.location.reload();
                                }
                            }
                        });
                    }
                });
            })
    })
</script>
@endpush