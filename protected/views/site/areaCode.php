
<div class="BPcoreContainer" style="width:100%">
	<?php	
	$this->widget('zii.widgets.CBreadcrumbs', array(
		'homeLink'=>CHtml::link('Home', Yii::t("custom", "site.url")),
		'links'=>array( Yii::t("custom", "areaCode.breadcrumb", $params)),
	));
	?>
	<h1><?php echo Yii::t("custom", "areaCode.title", $params)?></i></h1>
	<div class="th1"><?php echo Yii::t("custom", "areaCode.header1", $params)?></div>
	<div class="tb1">
	<?php 
		$county_obj = County::model()->findAll("state='{$this->stateCode}'");
		$place_obj = Places::model()->findAll("state='{$this->stateCode}' AND status like 'city'");
		$county_arr = array();
		foreach($county_obj as $county) { 
			$county_arr[] = array(
				"name" => $county->county,
				"fips_code" => $county->county_fips_code,
				"population" => unserialize($county->population),
				"OMB_CBSA_code" => $county->OMB_CBSA_code,
				"OMB_CSA_code" => $county->OMB_CSA_code,
				"BEA_EA_code" => $county->BEA_EA_code,
				"BEA_CEA_code" => $county->BEA_CEA_code,
			); 
		}	
		$place_arr = array();
		foreach($place_obj as $place) { 
			$place_arr[] = array(
				"name" => $place->name,
				"county" => $place->county,
				"population" => unserialize($place->population),
				"status" => $place->status,
			); 
		}
	?>
	<table class="intrdtl">
		<tr><td>State</td><td><?php echo $this->state." (".$this->stateCode.")"?></td></tr>
		<tr><td>Capital of <?php echo $this->state?></td><td><?php echo $stateInfo->capital?></td></tr>
		<tr><td>Time Zone</td><td><?php $tz_arr = explode(",", $this->time_zone); foreach($tz_arr as $key=>$val) echo ($key == count($tz_arr) - 1) ? $val : $val." / ";?></td></tr>
		<tr>
			<td>Current Time in <?php echo $this->state?></td>
			<td>
				<?php
				foreach($tz_arr as $key=>$val) {
					date_default_timezone_set("UTC");
					$tzparam = str_replace("UTC", "", $val);
					$tzdate = "<span style='color:#FF9900;font-size:28px;font-weight:bold'>".date("g:i a", strtotime("$tzparam hours"))."</span> ".date("l j'S F Y", strtotime("$tzparam hours"));			
					echo "$tzdate.";
					break;
				}
				?>				
			</td>
		</tr>
		<tr>
			<td>Geo Coordinates</td>
			<td>Latitude: <?php echo $this->lat;?> Longitude: <?php echo $this->long;?></td>
		</tr>
		<tr>
			<td>County List in Area Code<?php echo $this->areaCode;?></td>
			<td>
				<?php foreach($county_arr as $key=>$val) if($key == count($county_arr) - 1) echo $val['name']."."; else echo $val['name'].", ";?>
			</td>
		</tr>
		<?php if(count($place_arr)) { ?>
		<tr>
			<td>Cities in Area Code <?php echo $this->areaCode;?></td>
			<td><?php foreach($place_arr as $key=>$val) if($key == count($place_arr) - 1) echo $val['name']."."; else echo $val['name'].", "; ?></td>
		</tr>
		<?php } ?>
		<?php $pop = unserialize($stateInfo->population); ksort($pop); ?>
		<tr><td>Population of <?php echo $this->state?></td><td><?php echo $pop[max(array_keys($pop))];?></td></tr>
		<tr><td>Area of <?php echo $this->state?></td><td><?php echo $stateInfo->area_total?> km<sup>2</sup></td></tr>
		<tr><td>Land Area of <?php echo $this->state?></td><td><?php echo $stateInfo->area_land;?> km<sup>2</sup></td></tr>
		<tr><td>Wate Area of <?php echo $this->state?></td><td><?php echo $stateInfo->area_water;?> km<sup>2</sup></td></tr>
		<tr>
			<td>Other Area Codes in <?php echo $this->state?></td>
			<td><?php foreach($other_area_codes as $key=>$val) if($key < count($other_area_codes) - 1) echo "<a href='".(new Clicky)->areaCodeUrl($val)."'>$val</a>, "; else echo "<a href='".(new Clicky)->areaCodeUrl($val)."'>$val</a>"; ?></td>
		</tr>
	</table>
		
	</div>
	
	<?php if(!empty($this->lat) AND !empty($this->long)) { ?>
	
	<div class="th1"><?php echo Yii::t("custom", "areaCode.header2", $params)?></div>
	<div class="tb1">
		<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBAjGEd30kn_KcA2U5bu7PcwKZWzL4wrbE&sensor=false"></script>
		
<script>
var myCenter=new google.maps.LatLng(<?php echo $this->lat?>, <?php echo $this->long?>);
function initialize() {
	var mapProp = { center:myCenter, zoom:6, mapTypeId:google.maps.MapTypeId.ROADMAP };
	var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
	var marker=new google.maps.Marker({ position:myCenter, });
	marker.setMap(map);
	var infowindow = new google.maps.InfoWindow({ content:"<?php echo "State Name: <b>" . $this->state . "</b><br>State Code: <b>" . $this->stateCode."</b>"?>" });
	google.maps.event.addListener(marker, 'click', function() { infowindow.open(map,marker); });
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
		<div id="googleMap" style="border: 2px solid #2F809B;border-radius: 14px 14px 14px 14px;height: 380px;margin: auto 5px;overflow: hidden;position: relative;width: 919px;"></div>
	</div>
	
	<?php } ?>
	
	<div class="th1"><?php echo Yii::t("custom", "areaCode.header3", $params)?></div>
	<div class="tb1" style="clear:both;height:25px;">
		<?php
		$previous_area_code = (new Clicky)->previousAreaCodeUrl($this->areaCode);
		$next_area_code = (new Clicky)->nextAreaCodeUrl($this->areaCode);		
		?>
		<?php if(!empty($previous_area_code['area_code'])) {?>
		<span style="float:left;margin-left:10px;">Previous Area Code <a href="<?php echo $previous_area_code['url']?>"> (<?php echo $previous_area_code['area_code']?>)XXX-XXXX</a></span>
		<?php } if(!empty($next_area_code['area_code'])) {?>
		<span style="float:right;margin-right:10px;"><a href="<?php echo $next_area_code['url']?>"> (<?php echo $next_area_code['area_code']?>)XXX-XXXX</a> Next Area Code</span>
		<?php } ?>
	</div>
	<div class="tb1">
		<table class="intr">
			<tr>
				<th width="10%">Interchange</th>
				<th width="8%">Company Number</th>
				<th width="29%">Company</th>
				<th width="10%">Status</th>
				<th width="9%">Usage</th>
				<th width="10%">Launched</th>
				<th width="12%">Region</th>
				<th width="12%">County</th>
			</tr>		
		<?php $count = 0; foreach($this->interchangeObj as $interchange) { ?>
			<tr style="background:<?php echo (($count++ % 2) == 1) ? "#E6E6E6" : "#F6F6F6"; ?>;">
				<td><?php echo "<a href='".(new Clicky)->areaInterchangeUrl($interchange->area_code, $interchange->area_interchange)."'>{$interchange->area_code}-{$interchange->area_interchange}</a>"?></td>
				<td><?php echo (empty($interchange->company_number)) ? "NA" : $interchange->company_number?></td>
				<td><?php echo (empty($interchange->company)) ? "NA" : $interchange->company?></td>
				<td><?php echo (empty($interchange->status)) ? "NA" : $interchange->status?></td>
				<td><?php echo (empty($interchange->usage)) ? "NA" : $interchange->usage?></td>
				<td><?php echo (empty($interchange->introduced)) ? "NA" : date("d M Y", strtotime($interchange->introduced))?></td>
				<td><?php echo (empty($interchange->region)) ? "NA" : $interchange->region?></td>
				<td><?php echo (empty($interchange->county)) ? "NA" : $interchange->county?></td>
			</tr>
		<?php }	?>
		</table>
		
	</div>
	
	<div class="th1"><?php echo Yii::t("custom", "areaCode.header4", $params)?></div>
	<div class="tb1">
		<?php foreach($this->comments as $comment) { ?>
		<div><a class='b' title='<?php echo $comment['phone_number']; ?>' href='<?php echo (new Clicky)->areaInterchangeUrl($comment['area_code'], $comment['area_interchange_code'])?>'>(<?php echo $comment['area_code']?>) <?php echo $comment['area_interchange_code']."-".substr($comment['phone_number'], -4)?></a><span class='rt date'><?php echo date("j'S F Y \a\\t g:i a", strtotime($comment['timestamp']))?></span></div>
		<div class='text'><?php echo $comment['comment']; ?></div>
	<?php } ?>
	</div>
	
	<div id="BPcore_nonad">
		<div id="listingdiv0" class="bpListingInfo">
			<div id="coreBizName_nonad">
			</div>
		</div>									
	</div>
</div>
