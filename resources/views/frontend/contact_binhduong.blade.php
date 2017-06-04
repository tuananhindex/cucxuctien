@extends('frontend.master')
@section('content')
<div class="site-main container">
<div class="row">
      <?php
          $bc = [];
          $bc[] = 'Liên hệ';
          
      ?>
      {!! Block::breadcrumbs($bc) !!}
      <div class="main-content col-xs-12 col-sm-12 col-md-9 col-md-push-3">
      		<section class="info-item">
      			
                    <div id="contact-map" class="col-xs-12">
                        {!! Block::static_block(25) !!}
                    </div>
                    <div class="col-xs-12">
                        <h3 class="box-title">Liên hệ</h3>
                        <form> 
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group"> 
                                <label for="exampleInputEmail1">Địa chỉ Email</label> 
                                <input type="email" name="email" class="form-control NormalTextBox" id="exampleInputEmail1" placeholder="Email"> 
                            </div> 
                            <div class="form-group"> 
                                <label for="exampleInputEmail1">Số điện thoại</label> 
                                <input type="text" name="phone" class="form-control NormalTextBox" id="exampleInputEmail1" placeholder="Số điện thoại"> 
                            </div> 
                            <div class="form-group"> 
                                <label for="exampleInputEmail1">Tiêu đề</label> 
                                <input type="text" name="title" class="form-control NormalTextBox" id="exampleInputEmail1" placeholder="Tiêu đề"> 
                            </div> 
                            <div class="form-group"> 
                                <label for="exampleInputEmail1">Nội dung</label> 
                                <textarea class="form-control NormalTextBox" name="content" rows="2"></textarea>
                            </div> 
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <input class="input-contact NormalTextBox" placeholder="Nhập mã xác nhận" name="xacnhan" id="xacnhan" type="text">
                            </div>
                            <img id="capcha" alt=""  style="height:50px;width:180px;">
                            <img id="resetCapcha" style="width: 25px !important" src="{{ asset('assets/frontend/images/refesh7.png') }}">
                            <input type="button" name="sendmail" value="Gửi yêu cầu" class="btn btn-default pull-right">
                            <img style="width: 25px !important;display:none " src="{{ asset('assets/frontend/images/ajax-load.gif') }}" id="loadding">
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    <br/>
                
      		</section>
			
			
			
      </div>

      <div class="main-sidebar col-xs-12 col-sm-4 col-md-3 col-md-pull-9 ">
          {!! Block::support_online() !!}

          
          {!! Block::access() !!}

      </div>

  </div>

  
</div>
<script>

    
        change_captcha();
        $("#resetCapcha").click(function(){

            change_captcha();

        });
        function change_captcha(){

            $.ajax({

                type: "GET",

                url: "{{ route('capcha') }}",

                success:function(captcha)

                {
                    $("#capcha").attr("src",captcha);
                }

            });

        }
        var ajax_sendding = false;

        $("input[name='sendmail']").click(function(e){
            if (ajax_sendding == true){

                return false;

            }

            ajax_sendding = true;

            $('#loadding').show();

            $.ajax({

                type: "GET",

                url: "{{ route('danhgia') }}",

                data: { 

                        _token : $('input[name="_token"]').val(),

                        phone : $('input[name="phone"]').val() , 

                        title : $('input[name="title"]').val() , 

                        content : $('textarea[name="content"]').val() , 

                        email : $('input[name="email"]').val() , 

                        xacnhan : $('input[name="xacnhan"]').val()
                    },
                success:function(x)
                {
                    var arr = x.split('-');

                    if(arr[1] == 'success'){

                        $('.NormalTextBox').val('');

                    }
                    change_captcha();
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
</script>
@endsection

 




 



 
 
 
 






 





 




 



 
 
 
 






 





 




 



 
 
 
 







 




 



 
 
 
 







 




 



 
 
 
 







 




 



 
 
 
 







 




 



 
 
 
 




