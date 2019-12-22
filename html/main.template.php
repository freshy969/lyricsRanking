<?php
global $wpdb;
$helpers = new \Lubomir\LyricsRanking\Helpers();

$ranks       = $helpers->getRanks();
$user        = $helpers->getUser( 1 );
$currentRank = $helpers->getCurrentRankOfUser( $user->ID );

if ( isset( $_GET['delete_rank'] ) ) {
	$rank_id = htmlspecialchars( $_GET['delete_rank'] );
	$helpers->deleteRank( $rank_id );

	wp_redirect( 'admin.php?page=lyrics_ranking.php' );
}

if ( isset( $_POST['update_post'] ) ) {
	$rank_name = htmlspecialchars($_POST["rank_name"]);
	$image_url = htmlspecialchars($_POST["image_url"]);
	$post_needed = intval(htmlspecialchars($_POST["post_needed"]));
    $rank_id = intval(htmlspecialchars($_POST["rank_id"]));
    if($rank_name != null && $image_url != null && $post_needed != null) {
        $helpers->updateRank($rank_id,$rank_name,$image_url,$post_needed);
        // TODO: Make error messages on edit mode
    } else {
        wp_redirect('admin.php?page=lyrics_ranking.php');
    }


	wp_redirect( 'admin.php?page=lyrics_ranking.php' );
}

new \Lubomir\LyricsRanking\Enqueue();


?>
<div class="wrap">
    <h1>Lyrics Ranking System</h1>

    <div class="container">

		<?php
		if ( isset( $_GET['editmode'] ) ) {
			$rank_id = htmlspecialchars( $_GET['editmode'] );
			$rank    = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}ranks WHERE id=%d", $rank_id ) );
			?>
            <div class="card col-md-12">
                <div class="card-body">
                    <h5 class="card-title">Редактиране на <?php echo $rank->rank_title; ?></h5>
                    <form method="post">
                        <div class="form-row">
                            <input type="hidden" name="rank_id" value="<?php echo $rank->id; ?>">
                            <div class="col-3">
                                <input type="text" name="rank_name" value="<?php echo $rank->rank_title; ?>" class="form-control" placeholder="Име на ранг">
                            </div>
                            <div class="col-3">
                                <input type="url" name="image_url" class="form-control" value="<?php echo $rank->image_url; ?>" placeholder="Url на изображение">
                            </div>
                            <div class="col-3">
                                <input type="number" name="post_needed" class="form-control" value="<?php echo $rank->post_needed; ?>" placeholder="Нужни постове">
                            </div>

                            <button type="submit" name="update_post" class="btn btn-primary btn-sm">Редактиране</button>
                        </div>
                    </form>
                    <a class="btn btn-danger btn-sm mt-5" href="admin.php?page=lyrics_ranking.php">Отказвам се от редактиране</a>
                </div>
            </div>
			<?php
		}
		?>


        <div class="row mt-2 py-3">
            <a href="admin.php?page=lyrics_ranking_add.php" class="btn btn-success btn-sm mb-2">Добави ранг</a>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ранг име</th>
                    <th scope="col">Брой нужни точки</th>
                    <th scope="col">Изображение</th>
                    <th scope="col">Действия</th>
                </tr>
                </thead>
                <tbody>
				<?php foreach ( $ranks as $rank ) { ?>
                    <tr>
                        <th scope="row"><?php echo $rank->id; ?></th>
                        <td><?php echo $rank->rank_title; ?></td>
                        <td><?php echo $rank->post_needed; ?></td>
                        <td><img src="<?php echo $rank->image_url; ?>" width="64px;" height="64px;"></td>
                        <td>
                            <a class="btn btn-primary btn-sm"
                               href="<?php echo esc_url( add_query_arg( array( 'editmode' => $rank->id ) ) ); ?>">Редактирай</a>
                            <a class="btn btn-danger btn-sm"
                               href="<?php echo esc_url( remove_query_arg('editmode',add_query_arg( array( 'delete_rank' => $rank->id )) ) ); ?>">Изтрий</a>
                        </td>
                    </tr>
				<?php } ?>
                </tbody>
            </table>

        </div>
    </div>
</div>