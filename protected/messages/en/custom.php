<?php
$dom = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$dom_arr = explode("/", str_replace(array("http://", "https://", "www."), "", $dom));
if(strpos($dom_arr[0], ".") == 0) {
	$domain_parse = "$dom_arr[0]/$dom_arr[1]";
	$full_domain_parse = "$dom_arr[0]/$dom_arr[1]";
	$domain_short = "$dom_arr[0]/$dom_arr[1]";
} else {
	$domain_parse = $dom_arr[0];
	$full_domain_parse = "www.".$dom_arr[0];
	$t = explode(".", $domain_parse);
	$domain_short = $t[0];
}

return  array (
    "site.domain.short" => $domain_short,
    "site.domain" => $domain_parse,
    "site.url" => "http://$full_domain_parse",
    "site.searchform" => "<b>Search cell phones and landlines numbers owners.</b> Results give you name, address, and more.",
    "homepage.titletag" => "Instant Phone Number Lookup in USA",
    "homepage.descriptiontag" => "Find Cell phone or landline user information.Name and Address of the owner.",
    "homepage.keyword" => "North American Area Code Directory, North American Phone Search",
    "homepage.title" => "North American Area Codes Directory",
    "homepage.header1" => "Comments",
    "homepage.header2" => "Most Recently Searched Numbers",
    "homepage.header3" => "Number Searched for Today",
    "homepage.header4" => "Area Code List {digit}00 - {digit}99",
    "homepage.header5" => "Most Recently Searched Number for City",
    "homepage.header6" => "Mostly Searched Numbers",
    
    "areaCode.titletag" => "Area Code {area_code}",
    "areaCode.descriptiontag" => "Got a call from area code {area_code} Find out who it is from {siteName}",
    "areaCode.keyword" => "North American Area Code Directory, North American Phone Search",
    "areaCode.title" => "Area Code {area_code} XXX Reverse Lookup Detail",
    "areaCode.header1" => "{area_code} is the Phone Area Code for the State of {state} ({state_code})",
    "areaCode.header2" => "({area_code}) Area Code Map in {state_code}",
    "areaCode.header3" => "Exchange Prefix {area_code}-{lowestAreaInterchange} - Exchange Prefix {area_code}-{largestAreaInterchange}",
    "areaCode.header4" => "Comments for Area Area Code {area_code}",
    "areaCode.header5" => "News Feed for {state} ({state_code})",
    "areaCode.breadcrumb" => "USA Area Codes {area_code}",
    
    "areaInterchange.titletag" => "Area & Exchange Code {area_code}-{area_interchange} -{city}, {state_code} - Free Reverse Phone Number Lookup",
    "areaInterchange.descriptiontag" => "Phone Area Code from {area_code}-{area_interchange} in {state}, {city}. Get Instant Results!",
    "areaInterchange.keyword" => "North American Area Code Directory, North American Phone Search",
    "areaInterchange.title" => "Area Interchange Information for ({area_code}) -{area_interchange}",
    "areaInterchange.header1" => "Free {area_code}-{area_interchange} Area Code Prefix information for {county}, {state}",
    "areaInterchange.header2" => "{area_code}-{area_interchange} Area Code/Exchange Map in {city}, {state_code}",
    "areaInterchange.header3" => "Interchange details {digit7} url",
    "areaInterchange.header4" => "Comments {area_code}-{area_interchange}-xxxx",
    "areaInterchange.header5" => "Phone Area Code List for ({area_code}) {area_interchange} Exchange",
    "areaInterchange.header6" => "Mostly Searched Numbers for ({area_code}) -{area_interchange}-XXXX {state} ({state_code})",
    "areaInterchange.areaCode.breadcrumb" => "Area Code {area_code}",
    "areaInterchange.breadcrumb" => "({area_code})-{area_interchange} {city}",
    
    "detail.titletag" => "{area_code}-{area_interchange}-{digit4} Phone Results",
    "detail.descriptiontag" => "{area_code}-{area_interchange}-{digit4} Phone Results",
    "detail.keyword" => "",
    "detail.title" => "Entire Report for ({area_code}){area_interchange}-{digit4} Start Download!",
    "detail.header1" => "Commnent for ({area_code}){area_interchange}-{digit4}",
    "detail.header2" => "Leave a Comment for ({area_code}){area_interchange}-{digit4}",
    
    "checkout.titletag" => "{area_code}-{area_interchange}-{digit4} Checkout",
    "checkout.descriptiontag" => "{area_code}-{area_interchange}-{digit4} Checkout",
    "checkout.keyword" => "",
    "checkout.title" => " ",
    
    "area_code_list.titletag" => "Area Codes Directory | North American Area Code Directory",
    "area_code_list.descriptiontag" => "A complete list of telephone Area Codes has been given. Click on a code to get its details.",
    "area_code_list.keyword" => "",
    "area_code_list.title" => "USA Area Codes",
    
    "privacy.title" => "USA Phone Number Lookup - Privacy Policy",
);

?>
