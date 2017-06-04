@extends('frontend.master')
@section('content')

      <div class="container">

        

        <aside class="col-left">
          <div class="sidebar">
            @include('frontend.block.sidebar_taikhoan')
            <div class="box adv">
              {!! Block::static_block(20) !!}  
            </div>
            
            
          </div>
        </aside>
        <section class="col-main">
          <div class="box">
            <h2 class="box-title">Thông tin tài khoản</h2>
            <div class="dashboard">
              <div class="welcome-msg">
                <p class="hello"><strong>Xin chào, {{ $__cus->name }}!</strong></p>
                <p>Với trang này, bạn sẽ quản lý được tất cả thông tin tài khoản của mình.</p>
              </div>
              
              <style type="text/css">
                .box-info a{
                  color:green;
                }
              </style>
              <div class="box-account box-info">
                
                <div class="col2-set">
                  <div class="col-1">
                    <div class="box">
                      <div class="box-title">
                        <h3>Liên hệ</h3>
                        <a href="#" data-toggle="modal" data-target="#suathongtintaikhoan">Sửa</a>
                      </div>
                      <div class="box-content">
                        <p>
                          {{ $__cus->name }}<br> {{ $__cus->email }}<br> <a
                            href="#" data-toggle="modal" data-target="#doimatkhau">Đổi
                            mật khẩu</a>
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="col-2">
                    <div class="box">
                    @if(isset($check_dangkynhanthongtin))
                      <div class="box-title">
                        <h3>Đăng kí nhận bản tin</h3>
                        <a href="{{ route('dangkynhanthongtin_delete') }}">Ngừng nhận</a>
                      </div>
                      <div class="box-content">
                        <p>Bạn đã đăng ký nhận thông báo bản tin.</p>
                      </div>
                    @else
                      <div class="box-title">
                        <h3>Đăng kí nhận bản tin</h3>
                        <a href="{{ route('dangkynhanthongtin_get') }}">Đăng ký</a>
                      </div>
                      <div class="box-content">
                        <p>Bạn chưa đăng ký dịch vụ thông báo bản tin của chúng tôi.</p>
                      </div>
                    @endif
                    </div>
                  </div>
                </div>
                <div class="col2-set">
                  <div class="box">
                    <div class="box-title">
                      <h3>Sổ địa chỉ</h3>
                      <a href="#"><!-- Quản lý địa chỉ --></a>
                    </div>
                    <div class="box-content">
                      <div class="col-1">
                        <h4>Địa chỉ thanh toán mặc định</h4>
                        <address>
                          {{ $__cus->address }} <br> <a href="#" data-toggle="modal" data-target="#suadiachi">Sửa địa chỉ</a>
                        </address>
                      </div>
                      <div class="col-2">
                        <h4>Địa chỉ nhận hàng mặc định</h4>
                        <address>
                        @if(isset($diachimacdinh))
                          {{ $diachimacdinh->address }} <br> 
                        @else
                        Chưa có thông tin <br>
                        @endif
                          @if(isset($diachidanhsach) && count($diachidanhsach) > 0)
                          <a  href="#" data-toggle="modal" data-target="#suadiachinhanhang">Sửa địa chỉ</a><br>
                          @endif
                          <a  href="#" data-toggle="modal" data-target="#themdiachinhanhang">Thêm địa chỉ</a>
                        </address>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </section>
        <aside class="col-right">
          <div class="sidebar">
            
            <div class="box adv">
              {!! Block::static_block(21) !!}  
            </div>
            
          </div>
        </aside>
      </div>
      
      <div id="suadiachi" class="modal fade" role="dialog"> 
        <div class="modal-dialog" style="width:400px">
        <form method="post" action="{{ route('suadiachi') }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" >
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Sửa địa chỉ</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label>Địa chỉ</label>
                  <input name="address" class="form-control" value="{{ $__cus->address }}" placeholder="Nhập địa chỉ mới">
                </div>
              
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary btn-dangky">Cập nhật</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
          </div>
          </form>
        </div>
      </div>

      <div id="themdiachinhanhang" class="modal fade" role="dialog"> 
        <div class="modal-dialog" style="width:400px">
        <form method="post" action="{{ route('themdiachinhanhang') }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" >
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Thêm địa chỉ</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label>Địa chỉ</label>
                  <input name="address" class="form-control" placeholder="Nhập địa chỉ">
                </div>
              
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary btn-dangky">Cập nhật</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
          </div>
          </form>
        </div>
      </div>

      <div id="suathongtintaikhoan" class="modal fade" role="dialog"> 
        <div class="modal-dialog" style="width:400px">
        <form method="post" action="{{ route('suathongtintaikhoan') }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" >
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Cập nhật thông tin tài khoản</h4>
            </div>
            <div class="modal-body">
                @if(Session::has('rs_suathongtintaikhoan'))
                @if(!Session::get('rs_suathongtintaikhoan')['result'])
                  <p style="color:#f00">{{ Session::get('rs_suathongtintaikhoan')['msg'] }}</p>
                @endif
                @endif
                <div class="form-group">
                  <label>Tên</label>
                  <input name="name" class="form-control" value="{{ $__cus->name }}" placeholder="Nhập tên">
                </div>
                
                <div class="form-group">
                  <label>Số điện thoại</label>
                  <input name="phone" class="form-control" value="{{ $__cus->phone }}" placeholder="Nhập số điện thoại">
                </div>
                <div class="form-group">
                  <label>Địa chỉ</label>
                  <input name="address" class="form-control" value="{{ $__cus->address }}" placeholder="Nhập địa chỉ">
                </div>
              
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary btn-dangky">Cập nhật</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
          </div>
          </form>
        </div>
      </div>

      <div id="doimatkhau" class="modal fade" role="dialog"> 
        <div class="modal-dialog" style="width:400px">
        <form method="post" action="{{ route('doimatkhau') }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" >
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Đổi mật khẩu</h4>
            </div>
            <div class="modal-body">
                @if(Session::has('rs_doimatkhau'))
                @if(!Session::get('rs_doimatkhau')['result'])
                  <p style="color:#f00">{{ Session::get('rs_doimatkhau')['msg'] }}</p>
                @endif
                @endif
                
                <div class="form-group">
                  <label>Mật khẩu</label>
                  <input name="password" type="password" class="form-control" placeholder="Nhập mật khẩu mới">
                </div>
                <div class="form-group">
                  <label>Xác nhận mật khẩu</label>
                  <input name="password_confirmation" type="password" class="form-control" placeholder="Xác nhận mật khẩu mới">
                </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary btn-dangky">Cập nhật</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
          </div>
          </form>
        </div>
      </div>

      <div id="suadiachinhanhang" class="modal fade" role="dialog"> 
        <div class="modal-dialog" style="width:400px">
        <form method="post" action="{{ route('suadiachinhanhang') }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" >
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Sửa địa chỉ nhận hàng mặc định</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label>Địa chỉ nhận hàng mặc định</label>
                  <select name="diachinhanhang_df">
                    @foreach($diachidanhsach as $val)
                    <option value="{{ $val->id }}" @if(isset($diachimacdinh) && $val->id == $diachimacdinh->id) selected @endif>{{ $val->address }}</option>
                    @endforeach
                  </select>
                  
                </div>
              
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary btn-dangky">Cập nhật</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
          </div>
          </form>
        </div>
      </div>
      @if(Session::has('rs_quanly'))
      @if(Session::get('rs_quanly')['result'])
        <script type="text/javascript">alert("{!! Session::get('rs_quanly')['msg'] !!}")</script>
      @endif
      @endif

      @if(Session::has('rs_dangkynhanthongtin'))
      <script type="text/javascript">alert("{!! Session::get('rs_dangkynhanthongtin')['msg'] !!}")</script>
      @endif

      @if(Session::has('rs_doimatkhau'))
      @if(!Session::get('rs_doimatkhau')['result'])
      <script type="text/javascript">
        $('#doimatkhau').modal({
            show: 'true'
        }); 
      </script>
      @else
      <script type="text/javascript">alert('Đổi mật khẩu thành công')</script>
      @endif
      @endif

      @if(Session::has('rs_suathongtintaikhoan'))
      @if(!Session::get('rs_suathongtintaikhoan')['result'])
      <script type="text/javascript">
        $('#suathongtintaikhoan').modal({
            show: 'true'
        }); 
      </script>
      @else
      <script type="text/javascript">alert('Sửa thông tin tài khoản thành công')</script>
      @endif
      @endif
@endsection

 




 



 
 
 
 






 





 




 



 
 
 
 






 





 




 



 
 
 
 







 




 



 
 
 
 







 




 



 
 
 
 







 




 



 
 
 
 







 




 



 
 
 
 




