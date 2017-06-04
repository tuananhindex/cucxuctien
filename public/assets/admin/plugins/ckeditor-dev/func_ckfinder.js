function ckeditor (name) {
    var editor = CKEDITOR.replace(name ,{
        uiColor : '#9AB8F3',
        language:'vi',
        filebrowserBrowseUrl : baseURL+'/assets/admin/plugins/ckeditor-dev/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl : baseURL+'/assets/admin/plugins/ckeditor-dev/ckfinder/ckfinder.html?Type=Images',
        filebrowserFlashBrowseUrl : baseURL+'/assets/admin/plugins/ckeditor-dev/ckfinder/ckfinder.html?Type=Flash',
        filebrowserUploadUrl : baseURL+'/assets/admin/plugins/ckeditor-dev/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl : baseURL+'/assets/admin/plugins/ckeditor-dev/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl : baseURL+'/assets/admin/plugins/ckeditor-dev/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',

        toolbar:[
        ['Source','-','Save','NewPage','Preview','-','Templates'],
        ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print'],
        ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
        ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'HiddenField'],
        ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
        ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
        ['Link','Unlink','Anchor'],
        ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe'],
        ['Styles','Format','Font','FontSize'],
        ['TextColor','BGColor'],
        ['Maximize', 'ShowBlocks','-','About']
        ]
        });
}