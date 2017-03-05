<?php
    require dirname(__DIR__).'..\backend\controller\intructor.php';
        $content = new intructor_controller();
/*
session_start();
if (isset($_SESSION['id'])) {
} elseif (!isset($_SESSION['id'])) {
    header('location: index.php');
}*/
if (isset($_POST['unit'])) {
    $content->content('1', $_POST['content'], $_POST['unit']);
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <script src="lib/jquery-3.1.1.min.js"></script>
    <script src="lib/materialize/js/materialize.min.js"></script>
    <link rel="stylesheet" href="lib/materialize/css/materialize.min.css">
    <script src="http://cdn.ckeditor.com/4.6.0/standard-all/ckeditor.js"></script>
    <script type="text/javascript" src="lib/notify.js"></script>
    <script type="text/javascript" async src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS_CHTML">
    </script>
    <script type="text/x-mathjax-config">
        MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
    </script>
  </head>
  <body>
    <button id="content"type="button" name="button" class="waves-effect waves-light btn"> บันทึกข้อมูล</button>
    <textarea rows="4" cols="8" id="editor" name="content">
      <?php  $content->returnContent($_GET['unit']);
      ?>
    </textarea>
    <script>
                            var editor = CKEDITOR.replace('editor', {
                                extraPlugins: 'mathjax',
                                mathJaxLib: 'http://cdn.mathjax.org/mathjax/2.6-latest/MathJax.js?config=TeX-AMS_HTML',
                                height: 1000,
                                width: 1366
                            });
                            $(document).ready(function() {
                                $.notify.addStyle('happyblue', {
                                    html: "<div><h1>☺<span data-notify-text/>☺</h1></div>",
                                    classes: {
                                        base: {
                                            "white-space": "nowrap",
                                            "background-color": "lightblue",
                                            "padding": "5px"
                                        },
                                        superblue: {
                                            "color": "white",
                                            "background-color": "blue"
                                        }
                                    }
                                });
                                $("#content").click(function() {
                                    $.post("MakeContent.php", {
                                            content: editor.getData(),
                                            unit: '<?php echo $_GET['unit']; ?>'
                                        },
                                        function(result) {
                                            $.notify("บันทึกเรียบร้อย", {
                                                style: 'happyblue'
                                            });
                                        }
                                    );

                                });
                            });
                        </script>
  </body>

</html>
