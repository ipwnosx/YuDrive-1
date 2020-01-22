<?php include('template/header.php'); ?>
<?php get_token_file(); ?>
<?php
$file_id 	= $_REQUEST['id'];
$get_file 	= $YuuClass->get_file($file_id);
$filename 	= $get_file['file_name'];
$fileext  	= getFileExtension($filename);
$fileMIME   = $get_file['file_type'];
$filesize 	= filesize_formatted($get_file['file_size']);
$filedate 	= timeAgo($get_file['created_date']);
$filedls	= $get_file['downloads'];
?>
<?php if (!$get_file): changeTitle('File not Found', 'File was not found!'); ?>
<div class="container text-center" style="margin-top:50px;">
	<div class="alert alert-danger">
		<h4 class="fa fa-exclamation-triangle fa-4x" aria-hidden="true"></h4><br/>
		<label>The file you are trying to download is no longer available!</label>
	</div>
</div>
<?php goto liwat; else:
# -- Change Title
	$title = "$filename - $filesize";
	$desc = "Download $filename - $filesize";
	$icon = get_icon($fileext);
	changeTitle($title, $desc, $icon);
endif;
?>
<div class="container" style="margin-top: 40px;">
	<?php if(is_admin() || $get_file['file_owner_mail'] == @$_user['email']): ?>
		<a href="javascript:void(0)" title="Delete file" onclick="javascript:if(confirm('Are you sure want to delete?'))delFile('<?= $file_id; ?>', false, true)" class="btn btn-sm btn-outline-danger float-right"><i class="fa fa-trash"></i></a>
	<?php endif; ?>
	<div class="text-center" style="word-wrap: break-word;">
		<h4><img src="<?= $icon; ?>" height="40"><?= $filename; ?></h4>
		<p class="lead">(<?= $filesize; ?>)</p>
	<?php if(is_admin()) : ?>
		<p style="font-size: 10pt;" class="text-muted"><small>Uploaded by <?= "<b>$get_file[file_owner_mail]</b>";?></small></p>
	<?php endif; ?>
	</div>
	<hr/>
	<div id="btn-dl">
		<small class="float-right text-muted"><?= "$filedate | $filedls";?>x downloads</small>
		<a class="btn btn-primary btn-sm" data-toggle="collapse" href="#view" aria-expanded="false" aria-controls="view"><i class="fa fa-video-camera fa-fw"></i> Stream <i class="fa fa-chevron-down"></i></a>
	</div>
	<div class="py-3 text-center">
	<!-- ADS BANNER SCRIPT -->
		<script data-cfasync="false" type="text/javascript" src="//www.clearonclick.com/a/display.php?r=1852031"></script>
	<!-- / END ADS BANNER SCRIPT -->
	</div>
	<div class="collapse" id="view">
		<?php if($plugins['player'] && allow_video($fileMIME)) : ?>
		<div class="embed-responsive embed-responsive-16by9" style="border-radius:1px;">
			<iframe class="embed-responsive-item" src="/embed/<?= $file_id; ?>" scrolling="no" allowfullscreen="true"></iframe>
		</div>
		<?php elseif(!$plugins['player']): ?>
			<div class="alert alert-danger"><span>Video plugin was disabled by Admin</span></div>
		<?php else : ?>
			<div class="alert alert-danger"><span>We're sorry, the preview didn't load. This file type may not be supported</span></div>
		<?php endif; ?>
	</div>
	<div class="my-3 text-center">
		<a data-target="dl" href="#dl" onclick="dl(this)" class="btn btn-outline-primary round btn-lg"><i class="fa fa-cloud-download"></i> <strong>Download</strong> (<small><?= $filesize; ?></small>)</a>
<?php if($get_file['mirror_multiup']) : ?>
		<br/><br/>
		<button onclick="window.open('http://multiup.org/download/<?=$get_file['mirror_multiup'];?>')" class="btn btn-dark round btn-sm"><i class="fa fa-external-link"></i> <strong>Mirror (multiup)</strong></button>
<?php endif; ?>
	</div>
	<div class="py-3 text-right">
		<div class="fb-like" data-href="https://www.facebook.com/YuuDrive" data-layout="button_count" data-action="like" data-size="large" data-show-faces="true" data-share="true"></div>
	</div>
	<br/>
	<ul class="nav nav-tabs">
	  <li class="nav-item">
	    <a class="nav-link active" data-toggle="tab" href="#dlink"><i class="fa fa-download"></i> Link</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" data-toggle="tab" href="#htmlcode"><i class="fa fa-html5"></i> HTML Code</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" data-toggle="tab" href="#bbcode"><i class="fa fa-code-fork"></i> BB Code</a>
	  </li>
	  <?php if($plugins['player'] && allow_video($fileMIME)) : ?>
	  <li class="nav-item">
	    <a class="nav-link" data-toggle="tab" href="#embedvid"><i class="fa fa-youtube-play"></i> Embed Code</a>
	  </li>
	  <?php endif; ?>
	</ul>
	<div id="myTabContent" class="tab-content">
	  <div class="tab-pane fade in active show" id="dlink">
	    <input readonly onclick="copier(this)" class="form-control" value="<?= CURRENT_URL; ?>">
	  </div>
	  <div class="tab-pane fade" id="htmlcode">
	    <input readonly onclick="copier(this)" class="form-control" value='<?= htmlcode(CURRENT_URL, $filename.' - '.$filesize); ?>'>
	  </div>
	  <div class="tab-pane fade" id="bbcode">
	    <input readonly onclick="copier(this)" class="form-control" value='<?= bbcode(CURRENT_URL, $filename.' - '.$filesize); ?>'>
	  </div>
	  <?php if($plugins['player'] && allow_video($fileMIME)) : ?>
	  <div class="tab-pane fade" id="embedvid">
	    <input readonly onclick="copier(this)" class="form-control" value='<?= embedcode($file_id); ?>'>
	  </div>
	  <?php endif; ?>
	</div><br/>
	<div id="share-buttons" class="float-right">Share<div id="fb-root"></div>
    	<a onclick="popupwindow('https://www.facebook.com/sharer.php?u=<?= CURRENT_URL; ?>', 'Share FB');return false;" href="#"><img height="30" src="//simplesharebuttons.com/images/somacro/facebook.png" alt="Facebook"/></a>
    	<a onclick="popupwindow('https://plus.google.com/share?url=<?= CURRENT_URL; ?>', 'Share G+');return false" href="#" target="_blank"><img height="30" src="//simplesharebuttons.com/images/somacro/google.png" alt="Google+"/></a>
    </div>
</div>
<!--/-->
<script type="text/javascript">(function(a,b,c){var e,f=a.getElementsByTagName(b)[0];a.getElementById(c)||(e=a.createElement(b),e.id=c,e.src='https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12&appId=686664881396932&autoLogAppEvents=1',f.parentNode.insertBefore(e,f))})(document,'script','facebook-jssdk');var file_id='<?= $file_id; ?>';function popupwindow(a,b){var c=400,d=400,e=screen.width/2-c/2,f=screen.height/2-d/2;return window.open(a,b,'toolbar=no, location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no,width='+c+',height='+d+',top='+f+',left='+e)}

var dlUrl="/download?token=<?= $_SESSION['file_token'].'&id='.$file_id; ?>";
</script>

<script src="https://muhbayu.github.io/adBDetect/js/adbdetect.packed.js"></script>
<script type="text/javascript">
adBDetect().setup({
	wait:1000,
	setPage:'/page/ad-detect.html'
}).start();
</script>

<?php liwat: include('template/footer.php'); ?>