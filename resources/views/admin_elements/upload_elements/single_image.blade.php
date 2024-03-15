<script type="text/javascript">
// $('.inputFileUpload').change(function(){
$(document).on('change','body .inputFileUpload',function(){
var this_obj=$(this);
var save_folder=$(this).attr("save_folder");  
var input_file_key=$(this).attr("input_file_key");  
var formData = new FormData($('.form-data')[0]);
formData.append("save_folder", save_folder);
formData.append("input_file_key", input_file_key);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
         beforeSend: function() {
                 this_obj.parent().parent().parent().find(".progress-bar").width("0%");
                 this_obj.parent().parent().parent().find(".progress-bar").text("0%");
                 this_obj.parent().parent().parent().find(".progress").show();
             },
    });
  $.ajax({
    type: "POST",
    url: "{{ route('admin.upload_single_image') }}",
    data:formData,
    mimeTypes:"multipart/form-data",
    contentType: false,
    cache: false,
    dataType: 'json',
    processData: false,
    xhr: function() {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function(evt) {
            if (evt.lengthComputable) {
                var percentComplete = (evt.loaded / evt.total) * 100;
                this_obj.parent().parent().parent().find(".progress-bar").width(percentComplete+"%");
                this_obj.parent().parent().parent().find(".progress-bar").text(parseInt(percentComplete)+"%");
              }
       }, false);
       return xhr;
    },
    success: function(data){
        console.log(data);
       if (data.status==true) {
        this_obj.parent().parent().parent().find(".progress").hide();
        this_obj.parent().parent().parent().find(".watter_image").attr("src", data.display_filename);
        this_obj.parent().parent().parent().find(".hidden_filename").val(data.filename);
        this_obj.parent().parent().parent().find(".file_error").text("");
        this_obj.parent().parent().parent().find(".remove_image").show();
        return false;
       }else{
        this_obj.parent().parent().parent().find(".progress").hide();
        this_obj.parent().parent().parent().find(".file_error").text(data.message);
        this_obj.parent().parent().parent().find(".watter_image").attr("src", data.display_filename);
        this_obj.parent().parent().parent().find(".hidden_filename").val("");
        this_obj.parent().parent().parent().find(".remove_image").hide();
        this_obj.parent().parent().parent().find(".inputFileUpload").val("");
        return false;
       }
       
    },
   

 });

});

$(document).on('click','body .remove_image',function(){
    var this_obj=$(this);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
         beforeSend: function() {
                 this_obj.parent().parent().find(".progress-bar").width("0%");
                 this_obj.parent().parent().find(".progress-bar").text("0%");
                 this_obj.parent().parent().find(".progress").show();
             },
    });

  $.ajax({
    type: "POST",
    url: "{{ route('admin.remove_single_image') }}",
    data:{},
    mimeTypes:"multipart/form-data",
    contentType: false,
    cache: false,
    dataType: 'json',
    processData: false,
    xhr: function() {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function(evt) {
            if (evt.lengthComputable) {
                var percentComplete = (evt.loaded / evt.total) * 100;
                this_obj.parent().parent().find(".progress-bar").width(percentComplete+"%");
                this_obj.parent().parent().find(".progress-bar").text(parseInt(percentComplete)+"%");
              }
       }, false);
       return xhr;
    },
    success: function(data){
             
       if (data.status==true) {
        
        this_obj.parent().parent().find(".progress").hide();
        this_obj.parent().parent().find(".file_error").text("");
        this_obj.parent().parent().find(".watter_image").attr("src", data.display_filename);
        this_obj.parent().parent().find(".hidden_filename").val("");
        this_obj.parent().parent().find(".remove_image").hide();
        this_obj.parent().parent().find(".inputFileUpload").val("");

       }
       
    },
   

 });



});

</script>