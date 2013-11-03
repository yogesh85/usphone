<?php //$this->breadcrumbs=array('Tracing Page'); ?>
<script type="text/javascript">
function processNext() {
	document.location = "<?php echo Clicky::checkoutUrl($area_code, $area_interchange, $digit4);?>";
}

</script>
<script src="<?php echo Yii::t("custom", "site.url");?>/js/jquery.min.js"></script>
<script>
$(document).ready(function(){
	$("#sbmt").click(function(){
		$("#comment_msg").html("");
		$("#comment_msg").css("color", "#64BCF7");
		$.post("<?php echo Yii::t("custom", "site.url")?>/comment/add/<?php echo $area_code."-".$area_interchange."-".$digit4?>",
			{ user_name:$("#usrnm").val(), comment:$("#comment_txt").val() },
			function(data,status) {
				var obj;
				if(data.charAt(0) == "[") obj = eval(data); 
				else obj = eval('['+data+']');
				if(obj[0]['result'] && obj[0]['result'] == "error") $("#comment_msg").css("color", "#B24F48");
				if(obj[0]['message']) $("#comment_msg").html(obj[0]['message']);

			}
		);
	});
});
</script>

<div class="BPcoreContainer" style="width:100%">
	
	<h1><?php echo $this->title; ?></h1>
	
	<table width="100%" style="margin-top: 20px;">
		<tr>
			<td width="45%" align="center">
				<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBAjGEd30kn_KcA2U5bu7PcwKZWzL4wrbE&sensor=false"></script>
		
		 
