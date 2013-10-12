<?php
$dom = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$dom_arr = explode("/", str_replace(array("http://", "https://", "www."), "", $dom));
if(strpos($dom_arr[0], ".") == 0) {
	$domain_parse = "$dom_arr[0]/$dom_arr[1]";
	$full_domain_parse = "$dom_arr[0]/$dom_arr[1]";
} else {
	$domain_parse = $dom_arr[0];
	$full_domain_parse = "www.".$dom_arr[0];
}

return  array (
    "site.domain" => $domain_parse,
    "site.url" => "http://$full_domain_parse",
    "site.searchform" => "<b>Search cell phones and landlines numbers owners.</b> Results give you name, address, and more.",
    "homepage.titletag" => "Reverse Phone Number Lookup | USA Reverse Phone Lookup",
    "homepage.descriptiontag" => "Get details on most American phone numbers with our reverse phone look-up service. Find out unknown caller's name, address and more.",
    "homepage.keyword" => "North American Area Code Directory, North American Phone Search",
    "homepage.title" => "Welcome to $domain_parse",
    "homepage.header1" => "Comments",
    "homepage.header2" => "Most Recently Searched Numbers",
    "homepage.header3" => "Number Searched for Today",
    "homepage.header4" => "Area Code List {digit}00 - {digit}99",
    "homepage.header5" => "Most Recently Searched Number for City",
    
    "areaCode.titletag" => "Reverse Phone Number Lookup | Area Code - {area_code}",
    "areaCode.descriptiontag" => "",
    "areaCode.keyword" => "North American Area Code Directory, North American Phone Search",
    "areaCode.title" => "Area Code details of {area_code}",
    "areaCode.header1" => "Area Code details of {area_code}",
    "areaCode.header2" => "Area Code Map for {area_code}",
    "areaCode.header3" => "Comments for Area Code {area_code}",
    "areaCode.header3" => "Area Interchange Information for Area Code {area_code} in state (state_code)",
    "areaCode.header4" => "Comments for Area Area Code {area_code}",
    "areaCode.header5" => "News Feed for {state} (state_code)",
    
    "areaInterchange.titletag" => "News Feed for {state} (state_code)",
    "areaInterchange.descriptiontag" => "News Feed for state (state_code)",
    "areaInterchange.keyword" => "North American Area Code Directory, North American Phone Search",
    "areaInterchange.title" => "Area Interchange Information for ({area_code}) -{area_interchange}",
    "areaInterchange.header1" => "Interchange details",
    "areaInterchange.header2" => "Interchange details for map",
    "areaInterchange.header3" => "Interchange details digit7 url",
    "areaInterchange.header4" => "Interchange details comments",
    "areaInterchange.header5" => "({area_code}) -{area_interchange}-XXXX {state} ({state_code}) Phone Number Results",
    
    "detail.titletag" => "({area_code}){area_interchange}-{digit4} Phone Results",
    "detail.descriptiontag" => "({area_code}){area_interchange}-{digit4} Phone Results",
    "detail.keyword" => "",
    "detail.title" => "Entire Report for ({area_code}){area_interchange}-{digit4} Start Download!",
    "detail.header1" => "Commnent for ({area_code}){area_interchange}-{digit4}",
    "detail.header2" => "Leave a Comment for ({area_code}){area_interchange}-{digit4}",
    
    "checkout.titletag" => "({area_code}){area_interchange}-{digit4} Checkout",
    "checkout.descriptiontag" => "({area_code}){area_interchange}-{digit4} Checkout",
    "checkout.keyword" => "",
    "checkout.title" => " ",
    
    "area_code_list.titletag" => "List of area Codes",
    "area_code_list.descriptiontag" => "",
    "area_code_list.keyword" => "",
    "area_code_list.title" => "North American Area Code List",
);

?>
