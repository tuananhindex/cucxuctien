@extends('frontend.master')
@section('content')


{!! Block::slider() !!}

<section id="content-center" class="row">

    <div id="content-left">
        <div class="col-md-6 col-xs-12">
            {!! Block::posts_hot('vi') !!}
            <div class="clearfix"></div>
            {!! Block::box_search('vi') !!}
            <div class="clearfix"></div>
            {!! Block::event('vi') !!}
        </div>
        <!-- <div class="clearfix"></div> -->
    </div>

    <div id="content-right">
        <div class="col-md-6 col-xs-12">
            {!! Block::posts_hot('la') !!}
            <div class="clearfix"></div>
            {!! Block::box_search('la') !!}
            <div class="clearfix"></div>
            {!! Block::event('la') !!}
        </div>
        <div class="clearfix"></div>
    </div>
</section>

{!! Block::media() !!}

<section>
</section>


@endsection

 




 



 
 
 
 






 





 




 



 
 
 
 






 





 




 



 
 
 
 







 




 



 
 
 
 







 




 



 
 
 
 







 




 



 
 
 
 







 




 



 
 
 
 




