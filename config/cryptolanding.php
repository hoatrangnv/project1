<?php

return [
	'usd_bonus_pay' => 0.6,
	'reinvest_bonus_pay' => 0.4,
	'bonus_maxout' => 35000, //Binary bonus cannot over $35000
	
	'bonus_f1_pay' => 0.1,
	'bonus_f2_pay' => 0.02,
	'bonus_f3_pay' => 0.01,
	
	'binary_bonus_1_pay' => 0.05,
	'binary_bonus_2_pay' => 0.06,
	'binary_bonus_3_pay' => 0.07,
	'binary_bonus_4_pay' => 0.08,
	'binary_bonus_5_pay' => 0.09,
	'binary_bonus_6_pay' => 0.1,
	
	'loyalty_upgrate_silver' => 50000,
	
	'loyalty_silver_amount' => 5000,
	'loyalty_gold_amount' => 10000,
	'loyalty_pear_amount' => 20000,
	'loyalty_emerald_amount' => 50000,
	'loyalty_diamond_amount' => 100000,

    'wallet_type' => array(
        1 => 'adminlte_lang::wallet.fast_start_type',
        2 => 'adminlte_lang::wallet.interest',
        3 => 'adminlte_lang::wallet.binary',
        4 => 'adminlte_lang::wallet.loyalty',
        5 => 'adminlte_lang::wallet.usd_clp_type',
        6 => 'adminlte_lang::wallet.reinvest_clp_type', //holding wallet to clp wallet
        7 => 'adminlte_lang::wallet.btc_clp_type',
        8 => 'adminlte_lang::wallet.clp_btc_type',
        9 => 'adminlte_lang::wallet.withdraw_btc_type',
        10 => 'adminlte_lang::wallet.withdraw_clp_type',
        11 => 'adminlte_lang::wallet.transfer_btc_type',
        12 => 'adminlte_lang::wallet.transfer_clp_type', //REMOVE
        13 => 'adminlte_lang::wallet.deposit_btc_type',
        14 => 'adminlte_lang::wallet.deposit_clp_type',
        15 => 'adminlte_lang::wallet.buy_pack',
        16 => 'adminlte_lang::wallet.tl_withdraw_pack',
        17 => 'adminlte_lang::wallet.tl_matching_amount',
    ),

    'loyalty_bonus' => array('silver' => 5000, 'gold' => 10000, 'pear' => 20000, 'emerald' => 50000, 'diamond' => 100000),

    'lstCountry' => array("4" => "Afghanistan","248" => "Aland Islands","8" => "Albania","12" => "Algeria","16" => "American Samoa","20" => "Andorra","24" => "Angola","660" => "Anguilla","10" => "Antarctica","28" => "Antigua and Barbuda","32" => "Argentina","51" => "Armenia","533" => "Aruba","36" => "Australia","40" => "Austria","31" => "Azerbaijan","44" => "Bahamas","48" => "Bahrain","50" => "Bangladesh","52" => "Barbados","112" => "Belarus","56" => "Belgium","84" => "Belize","204" => "Benin","60" => "Bermuda","64" => "Bhutan","68" => "Bolivia, Plurinational State of","535" => "Bonaire, Sint Eustatius and Saba","70" => "Bosnia and Herzegovina","72" => "Botswana","74" => "Bouvet Island","76" => "Brazil","86" => "British Indian Ocean Territory","96" => "Brunei Darussalam","100" => "Bulgaria","854" => "Burkina Faso","108" => "Burundi","116" => "Cambodia","120" => "Cameroon","124" => "Canada","132" => "Cape Verde","136" => "Cayman Islands","140" => "Central African Republic","148" => "Chad","152" => "Chile","156" => "China","162" => "Christmas Island","166" => "Cocos (Keeling) Islands","170" => "Colombia","174" => "Comoros","178" => "Congo","180" => "Congo, the Democratic Republic of the","184" => "Cook Islands","188" => "Costa Rica","384" => "Côte d'Ivoire","191" => "Croatia","192" => "Cuba","531" => "Curaçao","196" => "Cyprus","203" => "Czech Republic","208" => "Denmark","262" => "Djibouti","212" => "Dominica","214" => "Dominican Republic","218" => "Ecuador","818" => "Egypt","222" => "El Salvador","226" => "Equatorial Guinea","232" => "Eritrea","233" => "Estonia","231" => "Ethiopia","238" => "Falkland Islands (Malvinas)","234" => "Faroe Islands","242" => "Fiji","246" => "Finland","250" => "France","254" => "French Guiana","258" => "French Polynesia","260" => "French Southern Territories","266" => "Gabon","270" => "Gambia","268" => "Georgia","276" => "Germany","288" => "Ghana","292" => "Gibraltar","300" => "Greece","304" => "Greenland","308" => "Grenada","312" => "Guadeloupe","316" => "Guam","320" => "Guatemala","831" => "Guernsey","324" => "Guinea","624" => "Guinea-Bissau","328" => "Guyana","332" => "Haiti","334" => "Heard Island and McDonald Islands","336" => "Holy See (Vatican City State)","340" => "Honduras","344" => "Hong Kong","348" => "Hungary","352" => "Iceland","356" => "India","360" => "Indonesia","364" => "Iran, Islamic Republic of","368" => "Iraq","372" => "Ireland","833" => "Isle of Man","376" => "Israel","380" => "Italy","388" => "Jamaica","392" => "Japan","832" => "Jersey","400" => "Jordan","398" => "Kazakhstan","404" => "Kenya","296" => "Kiribati","408" => "Korea, Democratic People's Republic of","410" => "Korea, Republic of","414" => "Kuwait","417" => "Kyrgyzstan","418" => "Lao People's Democratic Republic","428" => "Latvia","422" => "Lebanon","426" => "Lesotho","430" => "Liberia","434" => "Libya","438" => "Liechtenstein","440" => "Lithuania","442" => "Luxembourg","446" => "Macao","807" => "Macedonia, the former Yugoslav Republic of","450" => "Madagascar","454" => "Malawi","458" => "Malaysia","462" => "Maldives","466" => "Mali","470" => "Malta","584" => "Marshall Islands","474" => "Martinique","478" => "Mauritania","480" => "Mauritius","175" => "Mayotte","484" => "Mexico","583" => "Micronesia, Federated States of","498" => "Moldova, Republic of","492" => "Monaco","496" => "Mongolia","499" => "Montenegro","500" => "Montserrat","504" => "Morocco","508" => "Mozambique","104" => "Myanmar","516" => "Namibia","520" => "Nauru","524" => "Nepal","528" => "Netherlands","540" => "New Caledonia","554" => "New Zealand","558" => "Nicaragua","562" => "Niger","566" => "Nigeria","570" => "Niue","574" => "Norfolk Island","580" => "Northern Mariana Islands","578" => "Norway","512" => "Oman","586" => "Pakistan","585" => "Palau","275" => "Palestinian Territory, Occupied","591" => "Panama","598" => "Papua New Guinea","600" => "Paraguay","604" => "Peru","608" => "Philippines","612" => "Pitcairn","616" => "Poland","620" => "Portugal","630" => "Puerto Rico","634" => "Qatar","638" => "Réunion","642" => "Romania","643" => "Russian Federation","646" => "Rwanda","652" => "Saint Barthélemy","654" => "Saint Helena, Ascension and Tristan da Cunha","659" => "Saint Kitts and Nevis","662" => "Saint Lucia","663" => "Saint Martin (French part)","666" => "Saint Pierre and Miquelon","670" => "Saint Vincent and the Grenadines","882" => "Samoa","674" => "San Marino","678" => "Sao Tome and Principe","682" => "Saudi Arabia","686" => "Senegal","688" => "Serbia","690" => "Seychelles","694" => "Sierra Leone","702" => "Singapore","534" => "Sint Maarten (Dutch part)","703" => "Slovakia","705" => "Slovenia","90" => "Solomon Islands","706" => "Somalia","710" => "South Africa","239" => "South Georgia and the South Sandwich Islands","728" => "South Sudan","724" => "Spain","144" => "Sri Lanka","729" => "Sudan","740" => "Suriname","744" => "Svalbard and Jan Mayen","748" => "Swaziland","752" => "Sweden","756" => "Switzerland","760" => "Syrian Arab Republic","158" => "Taiwan, Province of China","762" => "Tajikistan","834" => "Tanzania, United Republic of","764" => "Thailand","626" => "Timor-Leste","768" => "Togo","772" => "Tokelau","776" => "Tonga","780" => "Trinidad and Tobago","788" => "Tunisia","792" => "Turkey","795" => "Turkmenistan","796" => "Turks and Caicos Islands","798" => "Tuvalu","800" => "Uganda","804" => "Ukraine","784" => "United Arab Emirates","826" => "United Kingdom","840" => "United States","581" => "United States Minor Outlying Islands","858" => "Uruguay","860" => "Uzbekistan","548" => "Vanuatu","862" => "Venezuela, Bolivarian Republic of","704" => "Viet Nam","92" => "Virgin Islands, British","850" => "Virgin Islands, U.S.","876" => "Wallis and Futuna","732" => "Western Sahara","887" => "Yemen","894" => "Zambia","716" => "Zimbabwe"),
    
    'listLoyalty' => array(1 => "Broker", 2 => "Supervisor", 3 => "Manager", 4 => "Executive", 5 => "President"),
    ];
