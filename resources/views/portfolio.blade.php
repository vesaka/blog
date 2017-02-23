@extends('layouts.main')
@section('title')
@lang('home.titles.gallery')
@endsection
@section('scripts')
@parent
<script src="/assets/js/jssor.slider.-22.1.8.min.js"></script>
<script src="/assets/js/jssor-presets.js"></script>
@endsection
@section('styles')
@parent
<link rel="stylesheet" href="/assets/css/slider-styles.css"/>
@endsection
@section('content')

<div class="row" style=";margin-left: 0; margin-left: 0;width: 100%;">
    <div class="col-md-2 image-sort-options section">
        
        <button onclick="getImages()">All</button>
        @foreach($categories as $category)
        
        <button id="{{$category->id}}" onclick="getImagesBy(this.id)">
            {{$category->name}}
        </button>	
        @endforeach
    </div>
    <div class="col-md-10" style="padding: 0; background-color:#fff;font-family:Arial, sans-serif">
        <script>
            var jssor_1_slider_init = function () {
                var jssor_1_slider = new $JssorSlider$("jssor_1", options.thumbnail);
                function ScaleSlider() {

                    var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
                    if (refSize) {
                        refSize = Math.min(refSize, 1920);
                        jssor_1_slider.$ScaleWidth(refSize);
                    } else {
                        window.setTimeout(ScaleSlider, 30);
                    }
                }
                ScaleSlider();
                $Jssor$.$AddEvent(window, "load", ScaleSlider);
                $Jssor$.$AddEvent(window, "resize", ScaleSlider);
                $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
            };
        </script>
        <!-- Loading Screen -->

        <div id="jssor_1" class="jssor-size jssor-box">
            <div data-u="loading" class="jssor-spinner-box">
                <div class="jssor-top-spinner" style=""></div>
                <div class="jssor-spinner"></div>
            </div>
            <div id="slider" data-u="slides" class="jssor-size jssor-thumbnails-box">
                @include('image.slider')
            </div>
            <!-- thumbnail navigator container -->
            <div u="thumbnavigator" id="thumbnail-navigator" class="jssort05" style="left: 0px; bottom: 0px;">
                <!-- Thumbnail Item Skin Begin -->
                <div u="slides" style="cursor: default;">
                    <div u="prototype" class="p">
                        <div class="o">
                            <div u="thumbnailtemplate" class="b"></div>
                            <div class="i"></div>
                            <div u="thumbnailtemplate" class="f"></div>
                        </div>
                    </div>
                </div>
                <!-- Thumbnail Item Skin End -->
            </div>
        </div>

    </div>
    <script type="text/javascript">
        var originalContent = $('#jssor_1').html();
        jssor_1_slider_init();
    </script>
    <!-- #endregion Jssor Slider End -->

</div>

<script>

    function getImages() {
        session.removeItem('category_id');
        retrieveImages('/image/getall');
    }

    function getImagesBy(id) {
        session.setItem('category_id', id);
        retrieveImages('/image/getby/' + id);
    }

    function retrieveImages(href) {
        $.ajax({
            url: href,
            success: function (res, obj) {
                $('#jssor_1').html(originalContent);
                $('#slider').html(res);
                jssor_1_slider_init();
            },
            error: function (res, obj, o) {
            }
        });
    }
</script>
@endsection
