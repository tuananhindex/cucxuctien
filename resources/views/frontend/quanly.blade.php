@extends('frontend.master')
@section('content')
<section class="breadc">
  
<div class="container breadpos">

  <div class="pull-left">
    <ol class="breadcrumb breadcrumbs">
      <li><a href="{{ route('home') }}" title="Trở lại trang chủ"><i class="fa fa-home"></i> Trang chủ</a></li>
              
      <li>Trang khách hàng</li>     
      
    </ol>
  </div>
</div>
  
</section>
<section class="signup page_customer_account">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-main-acount">
                <div id="parent" class="row">
                    <div id="a" class="col-xs-12 col-sm-12 col-lg-9 col-left-account">
                        <div class="page-title m992">
                            <h1 class="title-head margin-top-0"><a href="#">Thông tin tài khoản</a></h1>
                        </div>
                        <div class="form-signup name-account m992">
                            <p><strong>Xin chào, <a href="javascript:void(0)" style="color:#158fcf;">{{ ucfirst($__cus->name) }}</a>&nbsp;!</strong></p>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-lg-12 no-padding">
                            <div class="my-account">
                                <div class="dashboard">
                                    <div class="recent-orders xs-margin-top-20">
                                        <div class="table-responsive tab-all " style="overflow-x:auto;">
                                            @if(isset($donhang) && count($donhang) > 0)
                                            <table class="table table-cart xs-margin-top-0 xs-margin-bottom-0" id="my-orders-table">
                                                <thead class="thead-default">
                                                    <tr>
                                                        <th style="text-align:center">Mã Đơn hàng</th>
                                                        <th style="text-align:center">Ngày</th>
                                                        <th style="text-align:center">Chuyển tới</th>
                                                        <th style="text-align:center">Tổng cộng</th>
                                                        <th style="text-align:center">Trạng thái</th>
                                                        <th style="text-align:center"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  @foreach($donhang as $val)
                                                  <tr class="first odd">
                                                    <td>{{ $val->madonhang }}</td>
                                                    <td><span class="nobr">{{ date('d/m/Y',strtotime($val->created_at)) }}</span></td>
                                                    <td>{{ $val->diachi }}</td>
                                                    <td><span class="price">{{ number_format($val->tongtien) }} VNĐ</span></td>
                                                    <td><em>@if($val->trangthai == 0) Chờ xử lý @else Thành công @endif</em></td>
                                                    <td class="a-center last"><span class="nobr"><a href="?madonhang={{ $val->madonhang }}@if(isset($_GET['page']))&page={{ $_GET['page'] }} @endif">Xem đơn hàng</a></span></td>
                                                  </tr>
                                                  @endforeach
                                                </tbody>
                                            </table>

                                            {!! $donhang->render() !!}
                                            @else
                                            <p>Không có đơn hàng nào</p>
                                            @endif
                                        </div>
                                        <div class="text-xs-right">
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <style type="text/css">
                          .box-info-account a{
                            color: #158fcf;
                          }
                        </style>
                        <div class="col-xs-12 col-sm-12 col-lg-12 no-padding box-info-account">
                          <div class="box-head">
                            <h2>Thông tin tài khoản</h2>
                          </div>
                          <div  class="row">
                            <div class="col-xs-12 col-md-6">
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
                            <div class="col-xs-12 col-md-6">
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
                          <div class="clear"></div>
                          <div class="row">
                            <div class="box">
                              <div class="box-title">
                                <h3>Sổ địa chỉ</h3>
                                <a href="#"><!-- Quản lý địa chỉ --></a>
                              </div>
                              <div class="box-content">
                                <div class="col-xs-12 col-md-6">
                                  <h4>Địa chỉ thanh toán mặc định</h4>
                                  <address>
                                    @if($__cus->address){{ $__cus->address }}@else Chưa có thông tin @endif <br> <a href="#" data-toggle="modal" data-target="#suadiachi">Sửa địa chỉ</a>
                                  </address>
                                </div>
                                <div class="col-xs-12 col-md-6">
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
                    <div id="b" class="col-xs-12 col-sm-12 col-lg-3 col-right-account margin-top-20">
                        <div class="page-title mx991">
                            <h1 class="title-head"><a href="#">Thông tin tài khoản</a></h1>
                        </div>
                        <div class="form-signup body_right mx991">
                            <p><strong>Xin chào, <a href="javascript:void(0)" style="color:#158fcf;">{{ ucfirst($__cus->name) }}</a>&nbsp;!</strong></p>
                        </div>
                        <div class="block-account">
                            <div class="block-title-account">
                                <h5>Tài khoản của tôi</h5>
                            </div>
                            <div class="block-content form-signup">
                                <p>Tên tài khoản: <strong style="line-height: 20px;"> {{ ucfirst($__cus->name) }}!</strong></p>
                                <p><i class="fa fa-home font-some" aria-hidden="true"></i>  <span><strong>Địa chỉ</strong>: @if(isset($__cus->address))
                                    {{ $__cus->address }} <br> 
                                  @else
                                  Chưa có thông tin <br>
                                  @endif</span></p>
                                <p><i class="fa fa-mobile font-some" aria-hidden="true"></i> <span><strong>Điện thoại</strong>: @if(isset($__cus->phone))
                                    {{ $__cus->phone }} <br> 
                                  @else
                                  Chưa có thông tin <br>
                                  @endif</span> </p>
                                <p><i class="fa fa-map-marker font-some" aria-hidden="true"></i> <span> <strong>Địa chỉ nhận hàng mặc định</strong>: @if(isset($diachimacdinh))
                                    {{ $diachimacdinh->address }} <br> 
                                  @else
                                  Chưa có thông tin <br>
                                  @endif</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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


@endsection
