
@if(isset($data) && count($data) > 0)
<section class="dq-stt-6">
    <section class="sec-brand p20">
        <div class="container">
            <div class="row">
                <div class="brand-logo">
                    <div id="owl-prod-t1xxx" class="owl-carousel">
                    @foreach($data as $val)
                        <div class="col-xs-12">
                            <a href="javascript:void(0)"><img src="{{ asset($val->image) }}"  alt="{{ $val->name }}" >
                            </a>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
@endif