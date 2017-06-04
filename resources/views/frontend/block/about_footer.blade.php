<div class="col-md-6 text-center">
    <h3 style="text-transform: uppercase; color: #337ab7 ; font-weight: bold">About 
    @if($nation == 'vi')
    moit
    @else
    moic
    @endif
    </h3>
    @if(isset($data) && count($data) > 0)
    @foreach($data as $val)
    
    <p><a href="{{ Helper::href_format($val->link2,$val->cursor,$val->id) }}" @if($val->target) target="{{ $val->target }}" @endif>{{ ucfirst($val->name) }}</a></p>
    @endforeach
    @endif
</div>