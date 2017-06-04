
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/datepicker3.css') }}">
<style type="text/css">
    .box-search input,.box-search select{
        font-style: italic;
    }
    .datepicker{
        padding: 6px 12px;
    }
</style>
<div id="new-search" style="margin: 0 0 30px 0;">
    <form method="get" action="{{ route('search.get') }}">
    <div class="box-search">
        
        <input type="hidden" class="nation-{{ $nation }}" name="nation" value="{{ $nation }}">
        <div class="form-group">
            <input type="text" name="keywords" placeholder="Keywords ..." class="form-control" value="@if(isset($_GET['keywords'])){{ $_GET['keywords'] }}@endif"  >
        </div>
        <!-- <div class=" form-group">
            <div class="row">
                <div class="col-xs-6">
                    <input type="text" placeholder="Email" class="form-control" id="email">
                </div>
                <div class="col-xs-6">
                    <input type="text" placeholder="Email" class="form-control" id="email">
                </div>
            </div>
        </div> -->
        <div class="form-group">
            <div class="row">
                <div class="col-xs-12">
                    <select class="form-control" name="cat" id="sel1-{{ $nation }}">
                        <option value="0">Categories</option>
                        {!! $MultiLevelSelect !!}
                    </select>
                </div>
                
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-xs-6">
                    <input class="form-control datepicker" value="@if(isset($_GET['start'])){{ $_GET['start'] }}@endif" placeholder="From" name="start" type="text">
                </div>
                <div class="col-xs-6">
                    <input class="form-control datepicker" value="@if(isset($_GET['end'])){{ $_GET['end'] }}@endif" placeholder="To" name="end" type="text">
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-default pull-right" style="background: #ababab ; color: #fff ; padding: 3px 24px;border-radius:0px">Search</button>
        
        
    </div>
    </form>
</div>
<script type="text/javascript" src="{{ asset('assets/frontend/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript">
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
    });

    // var ajax_sendding;
    // $('#sel1-{{ $nation }}').change(function(){

    //     var val = $(this).val();
    //     var nation = $('.nation-{{ $nation }}').val();
    //     if (ajax_sendding == true){

    //         return false;

    //     }

    //     ajax_sendding = true;

        

    //     $.ajax({

    //         type: "GET",

    //         url: "{{ route('getsubcategory') }}",

    //         data: { 

    //                 val : val,
    //                 nation : nation
    //             },
    //         success:function(x)
    //         {
    //             $('#sel2-{{ $nation }}').html(x);
    //         },
    //         error:function()
    //         {
    //             alert('Không thành công');
    //         }
    //     }).always(function(){
    //         ajax_sendding = false;
            
    //     });
        
    // });
</script>