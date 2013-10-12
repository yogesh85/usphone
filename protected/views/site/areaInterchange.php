<div class="BPcoreContainer" style="width:100%">
	<?php $this->breadcrumbs=array('Area Code ('.$this->areaCode.')'=>(new Clicky)->areaCodeUrl($this->areaCode), $params['{city}']." ({$this->areaCode})-{$this->areaInterchange}"); ?>
	<h1><?php echo Yii::t("custom", "areaInterchange.title", $params)?></i></h1>
	<div class="th1"><?php echo Yii::t("custom", "areaInterchange.header1", $params)?></div>
	<div class="tb1">
		
City : <?php echo $params['{city}']?><br>
State : <?php echo $params['{state}']?>  (<?php echo $params['{state_code}']?>)<br>
county : <?php echo $params['{county}']?><br>
<div>Time Zone: 
		<?php
		$tz_arr = explode(",", $this->time_zone);
		foreach($tz_arr as $key=>$val) {			
			echo ($key == count($tz_arr) - 1) ? $val : $val." / ";
		}
		?>
		</div>
		
		<div>The current time and date right now in <?php echo $params['{city}'].", ".$this->stateCode?> is 
		<?php
		foreach($tz_arr as $key=>$val) {
			date_default_timezone_set("UTC");
			$tzparam = str_replace("UTC", "", $val);
			$tzdate = "<span style='color:#FF9900;font-size:24px;font-weight:bold'>".date("g:i a", strtotime("$tzparam hours"))."</span> ".date("l j'S F Y", strtotime("$tzparam hours"));			
			echo "<b>$tzdate</b>.";
			break;
		}
		?>
</div>		
Zip Codes : <?php echo implode(", ", $zip_codes); ?><br>
Network Service Provider Company : <?php echo $this->interchangeObj->company; ?><br>
Network Service Provider Company ID : <?php echo $this->interchangeObj->company_number; ?><br>
Other cities are <b><?php echo implode("</b>, <b>", $other_cities); ?></b><br>
Latitude : <?php echo $params['{lat}']?><br>
Longitude : <?php echo $params['{long}']?>
<b>Population Data</b><br>
<?php if(count($placePopulation)>0) {?>
Population of <b><?php echo $params['{city}']?></b> is 
<?php $count=0; foreach($placePopulation as $key=>$val) { echo (($count++) == count($placePopulation) - 1) ? "$val in $key." : "$val in $key, "; } ?>
<?php } ?>

	</div>
	
	
	<?php if(!empty($params['{lat}']) AND !empty($params['{long}'])) { ?>
	
	<div class="th1"><?php echo Yii::t("custom", "areaInterchange.header2", $params)?></div>
	<div class="tb1">
		<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBAjGEd30kn_KcA2U5bu7PcwKZWzL4wrbE&sensor=false"></script>
		
<script>
	var myCenter=new google.maps.LatLng(<?php echo $this->lat?>, <?php echo $this->long?>);
	function initialize() {
		var map = new google.maps.Map(document.getElementById("googleMap"), {center:myCenter,mapTypeId: google.maps.MapTypeId.ROADMAP,streetViewControl: false,zoom:5});
		var markers = [<?php foreach($map as $val) echo "{lat : {$val['lat']}, lng: {$val['long']}, city:  \"{$val['name']}\"}, ";?> {lat: <?php echo $this->lat?>,lng: <?php echo $this->long?>,city: "<?php echo $params['{city}']?>"}];
		for (index in markers) addMarker(markers[index]);
		function addMarker(data) {
			var marker = new google.maps.Marker({position: new google.maps.LatLng(data.lat, data.lng),map: map,title: data.name});
			var infowindow = new google.maps.InfoWindow({content: data.city});
			google.maps.event.addListener(marker, "click", function() {	infowindow.open(map, marker);});
			google.maps.event.addListenerOnce(infowindow, "domready", function() {
				var panorama = new google.maps.StreetViewPanorama(streetview, {navigationControl: false,enableCloseButton: false,addressControl: false,linksControl: false,visible: true,position: marker.getPosition()});
			});
		}
		var bounds = new google.maps.LatLngBounds();
		for (index in markers) {
			var data = markers[index];
			bounds.extend(new google.maps.LatLng(data.lat, data.lng));
		}
		map.fitBounds(bounds);
	}
		
google.maps.event.addDomListener(window, 'load', initialize);

</script>
		<div id="googleMap" style="border: 2px solid #2F809B;border-radius: 14px 14px 14px 14px;height: 380px;margin: auto 5px;overflow: hidden;position: relative;width: 919px;"></div>
	</div>
	
	<?php } ?>
	
	
	
	<div class="th1"><?php echo Yii::t("custom", "areaInterchange.header4", $params)?></div>
	<div class="tb1">
		<?php foreach($this->comments as $comment) { ?>
		<div><a class='b' title='<?php echo $comment['phone_number']; ?>' href='<?php echo (new Clicky)->areaInterchangeUrl($comment['area_code'], $comment['area_interchange_code'])?>'>(<?php echo $comment['area_code']?>) <?php echo $comment['area_interchange_code']."-".substr($comment['phone_number'], -3)?></a><span class='rt date'><?php echo date("j'S F Y \a\\t g:i a", strtotime($comment['timestamp']))?></span></div>
		<div class='text'><?php echo $comment['comment']; ?></div>
	<?php } if(count($this->comments) == 0) { echo "<div class='text'>No Review Available for ({$this->areaCode}){$this->areaInterchange}-XXXX</div>"; }?>
	</div>
	
	<div class="th1"><?php echo Yii::t("custom", "areaInterchange.header5", $params)?></div>
	<div class="tb1" style="clear:both;height:25px;">
		<?php
		$previous_interchange = (new Clicky)->previousInterchangeUrl($this->areaCode, $this->areaInterchange);
		$next_interchange = (new Clicky)->nextInterchangeUrl($this->areaCode, $this->areaInterchange);
		?>
		<?php if(!empty($previous_interchange['interchange'])) {?>
		<span style="float:left;margin-left:10px;">Previous <a href="<?php echo $previous_interchange['url']?>">(<?php echo $this->areaCode?>)-<?php echo $previous_interchange['interchange']?>-XXXX</a></span>
		<?php } if(!empty($next_interchange['interchange'])) {?>
		<span style="float:right;margin-right:10px;"> <a href="<?php echo $next_interchange['url']?>">(<?php echo $this->areaCode?>)-<?php echo $next_interchange['interchange']?>-XXXX</a> Next</span>
		<?php } ?>
	</div>
	<div class="tb1">
		<?php 
		for($i=0;$i<1000;$i++) {
			$numbersData[] = str_pad($i, 4, "0", STR_PAD_LEFT);
		}
		$this->SEOshuffle($numbersData);
		foreach($numbersData as $number) {
			echo "<span class='nmbr'>({$this->areaCode})-{$this->areaInterchange}-$number</span>";
		}
		?>
	</div>
	
	<div class="th1"><?php echo Yii::t("custom", "homepage.header2")?></div>
	<div class="tb1">
	<?php foreach($this->recently_searched_number as $number) { ?>
		<?php
		$temp = explode("-", $number); 
		?>
		<div class="trc1"><a class="b" href="<?php echo (new Clicky)->areaInterchangeUrl($temp[0], $temp[1])?>">(<?php echo $temp[0]?>) <?php echo $temp[1]."-".$temp[2]?></a></div>
	<?php } ?>
	</div>
	<div id="BPcore_nonad">
		<div id="listingdiv0" class="bpListingInfo">
			<div id="coreBizName_nonad">
			</div>
		</div>									
	</div>
</div>
