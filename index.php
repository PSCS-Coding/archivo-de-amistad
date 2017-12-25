<html>
<?php require_once("confirm.php"); 
$ip = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Repo</title>
    <?php require_once("header.php"); ?>
</head>

<body style="background-color:#24292d !important;">
    <div id="load_screen">
        <div id="loading">Loading Repo...
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="admin.php"><span class="badge badge-warning">El</span> Repositorio</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                  <span class="navbar-text">
    <?php echo $ip; ?>
    </span>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="search_text" name="search_text">
            </form>
            <p>&nbsp;</p>
            <button class="btn btn-outline-warning my-2 my-sm-0" type="button" data-toggle="modal" data-target="#exampleModal">Upload</button>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <button id="logout" class="btn btn-outline-warning my-2 my-sm-0" type="button">Logout</button>
        </div>
    </nav>
    <!-- container for fetched images -->
    <div class="container">

        <div id="result"></div>

    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Meme</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-outline-warning" type="button" id="primaryButton" onclick="ExistingLogic()">Choose File</button>
                                        <input type="file" name="fileToUpload" id="fileToUpload" style="display: none;">
                                    </span>
                                    <input type="text" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                    <div class="input-group-addon">Name:</div>
                                    <input type="text" class="form-control" name="memeName" id="memeName">
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">Description:</label>
                                    <textarea class="form-control" name="comments" id="comments"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" value="Close" class="nav-link btn btn-outline-warning" data-dismiss="modal">
                        <input type="submit" value="Upload Image" name="submit" class="nav-link btn btn-outline-warning">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });

    $('#primaryButton').click(function() {
        $("#fileToUpload").click();
    })

    // main loading page event
    window.addEventListener("load", function() {
        var load_screen = document.getElementById("load_screen");
        document.body.removeChild(load_screen);
    });

    document.getElementById("logout").addEventListener("click", function() {
        document.cookie = "login" + '=; Max-Age=0'
        window.location.href = "login.php";
    });

    $(document).ready(function() {

        load_data();
        
        // load images from external page
        function load_data(query) {
            $.ajax({
                url: "fetch.php",
                method: "POST",
                data: {
                    query: query
                },
                success: function(data) {
                    $('#result').html(data);
                    addHandlers();
                }
            });
        }
        $('#search_text').keyup(function() {
            var search = $(this).val();
            if (search != '') {
                load_data(search);
            } else {
                load_data();
            }
        });

        // add event handlers to image captions
        function addHandlers(){
            var tagElementList = document.getElementsByClassName("clickableTags");
            console.log(tagElementList.length);
            for(var i = 0; i < tagElementList.length; i++){
                var postId = tagElementList[i].id;
                tagElementList[i].addEventListener("click",function(){
                    var container =  this.parentNode;
                    console.log(container);
                    container.childNodes[3].style.display = "block";
                    container.childNodes[1].style.display = "none";
                    console.log("clicked " + container.id);
                });
            }
        }

    });

    $(function() {

        // We can attach the `fileselect` event to all file inputs on the page
        $(document).on('change', ':file', function() {
            var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
        });

        // We can watch for our custom `fileselect` event like this
        $(document).ready(function() {
            $(':file').on('fileselect', function(event, numFiles, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = numFiles > 1 ? numFiles + ' files selected' : label;

                if (input.length) {
                    input.val(log);
                } else {
                    if (log) alert(log);
                }

            });
        });

    });

</script>
