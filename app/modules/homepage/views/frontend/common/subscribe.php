
<form action="<?php echo site_url('mailsubricre/frontend/mailsubricre/createphone') ?>" id="sform_phone" method="post">
    <div class="error uk-alert"></div>
    <input type="text" class="form-group form-control phone" placeholder="Nhập số điện thoại" name="phone">
    <button class="btn btn-default btn-hover">Gọi lại cho tôi</button>
</form>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
        $('#sform_phone .error').hide();
        var uri = $('#sform_phone').attr('action');
        $('#sform_phone').on('submit',function(){
            var postData = $(this).serializeArray();
            $.post(uri, {post: postData, phone: $('#sform_phone .phone').val()},
            function(data){
                var json = JSON.parse(data);
                $('#sform_phone .error').show();
                if(json .error.length){
                    $('#sform_phone .error').removeClass('alert alert-success').addClass('alert alert-danger');
                    $('#sform_phone .error').html('').html(json.error);
                }else{
                    $('#sform_phone .error').removeClass('alert alert-danger').addClass('alert alert-success');
                    $('#sform_phone .error').html('').html('Gửi yêu cầu tư vấn online thành công!.');
                    $('#sform_phone').trigger("reset");
                    setTimeout(function(){ location.reload(); }, 5000);
                }
            });
            return false;
        });
    });
</script>
