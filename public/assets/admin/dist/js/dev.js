//$(document).ready(function(){
    // Tự nhập đường dẫn ảo bằng sự kiện keydown và keyup
$('input[name="name"]').bind('keydown keyup',function(){
    $('.add-alias').val(changeTitle($(this).val()));
    $('input[name="meta_title"]').val($(this).val());
    
});
//});

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

// Tạo đường dẫn alias
function stripUnicode(str){
    if(!str) return false;
    var khongdau = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','-',''];
    var codau = ['á|à|ã|ạ|ả|ă|ắ|ằ|ặ|ẳ|ấ|ẫ|ầ|ă|ậ|ẩ|ă|â|Á|À|Ã|Ạ|Ả|Ắ|Ằ|Ặ|Ẵ|Ẳ|Ấ|Ầ|Ẩ|Ẫ|Ậ|Ă|Â|A','B','C','đ|Đ|D','ê|é|è|ẽ|ẹ|ẻ|ế|ề|ễ|ệ|ể|Ê|É|È|Ẽ|Ẹ|Ẻ|Ế|Ề|Ể|Ễ|Ệ|E','F','G','H','í|ì|ị|ỉ|ĩ|Í|Ì|Ỉ|Ĩ|Ị|I','J','K','L','M','N','ó|ò|ọ|õ|ỏ|ố|ồ|ổ|ỗ|ộ|ớ|ờ|ợ|ở|ỡ|ô|ơ|Ó|Ò|Ọ|Ỏ|Õ|Ố|Ồ|Ổ|Ỗ|Ộ|Ớ|Ờ|Ợ|Ở|Ỡ|Ô|Ơ|O','P','Q','R','S','T','ú|ù|ủ|ũ|ụ|ứ|ừ|ự|ử|ữ|ư|Ú|Ù|Ủ|Ũ|Ụ|Ứ|Ừ|Ử|Ữ|Ự|Ư|U','V','W','X','ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ|Y','Z',' - | -|- ',',|.|/|~|@|#|$|%|^|&|*|(|)|-|+||{|}|:|"|<|>|?'];
    
    var arr = [];
    for(var i = 0 ; i < khongdau.length ; i++){
        arr = codau[i].split('|');
        $.each(arr,function(key,value){
            //str = str.replace(value,khongdau[i]);
            str = str.split(value).join(khongdau[i]);
        });
    }
    console.log(khongdau.length);
    return str;
}

function changeTitle(str){
    if(str == '') return '';
    str = stripUnicode(str);
    str = str.split(' ').join('-');
    return str;
}





/////////////// ajax


$('input.check_box_all').change(function(){
    if($(this).is(':checked')) {
        $('.check_box').prop('checked', true);
    } else {
        $('.check_box').prop('checked', false);
    }
});

// function search_admin(){
//     var val = $('.txt_search').val();
//     var res = document.URL.split('?');
//     if(val){
//         window.location.href = res[0] + '?search=' + val;
//     }else{
//         window.location.href = res[0];
//     }
// }

// $('.btn_search').click(function(){
//     search_admin();    
// });

// $('.txt_search').keyup(function(e){
//     if(e.keyCode == 13)
//     {
//         e.preventDefault();
//         search_admin();
//     }
// });
$('i.fa-trash-o').click(function(){
    if(!window.confirm('Thao tác này không thể khôi phục . Bạn có thực sự muốn xóa ?')){ 
        return false; 
    }
});


