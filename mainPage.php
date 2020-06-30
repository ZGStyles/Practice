<?php
if($_COOKIE['idUser'] == ""){
    header("Location: /",true,307);
}
require_once("include/selectedFunc.php");
?>
<html>
    <head>
        <title>
            Main page
        </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
    <!--Navigate Menu-->
        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
            <h5 class="my-0 mr-md-auto font-weight-normal">Main page</h5>
            <nav class="my-2 my-md-0 mr-md-3">
                <button name="filterButton" onclick="filterClick()" class = "btn btn-primary-outline">Filter photo</button>
            </nav>
            <nav class="my-2 my-md-0 mr-md-3">
                <button name="uploadPhoto" onclick="uploadPhotoClick()" class="btn btn-primary-outline">Upload Photo</button>
            </nav>
            <nav class="my-2 my-md-0 mr-md-3">
                <button name="profile" onclick="profileClick()" type="submit" class="btn btn-primary-outline">Profile</button>
            </nav>
            <nav class="my-2 my-md-0 mr-md-3">
                <button name="allPhoto" onclick="allPhotosClick()" type="submit" class="btn btn-primary-outline">All photo</button>
            </nav>
            <form action="Engine.php" method="post">
                <button name="signOut" type="submit" class="btn btn-primary-outline">Sign out</button>
            </form>
        </div>
    <!--Upload photo menu-->
        <div id="uploadPhoto" style="display: none">
            <form method="post" action="Engine.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-1">
                        <label >Choose files</label>
                    </div>
                    <div class="col">
                        <input type="file" name="docs[]" multiple />
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        <label>Tags</label>
                    </div>
                    <div class="col-6">
                        <input name="tags" type="text" class="form-control">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="uploadPhoto">Upload</button>
            </form>
        </div>
    <!--All photos-->
        <div id="allPhotos" style="display: block">
            <div class="container">
                <div class="row">
            <?php
                $allRows = allPhotoFnc();
                foreach ($allRows as $data):
            ?>
                    <div class="col-sm-4">
                        <form action="photoDetails.php" method="post">
                            <div class="alert alert-primary">
                                <img style="width: 250px;height: 250px" src="<?=$data['file_path']?>"><br>
                                <h5>Views:<span class="badge badge-pill badge-secondary"><?=$data['views']?></span></h5>
                                <input name="idPhoto" type="hidden" value="<?=$data['id']?>">
                                <button type="submit" class="btn btn-primary" name="moreDetails">More details</button>
                            </div>
                        </form>
                    </div>
            <?php endforeach;?>
                </div>
            </div>
        </div>
    <!--Profile-->
        <div id="Profile" style="display: none">
            <div class="container">
                <div class="row">
                    <?php
                    $allRows = profilePhotoFnc($_COOKIE['idUser']);
                    foreach ($allRows as $data): ?>
                        <div class="col-sm-4">
                            <div class="alert alert-primary">
                                <form action="photoDetails.php" method="post">
                                    <img style="width: 250px;height: 250px" src="<?=$data['file_path']?>"><br>
                                    <h5>Views:<span class="badge badge-pill badge-secondary"><?=$data['views']?></span></h5>
                                    <input name="idPhoto" type="hidden" value="<?=$data['id']?>">
                                    <button type="submit" class="btn btn-primary" name="moreDetails">More details</button>
                                </form>
                                <form action="Engine.php" method="post">
                                    <input name="idPhoto" type="hidden" value="<?=$data['id']?>">
                                    <button type="submit" class="btn btn-danger" name="deletePhoto">Delete photo</button>
                                </form>
                                <form action="addTags.php" method="post">
                                    <input name="idPhoto" type="hidden" value="<?=$data['id']?>">
                                    <button name="changeTag" type="submit" class="btn btn-success" name="addTags">Add tags</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    <!--Add tags-->
        <div id="filter" style="display: none">
            <div class="container">
                <div class="row">
                    <?php
                    //Разделение тегов, подсчитывает уникальное кол-во тегов и разбивает.
                    $arrayTagsAll = splitTagsFnc();
                    $arrayTags = array_count_values($arrayTagsAll);
                    foreach ($arrayTags as $key => $value): ?>
                    <div class="col-sm-4">
                        <form action="filter.php" method="post">
                            <div class="alert alert-primary">
                                <h5>Tag:<?=$key?></h5>
                                <input name="tag" type="hidden" value="<?=$key?>">
                                <button type="submit" class="btn btn-primary" name="showFilter">Show</button>
                            </div>
                        </form>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </body>

    <script>
        var divUploadPhoto = document.getElementById("uploadPhoto");
        var divAllPhotos = document.getElementById("allPhotos");
        var divProfile = document.getElementById("Profile");
        var divFilter = document.getElementById("filter");

        function uploadPhotoClick() {
            divUploadPhoto.style.display = "block";
            divAllPhotos.style.display = "none";
            divProfile.style.display = "none"
            divFilter.style.display = "none";
        }
        function allPhotosClick() {
            divUploadPhoto.style.display = "none";
            divAllPhotos.style.display = "block";
            divProfile.style.display = "none";
            divFilter.style.display = "none";
        }
        function profileClick() {
            divUploadPhoto.style.display = "none";
            divAllPhotos.style.display = "none";
            divProfile.style.display = "block";
            divFilter.style.display = "none";
        }
        function filterClick() {
            divUploadPhoto.style.display = "none";
            divAllPhotos.style.display = "none";
            divProfile.style.display = "none";
            divFilter.style.display = "block";
        }
    </script>
</html>
