<?php

namespace seo_aiowt_namespace;

if ( ! defined( 'ABSPATH' ) ) exit;

define("_RATE_OK", "success");
define("_RATE_WARNING", "warning");
define("_RATE_ERROR", "error");
define("_RATE_OK_IDEAL", "success ideal_ratio");
define("_RATE_ERROR_LESSTHAN", "error less_than");
define("_RATE_ERROR_MORETHAN", "error more_than");

define("_RATE_CSS_COUNT", 4);
define("_RATE_JS_COUNT", 6);

define("_RATE_TITLE_BAD", 0);
define("_RATE_TITLE_GOOD", 40);
define("_RATE_TITLE_BEST", 70);

define("_RATE_DESC_BAD", 0);
define("_RATE_DESC_GOOD", 70);
define("_RATE_DESC_BEST", 160);

define("_RATE_HRATIO_BAD", 15);  /* Text to html ratio percentage % */
define("_RATE_HRATIO_GOOD", 45);
define("_RATE_HRATIO_BEST", 90);

/*
The Website Review is a dynamc grade on a 100-point scale.
This mean that the sum of shown bellow points can't be more than 100.

So, how points are added? Let's take a look on the first key=>value pair
'noFlash' => 2,
This mean, that if website do not have flash content then he will get +2 points to current score and etc.
===========================
Let's analyse pairs containing arrays. For example: 'title' => array(),
if the $title length == 0, then website receives 0 points,
if length > 0 and < 10 -> 2 points
and etc



===========================
At the bottom of this config file you will see 'wordConsistency' key.
'wordConsistency' => array(
	'keywords' => 0.5,
	'description' => 1,
	'title' => 1,
	'headings' => 1,
),
To calculate the total sum of this checkpoint you need to multiply each value by {N} and sum them.
Where {N} -> is 'consistencyCount' => value in main cnofig (config/main.php)
By default {N} equals 5, so
(0.5 * 5) + (1 * 5) + (1 * 5) + (1 * 5) = 17.5
17.5 - the maximum points, which website can be get at this checkpoint.



Advice. Be careful if you want to change the rates. the Rating system is full 100 points
*/
return array(
	'noFlash' => 3,

	'noIframe' => 2,

	'issetHeadings' => 4,  //Heading element after Og Meta Property

	'noNestedtables' => 2,

	'noInlineCSS' => 2,      // Css inline penalty

	'noEmail' => 1,

	'issetFavicon' => 3,

	'imgHasAlt' => 1,      //missing Image Alt tag penalty

	'isFriendlyUrl' => 7,   //Usability , Url -- domain name too long penalty

	'noUnderScore' => 4,

	'issetInternalLinks' => 4,  //In-page links section score




//IN SEO Keywords section , check the comment at top, the calculation method is different , the bottom is 2 x 5 = 10
  'wordConsistency' => array(
		'keywords' => 0.5,
		'description' => 0.5,
		'title' => 0.5,
		'headings' => 0.5,
	),





	'charset' => 3,

	'viewport' => 3, // in Mobile section

	'dublincore' => 2,

	'ogmetaproperties' => 2,




	'w3c' => 1,

	'doctype' => 2,

	'isPrintable' => 1, //Printability

	'issetAppleIcons' => 0, //Apple icon in Mobile section at bottom

	'noDeprecated' => 2,  //Deprecated HTML

	'lang' => 3,  //Language in Usability section





// title 
	'title' => array(
		'$value == _RATE_TITLE_BAD' => array(
			'score' => 0,
			'advice' => _RATE_ERROR,
		),
		'$value > _RATE_TITLE_BAD and $value < _RATE_TITLE_GOOD' => array(
			'score' => 4,
			'advice' => _RATE_WARNING,
		),
		'$value >= _RATE_TITLE_GOOD and $value <= _RATE_TITLE_BEST' => array(
			'score' => 8,
			'advice' => _RATE_OK,
		),
		'$value > _RATE_TITLE_BEST' => array(
			'score' => 2,
			'advice' => _RATE_WARNING,
		),
	),


// Description
	'description' => array(
		'$value == _RATE_DESC_BAD' => array(
			'score' => 0,
			'advice' => _RATE_ERROR,
		),
		'$value > _RATE_DESC_BAD and $value < _RATE_DESC_GOOD' => array(
			'score' => 2,
			'advice' => _RATE_WARNING,
		),
		'$value >= _RATE_DESC_GOOD and $value <= _RATE_DESC_BEST' => array(
			'score' => 4,
			'advice' => _RATE_OK,
		),
		'$value > _RATE_DESC_BEST' => array(
			'score' => 0,
			'advice' => _RATE_WARNING,
		),
	),


//Keywords section
	'keywords' => 1,




//Text/Html Ratio scoring here
	'htmlratio' => array(
		'$value < _RATE_HRATIO_BAD' => array(
			'score' => 2,
			'advice' => _RATE_ERROR_LESSTHAN,
		),
		'$value >= _RATE_HRATIO_BAD and $value < _RATE_HRATIO_GOOD' => array(
			'score' => 9,
			'advice' => _RATE_OK,
		),
		'$value >= _RATE_HRATIO_GOOD and $value <= _RATE_HRATIO_BEST' => array(
			'score' => 17,
			'advice' => _RATE_OK_IDEAL,
		),
		'$value > _RATE_HRATIO_BEST' => array(
			'score' => 0,
			'advice' => _RATE_ERROR_MORETHAN,
		),
	),





//css too much files rating here
	'cssCount' => array(
		'$value <= _RATE_CSS_COUNT' => array(
			'score' => 3,
			'advice' => _RATE_OK,
		),
		'$value > _RATE_CSS_COUNT' => array(
			'score' => 0,
			'advice' => _RATE_ERROR,
		),
	),



//Js too much rating here
	'jsCount' => array(
		'$value <= _RATE_JS_COUNT' => array(
			'score' => 5,
			'advice' => _RATE_OK,
		),
		'$value > _RATE_JS_COUNT' => array(
			'score' => 0,
			'advice' => _RATE_ERROR,
		),
	),


);




