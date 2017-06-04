
@if(isset($data) && count($data) > 0)


<section id="slider" class="row" style="margin-top: -20px;">
    <div class="col-md-12">
        <ul class="bxslider">
            @foreach($data as $key => $val)
            <li><img src="{{ asset($val->image) }}" title="{{ $val->name }}" alt="{{ $val->name }}"/></li>
            @endforeach
        </ul>
    </div>
</section>
@endif