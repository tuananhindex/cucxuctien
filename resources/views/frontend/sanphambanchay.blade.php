@extends('frontend.master')
@section('content')

      <div class="container">

        

        <aside class="col-left">
          <div class="sidebar">
            {!! Block::box_category() !!}  
            @include('frontend.block.box_filter')
            <div class="box adv">
              {!! Block::static_block(20) !!}  
            </div>
            
            
          </div>
        </aside>
        <section class="col-main">
          <div class="box">
            <h2 class="box-title"><span>Sản phẩm bán chạy</span></h2>
            {!! Block::product_grid($products,true) !!}  
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
    

@endsection

 




 



 
 
 
 






 





 




 



 
 
 
 






 





 




 



 
 
 
 







 




 



 
 
 
 







 




 



 
 
 
 







 




 



 
 
 
 







 




 



 
 
 
 




