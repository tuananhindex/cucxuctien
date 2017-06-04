@extends('frontend.master')
@section('content')
<section class="breadc">
<style type="text/css">
    .foo-info span{
        color:inherit !important;
    }
</style>
<div class="container breadpos">

    <div class="pull-left">
        <ol class="breadcrumb breadcrumbs">
            <li><a href="{{ route('home') }}" title="Trở lại trang chủ"><i class="fa fa-home"></i> Trang chủ</a></li>
            
            <li>Liên hệ</li>    
            
        </ol>
    </div>
</div>
    
</section>
<section class="contact-form p40">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-12 col-xs-12">
                
                
                
                <div class="form-group clearfix">
                    <label for="concept" class="col-sm-3 control-label">Họ tên</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="name" placeholder="Họ tên*" required>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="concept" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="email" placeholder="Email*" required>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="concept" class="col-sm-3 control-label">Số điện thoại</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="phone" placeholder="Số điện thoại*" required>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="concept" class="col-sm-3 control-label">Tiêu đề</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="subject" placeholder="Tiêu đề*" required>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="concept" class="col-sm-3 control-label">Nội dung</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="content" placeholder="Lời nhắn" rows="5" required></textarea>
                    </div>
                </div>  
                <div class="form-group clearfix">
                    <label for="concept" class="col-sm-3 control-label">Xác nhận</label>
                    <div class="col-sm-3">
                        <input type="text" name="confirm"  id="confirm" class="form-control form-control-lg NormalTextBox" required>
                    </div>
                    <div class="col-sm-3">
                        <img id="capcha3" alt=""  style="height:50px;width:180px;">
                    </div>
                    <div class="col-sm-3">
                        <img id="resetCapcha3" style="width: 25px !important" src="{{ asset('assets/frontend/images/refesh7.png') }}">
                    </div>
                </div>
                
                <div class="form-group clearfix">
                    <label for="concept" class="col-sm-3 control-label"><img class="pull-right" style="width: 25px !important;display:none " src="{{ asset('assets/frontend/images/ajax-load.gif') }}" id="loadding"></label>
                    <div class="col-sm-9">
                        <button type="submit" class="custom-button button-style1" name="sendmail"><i class="icon-eye"></i>Gửi nhận xét</button>

                    </div>
                </div>
                
             
            </div>
            <div class="col-md-3 hidden-xs hidden-sm">
                <div class="foo-info">
                    <p style="padding-left: 0;">{!! Block::static_block(2) !!}</p>
                    <p class="foo-address">{!! Block::static_block(13) !!}</p>
                    <p><span class="foo-phone">{!! Block::static_block(1) !!}</span>
                    </p>
                    <a class="foo-mail">{!! Block::static_block(12) !!}</a>
                    <div class="fooFlowus">
                        <ul class="list-unstyled">
                            <li><a class="show_facebook" href="javascript:void(0)" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a class="show_twitter" href="javascript:void(0)" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a class="show_google" href="javascript:void(0)" target="_blank" title="Google+"><i class="fa fa-google-plus"></i></a>
                            </li>                                
                            <li><a class="show_google" href="javascript:void(0)" target="_blank" title="Pinterest"><i class="fa fa-pinterest-p"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="map" id="contact">
    <div class="map-container">
        {!! Block::static_block(23) !!}
    </div><!-- /map-container -->
</section>
<script>

    change_captcha3();
    $("#resetCapcha3").click(function(){

        change_captcha3();

    });
    function change_captcha3(){

        $.ajax({

            type: "GET",

            url: "{{ route('capcha3') }}",

            success:function(captcha)

            {
                $("#capcha3").attr("src",captcha);

            }

        });

    }

    var ajax_sendding = false;

    $("button[name='sendmail']").click(function(e){
        if (ajax_sendding == true){

            return false;

        }

        ajax_sendding = true;

        $('#loadding').show();

        $.ajax({

            type: "POST",

            url: "{{ route('danhgia') }}",

            data: { 

                    _token : $('input[name="_token"]').val(),

                    name : $('input[name="name"]').val() ,

                    phone : $('input[name="phone"]').val() , 

                    subject : $('input[name="subject"]').val() , 

                    content : $('textarea[name="content"]').val() , 

                    email : $('input[name="email"]').val() , 

                    confirm : $('input[name="confirm"]').val()
                },
            success:function(x)
            {
                var arr = x.split('-');

                if(arr[1] == 'success'){

                    $('.NormalTextBox').val('');

                }
                change_captcha3();
                alert(arr[0]);
            },
            error:function()
            {
                alert('Gửi mail không thành công');
            }
        }).always(function(){
            ajax_sendding = false;
            $('#loadding').hide();
        });
    });

// alert(123);

        
  </script>
@endsection

 




 



 
 
 
 






 





 




 



 
 
 
 






 





 




 



 
 
 
 







 




 



 
 
 
 







 




 



 
 
 
 







 




 



 
 
 
 







 




 



 
 
 
 




