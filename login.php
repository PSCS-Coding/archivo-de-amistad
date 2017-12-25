<?php
$ip = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']); 
function generateRandomString($length = 12) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Repo:Login</title>
    <?php require_once('header.php'); ?>
</head>

<body style="background-color:#24292d !important;">
        <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Authentication Checkpoint</h5>
                </div>
                <form action="confirm.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                    <div class="input-group-addon">USER IP:</div>
                            <input type="text" class="form-control" name="IP" id="IP" value="<?php echo $ip; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                    <div class="input-group-addon">PASSWORD:</div>
                                    <input type="password" class="form-control" name="password" id="password">
                                </div>
                            </div>
                        </div>
                        <br />
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="VERIFY" name="submit" class="form-control nav-link btn btn-outline-warning">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>printf("uniqid(): %s\r\n", uniqid());
<script>
        $(window).on('load',function(){
        $('#exampleModal').modal('show');
    });
    $('#exampleModal').modal({
    backdrop: 'static',
    keyboard: false
})
</script>
</html>