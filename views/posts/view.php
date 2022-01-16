<?php

if (!isset($_GET['slug'])) {
	# code...
	throw new Exception('404');
}

$q = $db->prepare('SELECT * FROM posts WHERE slug = :slug');
$q->execute(['slug' => $_GET['slug']]);
$post = $q->fetch();

if (!$post) {
	# code...
	throw new Exception('404');
}

?>

<h3><?= $post->title; ?></h3>

<p>
	<?= $post->content; ?>
</p>

<?php
use Mablox\Plugin\Comments;
$comment_cls = new Comments($db);
$comments = $comment_cls->findAll('posts', $post->id);
?>

<h2><?= count($comments); ?> Commentaires</h2>

<?php foreach($comments as $comment): ?>
	<div class="comment row">
		<div class="col-sm-2">
			<img src="http://www.gravatar.com/avatar/<= md5($comment->email); ?>" width="100">
		</div>
		<div class="col-sm-10">
			<p>
				<strong><?= $comment->username; ?></strong>,
			    <em><?= date('d/m/Y', strtotime($comment->created)); ?></em>
			</p>
			<p>
			    <?= $comment->content; ?>
			</p>
		</div>
	</div>
<?php endforeach; ?>