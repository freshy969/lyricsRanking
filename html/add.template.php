<?php
$helpers = new \Lubomir\LyricsRanking\Helpers();
$error = false;
$errortype = null;
$errormsg = "";

new \Lubomir\LyricsRanking\Enqueue();

if (isset($_POST['submit_rank'])) {
    $rank_name = htmlspecialchars($_POST["rank_name"]);
    $image_url = htmlspecialchars($_POST["image_url"]);
    $post_needed = intval(htmlspecialchars($_POST["post_needed"]));

    if ($rank_name != null && $image_url != null && $post_needed != null) {
        $error = true;
        $errortype = "success";
        $errormsg = "Ранга {$rank_name} е добавен успешно!";

        $helpers->createNewRank($rank_name, $image_url, $post_needed);
    } else {
        $error = true;
        $errortype = "danger";
        $errormsg = "Моля попълнете всички полета преди да запазите ранга!";
    }
}

?>
<div class="wrap">
    <h1>Lyrics Ranking | Add</h1>

    <div class="container">
        <div class="row mt-5 py-5 col-md-12">
            <?php if ($error) { ?>
                <div class="alert alert-<?php echo $errortype ?>"><?php echo $errormsg; ?></div>
            <?php } ?>
            <div class="card col-md-12">
                <div class="card-body">
                    <h5 class="card-title">Добавяне на ранг</h5>
                    <form method="post">
                        <div class="form-row">
                            <div class="col-3">
                                <input type="text" name="rank_name" class="form-control" placeholder="Име на ранг">
                            </div>
                            <div class="col-3">
                                <input type="url" name="image_url" class="form-control" placeholder="Url на изображение">
                            </div>
                            <div class="col-3">
                                <input type="number" name="post_needed" class="form-control" placeholder="Нужни постове">
                            </div>

                            <button type="submit" name="submit_rank" class="btn btn-success btn-sm">Добавяне</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>