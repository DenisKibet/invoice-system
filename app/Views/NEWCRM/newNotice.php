<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Invoice System - Add Notice</title>
    <?php include 'css.php' ?>
    <style>
        .icon {
            vertical-align: middle;
        }

        .noticePost:nth-child(odd) {
            background-color: #94d1eb;
            padding: 10px;
            border-radius: 12px;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include 'sidebarcreate.php' ?>
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include 'topbar.php' ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Add Notice</h1>
                    </div>
                    <div class="card-body" style="width: 100%;">

                        <div class="col-12 card-header" style="color:#1a1a1a; background-color: #b3b3b3;border-radius: 0 12px 12px 0;">
                            <h4> <i class="fa fa-exclamation-circle" style="color:#1a1a1a;vertical-align:middle;"></i>
                                Add Notice</h4>

                        </div>
                        <form method="post" action="/addNotice">
                            <br />
                            <div class="noticePost">
                                <label><h5 style="color:#1a1a1a;">Notice Heading</h5></label>
                                <input type="text" name='noticeHeading[]' style="width:100%;" class="form-control w3-card-2" /><br />

                                <label><h5 style="color:#1a1a1a;">Body Text</h5></label>
                                <textarea style="width:100%" class="form-control w3-card-2" rows="8" placeholder="Add Notice..." name="noticeBody[]"></textarea><br />
                            </div>

                            <div id="addNewPost"></div>

                            <button type="button" style="border:none;color:#1a1a1a;background:#eaecf4;" class="mb-5 mt-3" id="addNewPostButton">
                                <i class="material-icons icon" style="color:#1a1a1a;vertical-align:middle;">add_circle</i><b><span style="vertical-align:bottom"> Add Post</span></b></button>
                            <input type="submit" value="Post to Dashboard" class="form-control" style="width:100%; padding:5px;background-color:#5a5c69;color:white;" />
                        </form>
                        <div class="modal" id="previewmodal" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Itravel Holidays!</h5>
                                        <button type="button" class="close" data-dismiss="modal" onclick="closemodal()"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                            onclick="closemodal()">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php include 'js.php' ?>
                        <script>
                            // $('#comment').summernote('lineHeight', 0.1);
                            // $("#btnsave").click(function(e) {
                            $(document).one("click", "#btnsave", function (e) {
                                var image = "/assets/img/ajax-loader_2.gif";
                                e.preventDefault();
                                e.stopImmediatePropagation();
                                $("#btnsave").prop("disabled", true);
                                var dataURLpay = '/saveComment';
                                var formdatasendget = $('#commentform').serialize();
                                $.ajax({
                                    type: 'POST',
                                    cache: false, // Disable caching
                                    url: dataURLpay,
                                    data: formdatasendget,
                                    beforeSend: function () {
                                        $(".modal-body").html("<img src='" + image +
                                            "' style='margin-top:1%;;margin-left:50%' /> <br> <div style='margin-top:6%;;margin-left:30%'><i class='fa fa-save fa-3x'> </i> <h1> Saving comment please wait.</h1></div>"
                                        );
                                        $("#previewmodal").modal("show");
                                    },
                                    success: function (data) {
                                        $("#previewmodal").modal("hide");
                                        location.reload();

                                    },
                                    error: function (jqXHR, textStatus, errorThrown) {
                                        alert('error: ' + textStatus + ': ' + errorThrown);
                                    }
                                })
                            });
                        </script>
                    </div>

                </div>

            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Itravel Holidays 2024</span>
                    </div>
                </div>
            </footer>

            <script>
                $(document).ready(function() {
                    var newPost = `
                    <div class="mb-5 mt-5 noticePost">
                        <label><h5 style="color:#2489b5;">Notice Heading</h5></label><br />
                        <input type="text" name="noticeHeading[]" class="form-control w3-card-2" style="width:100%;" /><br />

                        <label><h5 style="color:#2489b5;">Body Text</h5></label><br />
                        <textarea class="form-control w3-card-2" name="noticeBody[]" style="width:100%;" placeholder="Add Notice..." rows="8"></textarea><br />

                        <button class="removeNotice btn btn-danger btn-sm" type="button" style="margin-top: 0em;float: right;margin-left: 0px">
                        <i class="fa fa-minus"> Remove Post</i></button>
                    </div>
                    `;

                    $('#addNewPostButton').click(function() {
                        $('#addNewPost').append(newPost);
                    })

                    $(document).on('click', '.removeNotice', function() {
                        $(this).parent('div').remove();
                    });
                    
                    $('#Viewdets').on('hidden.bs.modal', function() {
                        document.location.reload();
                    });
                });
            </script>
</body>

</html>