<script>
var myCenter=new google.maps.LatLng(<?php echo $latitude;?>, <?php echo $longitude;?>);
function initialize() {
	var mapProp = { center:myCenter, zoom:9, mapTypeId:google.maps.MapTypeId.ROADMAP };
	var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
	var marker=new google.maps.Marker({ position:myCenter, });	
	marker.setMap(map);
	
	var infowindow = new google.maps.InfoWindow({ content:"<b><?php echo $area_code."-".$area_interchange."-".$digit4?></b><br>Owner Name: <a onclick='processNext();' class=\"ta2\">Click Here</a><br><?php if(!empty($usage)) echo "Line Type: $usage<br>";?><?php if(!empty($region)) echo "Location: $region, $state_code<br>";?>" });
	google.maps.event.addListener(marker, 'click', function() { infowindow.open(map,marker); });
	google.maps.event.trigger( marker, 'click' );
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
				<div id="googleMap" style="border: 2px solid #2F809B;border-radius: 14px 14px 14px 14px;height: 380px;margin: auto 3px;overflow: hidden;position: relative;width: 95%;"></div>
			</td>			
			<td width="55%" align="left" valign="top">
				<div class="trccnt">
					<table>
						<tr><td width="25%">Owner Name:</td><td width="75%"><a onclick="processNext();" class="ta1">Click Here</a></td></tr>
						<tr><td>Address:</td><td><a onclick="processNext();" class="ta2">Click Here</a></td></tr>
						<tr><td>State:</td><td><?php echo (!empty($state)) ? $state."($state_code)" : "NA";?></td></tr>
						<tr><td>County:</td><td><?php echo (!empty($county)) ? $county : "NA"?></td></tr>
						<tr><td>Region:</td><td><?php echo (!empty($region)) ? $region : "NA"?></td></tr>
						<tr><td>Company:</td><td><?php echo (!empty($company)) ? $company : "NA"?></td></tr>
						<tr><td>Line Type:</td><td><?php echo (!empty($usage)) ? $usage : "NA"?></td></tr>
						<tr><td>Status:</td><td><?php echo (!empty($status)) ? $status : "NA"?></td></tr>
						<tr><td>Introduced:</td><td><?php echo (!empty($introduced)) ? date("j'S F Y", strtotime($introduced)) : "NA"?></td></tr>	
					</table>
					<span onclick="processNext();" class="ta3">View Full Results</span>
				</div>
			</td>
		</tr>
	</table>
	
	<div class="trcsm1">
		Full results include name of owner, address of owner, contact information, housing information, people search results and more.
		Some numbers contact information is not available. In that case you will get credit.All data offered comes from public sources.
	</div>
	<div class="trcsm2">
		<b>This information can not be access publically free. Your purchase is 100% legal and discreet.You can download your report as soon as your payment is received.</b>
	</div>
	
	<div class="th1"><?php echo Yii::t("custom", "detail.header1", array(
		'{area_code}' => $area_code,
		'{area_interchange}' => $area_interchange,
		'{digit4}' => $digit4,
	))?></div>
	<div class="tb1">
		<?php if(count($comments) == 0) echo "No Comment is available. !!!" ?>
	<?php foreach($comments as $comment) { ?>		
		<div class='text'><?php echo $comment['comment']; ?></div>
	<?php } ?>
	</div>
	
	<div class="th1"><?php echo Yii::t("custom", "detail.header2", array(
		'{area_code}' => $area_code,
		'{area_interchange}' => $area_interchange,
		'{digit4}' => $digit4,
	))?></div>
	<div class="tb1">
		<form action="#" method="POST">			
			<textarea name="comment" id="comment_txt" placeholder="Share your review about phone number <?php echo $area_code."-".$area_interchange."-".$digit4?>. (at least 20 characters.)"></textarea>
			<input type="text" name="user_name" placeholder="User Name" id="usrnm"/>
			<input type="button" name="submit" value="Add Comment" id="sbmt"/>
			<span id="comment_msg"></span>
		</form>
	</div>
<style>
#comment_msg {
	font-size: 15px;
    margin-left: 5px;
}
#usrnm {
	background: none repeat scroll 0 0 #F8F8F8;
    border: 1px solid #CCCCCC;
    border-radius: 12px 12px 12px 12px;
    display:block;
    font-family: Lucida Grande;
    font-size: 17px;
    height: 27px;
    margin: 6px 12px;
    padding: 2px 5px;
    resize: vertical;
    width: 25%;
}
#sbmt {
	background: none repeat scroll 0 0 #64BCF7;
    border: 1px solid #CCCCCC;
    border-radius: 12px 12px 12px 12px;
    color: #FAFAFA;
    cursor:pointer;
    display: inline-block;
    font-family: dsfsfs;
    font-size: 17px;
    font-weight: bold;
    height: 29px;
    margin: 6px 12px;
    padding: 2px 11px;
    resize: vertical;
    width: auto;
}
#comment_txt {
	background: none repeat scroll 0 0 #F8F8F8;
    border: 1px solid #CCCCCC;
    border-radius: 12px 12px 12px 12px;
    display:block;
    font-family: Lucida Grande;
    font-size: 17px;
    height: 152px;
    margin: 6px 12px;
    padding: 2px 5px;
    resize: vertical;
    width: 60%;
}
a {
	cursor:pointer;
}
div.trccnt { background:#F6F6F6;font-family: Lucida Grande;font-size: 17px;height: 100%;letter-spacing: 0.01em;word-spacing: 0.1em; }
.trccnt table { width:100%;height:100%; }
.trccnt table tr { min-height:6px; }
.trccnt table tr td { 
	border-bottom: 1px solid #B2D0FE;
    padding: 0 1px 6px 0; 
    vertical-align: top;
}
.trccnt table tr:last-child td {
	border-bottom:none;
}
a.ta1 { font-size:18px;font-weight:bold;text-decoration:underline; }
a.ta2 { font-size:15px;text-decoration:underline; } 
.ta3 { 
	background: none repeat scroll 0 0 #64BCF7;
    border: 2px solid #F7F7F7;
    border-radius: 13px 13px 13px 13px;
    color: #F7F7F7;
    cursor: pointer;
    display: inline-block;
    font-size: 23px;
    margin: 10px auto 5px 5px;
    padding: 2px 27px;
    text-align: center;
    text-decoration: none;
    width: 215px;
}
.ta3:hover {
	color:#2F5E8C;
	background:#FFE17A;
}
.trcsm1 {
	color: #9A7171;
    font-family: Comic Sans MS;
    font-size: 10px;
    margin: 14px 11px;
    word-spacing: 0.1em;
}
.trcsm2 {
	color: #9A7171;
    font-family: Comic Sans MS;
    font-size: 10px;
    margin: 14px 11px;
    word-spacing: 0.1em;
}
</style>
</div>
