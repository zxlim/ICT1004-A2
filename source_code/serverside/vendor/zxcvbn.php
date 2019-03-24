<?php
##############################
# zxcvbn.php
##############################

if (defined("CLIENT") === FALSE) {
	/**
	* Ghetto way to prevent direct access to "include" files.
	*/
	http_response_code(404);
	die();
}

require_once("serverside/vendor/zxcvbnPhp/Matchers/MatchInterface.php");
require_once("serverside/vendor/zxcvbnPhp/Matchers/Match.php");
require_once("serverside/vendor/zxcvbnPhp/Matchers/DigitMatch.php");
require_once("serverside/vendor/zxcvbnPhp/Matchers/Bruteforce.php");
require_once("serverside/vendor/zxcvbnPhp/Matchers/YearMatch.php");
require_once("serverside/vendor/zxcvbnPhp/Matchers/SpatialMatch.php");
require_once("serverside/vendor/zxcvbnPhp/Matchers/SequenceMatch.php");
require_once("serverside/vendor/zxcvbnPhp/Matchers/RepeatMatch.php");
require_once("serverside/vendor/zxcvbnPhp/Matchers/DictionaryMatch.php");
require_once("serverside/vendor/zxcvbnPhp/Matchers/L33tMatch.php");
require_once("serverside/vendor/zxcvbnPhp/Matchers/DateMatch.php");
require_once("serverside/vendor/zxcvbnPhp/Matcher.php");
require_once("serverside/vendor/zxcvbnPhp/Searcher.php");
require_once("serverside/vendor/zxcvbnPhp/ScorerInterface.php");
require_once("serverside/vendor/zxcvbnPhp/Scorer.php");
require_once("serverside/vendor/zxcvbnPhp/Zxcvbn.php");