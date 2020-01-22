<?php include('template/header.php'); ?>
<div class="container mt-4">
<div class="alert alert-primary no-border">
	<p class="mb-0"><i class="fa fa-flag"></i> Welcome.</p>
</div>
<div class="card text-muted bg-outline-primary" style="padding: 15px;">
  <div class="card-body text-center">
  	<h1 style="font-weight:100;font-style:normal;"><?= $app['name'];?></h1>
  	<label class="lead">Sharing Google Drive files has been this easy!</label>
  </div>
</div><br/>
    <div class="row">
        <div class="col-md-6">
            <div class="blockquote-box blockquote-primary clearfix">
                <div class="square pull-left">
                    <span class="fa fa-user fa-3x"></span>
                </div>
                <h5 class="lead">Users</h5>
                <strong class="lead counter" data-count="0" id="t-user">loading..</strong>
            </div>
            <div class="blockquote-box blockquote-success clearfix">
                <div class="square pull-left">
                    <span class="fa fa-file fa-3x"></span>
                </div>
                <h5 class="lead">Files</h5>
                <strong class="lead counter" data-count="0" id="t-files">loading..</strong>
            </div>
        </div>
        <div class="col-md-6">
            <div class="blockquote-box blockquote-info clearfix">
                <div class="square pull-left">
                    <span class="fa fa-hdd-o fa-3x"></span>
                </div>
                <h5 class="lead">Space Used</h5>
                <strong class="lead" id="t-space">loading..</strong>
            </div>
            <div class="blockquote-box blockquote-danger clearfix">
                <div class="square pull-left">
                    <span class="fa fa-download fa-3x"></span>
                </div>
                <h5 class="lead">Downloads</h5>
                <strong class="lead counter" data-count="0" id="t-dls">loading..</strong>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
setTimeout(getStatistic,2000);
function getStatistic() {
	var options={useEasing:true,useGrouping:true,separator:',',decimal:'.'};
	$.getJSON("/statistic", function(d){
		$('#t-user').attr('data-count',d.users);$('#t-files').attr('data-count',d.files);
		$('#t-space').text(d.space);$('#t-dls').attr('data-count',d.downloads);
		$('.counter').each(function(){
		  var $this=$(this),countTo=$this.attr('data-count'),
		  cUp=new CountUp(this,0,countTo,0,2.0,options);
		  if(!cUp.error)cUp.start();
		});
	});
}
</script>
<?php include('template/footer.php'); ?>