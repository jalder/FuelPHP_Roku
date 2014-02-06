<html>
<head>
</head>
<body>
<form method="post" action="/roku/index/channel">
<select name="channel">
<?php foreach($channels as $app_id => $ch) : ?>
<option value="<?php echo $app_id; ?>"><?php echo $ch; ?></option>
<?php endforeach; ?>
</select>
<input type="submit" name="launch_channel" value="Launch" />
</form>

<form method="post" action="#">
<input type="text" name="url" value="" />
<input type="hidden" name="launch" value="true" />
<input type="submit" value="Launch" />
</form>


<div class="remote">

<script type="text/javascript">
$(document).ready(function(){
	$('.remote button').click(function(){
		var button = $(this).attr('class');
		//alert(button);
		$.get('/roku/index/keypress?button='+button);
	});
});
</script>

<div class="containerr">
	<div class="row">
		<div class="col-sm-5"></div>
		<div class="col-sm-1"><button class="back">Back</button></div>
		<div class="col-sm-1"></div>
		<div class="col-sm-1"><button class="home">Home</button></div>
		<div class="col-sm-4"></div>
	</div>
	<div class="row">
		<div class="col-sm-6"></div><div class="col-sm-1"><button class="up">Up</button></div><div class="col-sm-5"></div>
	</div>
	<div class="row">
		<div class="col-sm-5"></div>
		<div class="col-sm-1"><button class="left">Left</button></div>
		<div class="col-sm-1"></div>
		<div class="col-sm-1"><button class="right">Right</button></div>
		<div class="col-sm-4"></div>
	</div>
	<div class="row">
		<div class="col-sm-6"></div>
		<div class="col-sm-1"><button class="down">Down</button></div>
		<div class="col-sm-5"></div>
	</div>
	<div class="row">
		<div class="col-sm-5"></div>
		<div class="col-sm-1"><button class="return">Return</button></div>
		<div class="col-sm-1"><button class="select">Ok</button></div>
		<div class="col-sm-1"><button class="options">Option</button></div>
		<div class="col-sm-4"></div>
	</div>
	<div class="row">
		<div class="col-sm-5"></div>
		<div class="col-sm-1"><button class="rewind">Rewind</button></div>
		<div class="col-sm-1"><button class="play">Play</button></div>
		<div class="col-sm-1"><button class="fforward">Forward</button></div>
		<div class="col-sm-4"></div>
	</div>
</div>

<!--
<button class="search">Search</button>
<button class="play">Play/Pause</button>
<button class="rewind">Rewind</button>
<button class="fforward">Forward</button>
<button class="back">Back</button>
<button class="home">Home</button>
<button class="select">Select</button>
<button class="up">Up</button>
<button class="down">Down</button>
<button class="left">Left</button>
<button class="right">Right</button>
-->
<form method="post" action="/roku/index/search">
<input type="text" name="query" value="" /><input type="submit" value="Search" />
</form>
</div>


</body>
</html>
