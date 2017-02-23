@extends('layouts.admin')
@section('content')
<form action="{{!isset($image) ? '/admin/image' : '/admin/image/' . $image->id}}" method="POST" id="image_form" class="form-horizontal docs-options" enctype="multipart/form-data" role="form">
    {{ csrf_field() }}
    @if(isset($image)) 
    {{ method_field('PUT') }}
    @endif
    <div class="col-md-9">
        <h3>Image: </h3>
        <div id="img_container" class="img-container"><img id="loader" src="" alt="No image"/><img id="image_preview" src="{{$image->src or '/assets/img/default.jpg'}}"></div>
    </div>
    <div class="docs-alert"></div>

    <div class="col-md-3">
        <h3>Preview:</h3>
        <div class="row">
            <div class="col-md-8">
                <div class="img-preview img-preview-sm"></div>
            </div>
            <div class="col-md-4">
                <div class="img-preview img-preview-xs"></div>
            </div>
        </div>
        <hr>
        <h3>Data:</h3>
        <div class="docs-data">
            <div class="input-group">
                <label class="input-group-addon" for="dataX">X</label>
                <input type="integer" name="image_x" class="form-control" id="dataX" type="text" placeholder="x">
                <span class="input-group-addon">px</span>
            </div>
            <div class="input-group">
                <label class="input-group-addon" for="dataY">Y</label>
                <input type="integer" name="image_x" class="form-control" id="dataY" type="text" placeholder="y">
                <span class="input-group-addon">px</span>
            </div>
            <div class="input-group">
                <label class="input-group-addon" for="dataWidth">Width</label>
                <input type="integer" name="image_width" class="form-control" id="dataWidth" type="text" placeholder="width">
                <span class="input-group-addon">px</span>
            </div>
            <div class="input-group">
                <label class="input-group-addon" for="dataHeight">Height</label>
                <input type="integer" name="image_heigth" class="form-control" id="dataHeight" type="text" placeholder="height">
                <span class="input-group-addon">px</span>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="docs-toolbar">
                <div class="btn-group">
                    <button class="btn btn-primary" data-method="zoom" data-option="0.1" type="button" title="Zoom In">
                        <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;zoom&quot;, 0.1)">
                            <span class="glyphicon glyphicon-zoom-in"></span>
                        </span>
                    </button>
                    <button class="btn btn-primary" data-method="zoom" data-option="-0.1" type="button" title="Zoom Out">
                        <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;zoom&quot;, -0.1)">
                            <span class="glyphicon glyphicon-zoom-out"></span>
                        </span>
                    </button>
                    <button class="btn btn-primary" data-method="rotate" data-option="-90" type="button" title="Rotate Left">
                        <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;rotate&quot;, -90)">
                            <span class="glyphicon glyphicon-share-alt docs-flip-horizontal"></span>
                        </span>
                    </button>
                    <button class="btn btn-primary" data-method="rotate" data-option="90" type="button" title="Rotate Right">
                        <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;rotate&quot;, 90)">
                            <span class="glyphicon glyphicon-share-alt"></span>
                        </span>
                    </button>
                    <button class="btn btn-primary" data-method="setDragMode" data-option="move" type="button" title="Move">
                        <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)">
                            <span class="glyphicon glyphicon-move"></span>
                        </span>
                    </button>
                    <button class="btn btn-primary" data-method="setDragMode" data-option="crop" type="button" title="Crop">
                        <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setDragMode&quot;, &quot;crop&quot;)">
                            <span class="glyphicon glyphicon-plus"></span>
                        </span>
                    </button>
                    <button class="btn btn-primary" data-method="clear" type="button" title="Clear">
                        <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;clear&quot;)">
                            <span class="glyphicon glyphicon-remove"></span>
                        </span>
                    </button>
                    <label class="btn btn-primary" for="inputImage" title="Upload image file">
                        <input class="hide" id="inputImage" name="image_file" type="file">
                        <span class="docs-tooltip" data-toggle="tooltip" title="Import image with Blob URLs">
                            <span class="glyphicon glyphicon-upload"></span>
                        </span>
                    </label>
                    <label class="btn btn-primary" for="submitImage" title="Submit the image">
                        <input type="submit" id="submitImage" class="hide" name="submitImage" value="Post image">
                        <span class="docs-tooltip" data-toggle="tooltip" title="Submit selected image">
                            <span class="glyphicon glyphicon-export"></span>&nbsp;Post image
                        </span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="message-error" class="row col-md-12">{{$error or null}}</div><br/>
    </div>
    <ul class="row nav nav-pills">
        <li class="active"><a data-toggle="pill" href="#data-tab">Data</a></li>
        <li><a data-toggle="pill" href="#cropper-tab">Cropper Tool</a></li>
    </ul>

    <div class="tab-content">
        <div id="data-tab" class="col-md-12 tab-pane fade in active">
            <div class="col-md-8">
                <div class="form-group">
                    <input type="text" class="form-control" name="image_title" placeholder="Image title" id="title" value="{{$image->name or null}}">
                </div>
                <textarea name="image_description" id="editor">{!!$image->description or Lipsum::headers()->link()->ul()->html(3)!!}</textarea>
                <input type="hidden" id="imageCropData" name="image_crop_data" value="{{$image->area or null}}">
                <input type="hidden" id="imageData" name="image_metadata" value="{{$image->metadata or null}}">
                <input type="hidden" id="imageExtension" name="image_extension" value="{{$image->extension or null}}">
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="image_tags" id="tokenfield" value="{{$image->tags or null}}" />
                </div>
                <input type="hidden" id="category" name="image_category" value="{{$image->category or null}}"/>
                @include('layouts.tree')
            </div>
        </div>
        <div id="cropper-tab" class="row tab-pane fade in">

            <div class="row">
                <div class="col-md-9">
                    <div class="docs-btn-group">
                        <h3>Methods:</h3>
                        <div class="button-group">
                            <button class="btn btn-warning" id="reset" data-method="reset" data-toggle="tooltip" type="button" title="$().cropper(&quot;reset&quot;)">Reset</button>
                            <button class="btn btn-warning" id="reset2" data-method="reset" data-option="true" data-toggle="tooltip" type="button" title="$().cropper(&quot;reset&quot;, true)">Reset (deep)</button>
                            <button class="btn btn-success" id="enable" data-method="enable" type="button">Enable</button>
                            <button class="btn btn-warning" id="disable" data-method="disable" type="button">Disable</button>
                            <button class="btn btn-primary" id="clear" data-method="clear" type="button">Clear</button>
                            <button class="btn btn-danger" id="destroy" data-method="destroy" type="button">Destroy</button>
                            <button class="btn btn-info" id="freeRatio" data-method="setAspectRatio" data-option="auto" data-toggle="tooltip" type="button" title="$().cropper(&quot;setAspectRatio&quot;, &quot;auto&quot;)">Free Ratio</button>
                            <button class="btn btn-primary" id="setData" type="button" title="Set with the following data">Set Data</button>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon">X</span>
                                    <input class="form-control" id="setDataX" type="number" value="550">
                                    <span class="input-group-addon">px</span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon">Y</span>
                                    <input class="form-control" id="setDataY" type="number" value="100">
                                    <span class="input-group-addon">px</span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon">Width</span>
                                    <input class="form-control" id="setDataWidth" type="number" value="480">
                                    <span class="input-group-addon">px</span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon">Height</span>
                                    <input class="form-control" id="setDataHeight" type="number" value="270">
                                    <span class="input-group-addon">px</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" id="zoom" type="button">Zoom</button>
                                    </span>
                                    <input class="form-control" id="zoomWith" type="number" value="0.5">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" id="rotate" type="button">Rotate</button>
                                    </span>
                                    <input class="form-control" id="rotateWith" type="number" value="45">
                                    <span class="input-group-addon">deg</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" id="replace" type="button">Replace</button>
                                    </span>
                                    <input class="form-control" id="replaceWith" type="text" value="img/picture-2.jpg" placeholder="Input image URL">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" id="setAspectRatio" type="button">Set Aspect Ratio</button>
                                    </span>
                                    <input class="form-control" id="setAspectRatioWith" type="text" value="0.618" placeholder="Input aspect ratio">
                                </div>
                            </div>
                        </div>

                        <div class="row docs-data-url">
                            <div class="col-sm-6">
                                <textarea style="visibility: hidden" class="form-control" name="image_biginfo" id="dataURLInto" rows="8"></textarea>
                            </div>
                            <div class="col-sm-6">
                                <div id="dataURLView"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <h3>Options:</h3>
                    <div class="form-group">
                        <label class="col-xs-4 control-label">autoCrop:</label>
                        <div class="col-xs-8">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary active">
                                    <input id="autoCrop1" name="autoCrop" type="radio" value="true" checked> Yes
                                </label>
                                <label class="btn btn-primary">
                                    <input id="autoCrop2" name="autoCrop" type="radio" value="false"> No
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label">dragCrop:</label>
                        <div class="col-xs-8">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary active">
                                    <input id="dragCrop1" name="dragCrop" type="radio" value="true" checked> Yes
                                </label>
                                <label class="btn btn-primary">
                                    <input id="dragCrop2" name="dragCrop" type="radio" value="false"> No
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label">modal:</label>
                        <div class="col-xs-8">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary active">
                                    <input id="modal1" name="modal" type="radio" value="true" checked> Yes
                                </label>
                                <label class="btn btn-primary">
                                    <input id="modal2" name="modal" type="radio" value="false"> No
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label">dashed:</label>
                        <div class="col-xs-8">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary active">
                                    <input id="dashed1" name="dashed" type="radio" value="true" checked> Yes
                                </label>
                                <label class="btn btn-primary">
                                    <input id="dashed2" name="dashed" type="radio" value="false"> No
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label">movable:</label>
                        <div class="col-xs-8">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary active">
                                    <input id="movable1" name="movable" type="radio" value="true" checked> Yes
                                </label>
                                <label class="btn btn-primary">
                                    <input id="movable2" name="movable" type="radio" value="false"> No
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label">resizable:</label>
                        <div class="col-xs-8">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary active">
                                    <input id="resizable1" name="resizable" type="radio" value="true" checked> Yes
                                </label>
                                <label class="btn btn-primary">
                                    <input id="resizable2" name="resizable" type="radio" value="false"> No
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label">zoomable:</label>
                        <div class="col-xs-8">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary active">
                                    <input id="zoomable1" name="zoomable" type="radio" value="true" checked> Yes
                                </label>
                                <label class="btn btn-primary">
                                    <input id="zoomable2" name="zoomable" type="radio" value="false"> No
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label">rotatable:</label>
                        <div class="col-xs-8">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary active">
                                    <input id="rotatable1" name="rotatable" type="radio" value="true" checked> Yes
                                </label>
                                <label class="btn btn-primary">
                                    <input id="rotatable2" name="rotatable" type="radio" value="false"> No
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label">multiple:</label>
                        <div class="col-xs-8">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary">
                                    <input id="multiple1" name="multiple" type="radio" value="true"> Yes
                                </label>
                                <label class="btn btn-primary active">
                                    <input id="multiple2" name="multiple" type="radio" value="false" checked> No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>var cropData = JSON.parse('{!!$image->area or "[]"!!}');</script>
