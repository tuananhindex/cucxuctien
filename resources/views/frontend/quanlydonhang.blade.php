@extends('frontend.master')

@section('content')

      <div class="container">

        

        <aside class="col-left">
          <div class="sidebar">
            <div class="box categories">
              @include('frontend.block.sidebar_taikhoan')
            </div>
            <div class="box adv">
              {!! Block::static_block(20) !!}  
            </div>
            
            
          </div>
        </aside>
        <section class="col-main">
          <div class="box">
            <h2 class="box-title">Thông tin đơn hàng</h2>
            <div class="dashboard">
              <div class="welcome-msg">
                <p class="hello"><strong>Xin chào, {{ $__cus->name }}!</strong></p>
                <p>Với trang này, bạn sẽ quản lý được tất cả thông tin đơn hàng của mình.</p>
              </div>
              @if(isset($donhang) && count($donhang) > 0)
              <div class="box-account box-recent">
                
                <table id="my-orders-table" class="data-table">
                  <colgroup>
                    <col width="1">
                    <col width="1">
                    <col>
                    <col width="1">
                    <col width="1">
                    <col width="1">
                  </colgroup>
                  <thead>
                    <tr class="first last">
                      <th>Đơn hàng #</th>
                      <th>Ngày</th>
                      <th>Chuyển tới</th>
                      <th><span class="nobr">Tổng cộng</span></th>
                      <th>Trạng thái</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($donhang as $val)
                    <tr class="first odd">
                      <td>{{ $val->madonhang }}</td>
                      <td><span class="nobr">{{ date('d/m/Y',strtotime($val->created_at)) }}</span></td>
                      <td>{{ $val->ten }}</td>
                      <td><span class="price">{{ number_format($val->tongtien) }} VNĐ</span></td>
                      <td><em>@if($val->trangthai == 0) Chờ xử lý @else Thành công @endif</em></td>
                      <td class="a-center last"><span class="nobr"><a href="?madonhang={{ $val->madonhang }}@if(isset($_GET['page']))&page={{ $_GET['page'] }} @endif">Xem đơn hàng</a></span></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="pagination clearfix pull-right">
                  {!! $donhang->render() !!}
                </div>
              </div>
              @else
              <p>Bạn chưa có đơn hàng nào</p>
              @endif
              <style type="text/css">
                .box-info a{
                  color:green;
                }
              </style>
              
              
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
      @if(isset($thongtindonhang) && $thongtindonhang)
      <div id="thongtindonhang" class="modal fade" role="dialog"> 
        <div class="modal-dialog" style="width:700px">
        
          <input type="hidden" name="_token" value="{{ csrf_token() }}" >
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Đơn hàng : {{ $thongtindonhang->madonhang }}</h4>
            </div>
            <div class="modal-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th width="20">STT</th>
                      <th width="100">Ảnh</th>
                      <th width="100">Tên</th>
                      <th width="100">Giá</th>
                      <th width="100">Số lượng</th>
                      <th width="100">Thành tiền</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $stt = 1;
                    ?>
                    @foreach($chitietdonhang as $val)
                    <?php
                      $obj = DB::table('product')->where('id',$val->product_id)->select('fk_catid','alias')->first();
                      $cat = DB::table('product_category')->where(['id' => $obj->fk_catid, 'status' => 1])->select('alias')->first();

                    ?>
                    <tr>
                      <td>{{ $stt }}</td>
                      <td><img src="{{ asset($val->anh) }}" width="100"></td>
                      <td><a href='@if(isset($cat)){{ route("product",[$cat->alias,$obj->alias]) }} @else javascript:void(0) @endif' target="_blank">{{ ucwords($val->ten) }}</a></td>
                      <td>{{ number_format($val->gia) }} VNĐ</td>
                      <td>{{ $val->soluong }}</td>
                      <td>{{ number_format($val->gia * $val->soluong) }} VNĐ</td>
                    </tr>
                    <?php $stt++; ?>
                    @endforeach
                    <tr>
                      <td colspan="6"><h4 style="float:right">Tổng tiền : {{ number_format($thongtindonhang->tongtien) }} VNĐ</p></h4>
                    </tr>
                  </tbody>
                </table>
              
            </div>
            
          </div>
          
        </div>
      </div>
      <script type="text/javascript">
        $('#thongtindonhang').modal({
            show: 'true'
        }); 
      </script>
      @endif
      
@endsection

 




 



 
 
 
 






 





 




 



 
 
 
 






 





 




 



 
 
 
 







 




 



 
 
 
 







 




 



 
 
 
 







 




 



 
 
 
 







 




 



 
 
 
 




