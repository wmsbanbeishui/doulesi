<?php

use common\helpers\JsBlock;

?>

    <form id="uploadForm" enctype="multipart/form-data" style="background-color:#ecf0f5">
        <span class="file">上传文件夹 <input type="file" id="uoloadfile" name="file" webkitdirectory> </span>
    </form>

<?php JsBlock::begin() ?>
    <script>
        var timestamp = (new Date()).toLocaleDateString().split('/').join('');
        var treeid = timestamp + (new Date()).getHours() + (new Date()).getMinutes() + (new Date()).getSeconds() + parseInt(Math.random() * 101);
        var uploadcount = 0;//这次上传文件总数
        var backcount = 0;
        //文件上传触发时间
        $("#uoloadfile").change(function () {
            var $list = $('.upload-html');
            var files_arr = [];
            var formData = new FormData();
            files_arr = document.getElementById("uoloadfile").files;//获取上传的文件的数据
            var files = [];
            var name = "";
            var xhr = new XMLHttpRequest();
            uploadcount = files_arr.length;
            for (var i = 0; i < files_arr.length; i++) {
                name = files_arr[i].name;
                files = files_arr[i];
                formData.append("cid", treeid);
                formData.append("fname", files.webkitRelativePath);
                formData.append("file", files);
                getajax(formData, name);//执行上传文件ajax
            }
        });

        function getajax(formData, name) {
            $("#thelist2").css("display", "block");
            $.ajax({
                url: '/admin-log/upload',
                type: "POST",
                data: formData,
                async: true,
                processData: false,  // 不处理数据
                contentType: false,
                beforeSend: function () {
                    $('.progress').css('color', '#1AB394').show();
                },
                success: function (result) {
                    backcount++;
                    if (result.code == 1) {
                        $('.progress').html(result.msg).css('color', 'black').fadeOut(10000, function () {
                            $(this).html('')
                        });
                        $('.filename').css('color', 'black').fadeOut(10000, function () {
                            $(this).html('')
                        });
                    }
                    if (backcount == uploadcount) {
                        $('#thelist2').css('display', 'none');
                        /*setTimeout(function(){
                            window.location.reload();
                        },1000);*/
                    }
                },
                xhr: function () {
                    var xhr = $.ajaxSettings.xhr();
                    if (onprogress && xhr.upload) {
                        xhr.upload.addEventListener("progress", function () {
                            onprogress(event, name)
                        }, false);//监听文件上传进度,name文件名
                        return xhr;
                    }
                },
                error: function () {
                    $('.progress').html(result.msg).css('color', 'black').fadeOut(10000, function () {
                        $(this).html('')
                    });
                    $('.filename').css('color', 'black').fadeOut(10000, function () {
                        $(this).html('')
                    });
                    $('#thelist2').css('color', 'black').fadeOut(10000, function () {
                        $(this).html('')
                    });
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }
            });

            //实现进度条
            function onprogress(evt, name) {
                var loaded = evt.loaded;
                var tot = evt.total;
                var txt1 = "<p class='filename'>" + name + "</p>";
                var txt2 = "<div class='progress'><div class='bar'";
                txt2 += 'style=width:';
                txt2 += +Math.floor(100 * loaded / tot) + '%' + ">";
                txt2 += Math.floor(100 * loaded / tot) + '%';
                txt2 += " </div></div>";
                $("#progress-mask").append(txt1, txt2);
            }
        }
    </script>
<?php JsBlock::end() ?>