<script src="/_admin/js/main.js"></script>
<script>

var filename = "";
var fileRequired = {{isset($image) ? 0 : 1}};
var fileRules

document.getElementById("image_form").validator({
    image_file: fileRequired === 1 ? [
        ['required', 'Image file is required']
    ] : [],
    image_title: [
        ['required', 'Image title is required'],
        ['regexp:alphaDash', 'Illegal characters! Letters, numbers and dashes only']
    ],
    image_category: [
        ['required', 'Image category required']
    ],
    image_description: [
        ['required', 'Image description is required'],
        ['maxLength:100000', 'Description must be less than {0} characters']
    ]
}, {
    beforeSubmit: function () {
        tinymce.triggerSave();
    },
    errorPlacement: function (el, msg) {
        document.getElementById("message-error").innerHTML = msg;
    },
});

tinymce.init({
    selector: '#editor',
    height: 300,
    theme: 'modern',
    plugins: [
        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen',
        'insertdatetime media nonbreaking save table contextmenu directionality',
        'emoticons template paste textcolor colorpicker textpattern imagetools'
    ],
    toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
    toolbar2: 'print preview media | forecolor backcolor emoticons',
    image_advtab: true,
    templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
    ]
});

var tree = $('#jstree');
var categories = {!!$categories or null!!};
var tags = {!!$tags!!};

tree.jstree({
    core: {
        data: categories || [],
        multiple: false,
        themes: {
            icons: false
        }
    },
    plugins: ['checkbox'],
    checkbox: {
        whole_node: true
    }
}).bind('changed.jstree', function (e, data) {
    if (data.action === "select_node") {
        if (data.node.children.length > 0) {
            tree.jstree(true).deselect_node(data.node);
            tree.jstree(true).toggle_node(data.node);
            return;
        } else {
            document.getElementById('category').value = data.node.id;
        }
    }
}).bind('loaded.jstree', function () {
    tree.jstree('open_all');
    var cat_id = document.getElementById('category').value;

    if (cat_id) {
        tree.jstree('select_node', $('#jstree #' + cat_id));
    }
});

$('#tokenfield').tokenfield({
    autocomplete: {
        source: tags,
        delay: 100
    },
    showAutocompleteOnFocus: true
});

</script>
@endsection
