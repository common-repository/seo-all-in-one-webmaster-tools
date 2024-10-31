<?php
namespace seo_aiowt_namespace;
/*
NexStats Class 1.2
NexStats is a lightweight, easy to use PHP Statistics Class.
Author : Nexthon

You Can Download Latest Version From
http://codecanyon.net/item/nexstats-class/10036431?ref=Nexthon
*/
error_reporting(E_ERROR);
libxml_use_internal_errors(true);

class NEXStats {

	public $url,$timeout;
	
	function __construct($url="google.com",$timeout=10) {
	
		$this->url=rawurlencode($url);
		
		$this->timeout=$timeout;
		
	}
	
	public function getClientIP() {

    if (isset($_SERVER)) {

        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
            return $_SERVER["HTTP_X_FORWARDED_FOR"];

        if (isset($_SERVER["HTTP_CLIENT_IP"]))
            return $_SERVER["HTTP_CLIENT_IP"];

        return $_SERVER["REMOTE_ADDR"];
    }

    if (getenv('HTTP_X_FORWARDED_FOR'))
        return getenv('HTTP_X_FORWARDED_FOR');

    if (getenv('HTTP_CLIENT_IP'))
        return getenv('HTTP_CLIENT_IP');

    return getenv('REMOTE_ADDR');
}
	
	public function getGoogleCount() {
	
		$clientIp = $this->getClientIP();
		
		$json = json_decode($this->getRemoteContents("http://ajax.googleapis.com/ajax/services/search/web?v=1.0&filter=0&q=site:$this->url&userip=$clientIp"));
		
		if(intval($json->responseData->cursor->estimatedResultCount))
			return intval($json->responseData->cursor->estimatedResultCount);
		else
			return 0;		
	}
	
	public function getMetaData() {
	
	$meta = array();
	
	$html = $this->getRemoteContents("http://$this->url");
	
	$doc = new DOMDocument();
	
	@$doc->loadHTML($html);
	
	$nodes = $doc->getElementsByTagName('title');
	
	$meta['title'] = $nodes->item(0)->nodeValue;
	
	$metas = $doc->getElementsByTagName('meta');

	for ($i = 0; $i < $metas->length; $i++) {
	
		$metaTags = $metas->item($i);
		
		if($metaTags->getAttribute('name') == 'description')
			$meta['description'] = $metaTags->getAttribute('content');
			
		if($metaTags->getAttribute('name') == 'keywords')
			$meta['keywords'] = $metaTags->getAttribute('content');
	
	}
	
	return $meta;
	
	}
	
	public function getHeaderResponse() {
	
	$handle = curl_init("http://".$this->url);
    
	$USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
	
	curl_setopt($handle,  CURLOPT_RETURNTRANSFER, true);
	
	curl_setopt($handle, CURLOPT_USERAGENT, $USER_AGENT);
	
	curl_setopt($handle, CURLOPT_TIMEOUT, $this->timeout);
			
	curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, $this->timeout);
		
	curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		
	curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
	
	curl_setopt($handle,CURLOPT_HEADER,true);
    
	curl_setopt($handle,CURLOPT_NOBODY,true);
	
	curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
	
    $response = curl_exec($handle);
	
	curl_close($handle);
	
    return trim($response);
	
	}
	
	
	public function getStatusCode($url) {
	
	$handle = curl_init($url);
	
	$USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
	
	curl_setopt($handle,  CURLOPT_RETURNTRANSFER, true);
	
	curl_setopt($handle, CURLOPT_USERAGENT, $USER_AGENT);
	
	curl_setopt($handle, CURLOPT_TIMEOUT, $this->timeout);
			
	curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, $this->timeout);
		
	curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		
	curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
	
	curl_setopt($handle,CURLOPT_HEADER,true);
    
	curl_setopt($handle,CURLOPT_NOBODY,true);
	
	curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
	
	$response = curl_exec($handle);
	
	$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
	
	curl_close($handle);
	
	return $httpCode;
	
	}
	
	public function getBingCount() {
	
		$html_bing_results = $this->getRemoteContents("http://www.bing.com/search?q=site:" . $this->url . "&FORM=QBRE&mkt=en-US");
		
		$document = new DOMDocument(); 
		
		$document->loadHTML($html_bing_results);
		
		$selector = new DOMXPath($document);
		
		$anchors = $selector->query('/html/body//span[@class="sb_count"]');
		
		foreach ($anchors as $node) {
		
			$bing_results = $this->innerHTML($node);
		
		}
		
		$bing_results = str_replace("results","",$bing_results);
		
		$bing_results = str_replace(",","",$bing_results);
		
		if(trim($bing_results)!="") return $bing_results;
			return 0;
		
	}
	
	public function getYahooCount() {
		
		$results = trim($this->getStringBetween($this->getRemoteContents("http://search.yahoo.com/search;_ylt=?p=site:" . $this->url),'">Next</a><span>',' results</span>'));
		
		$results= str_replace(",","",$results);
		
		if($results=="")
			return 0;
		
		return $results;
		
	}
	
	public function getGooglePagerank() {
		
		$data=json_decode($this->getRemoteContents("http://www.prapi.net/pr.php?url=http://$this->url&f=json"),true);
		
		if(is_numeric($data['pagerank']))
		return $data['pagerank'];
		
		$pagerank = $this->getGooglePR();
		
	return $pagerank;
		
	}
	
	public function StrToNum($Str, $Check, $Magic) {
	
	$Int32Unit = 4294967296; // 2^32
	
	$length = strlen($Str);
	
	for ($i = 0; $i < $length; $i++) {
	
		$Check *= $Magic;
		
		if ($Check >= $Int32Unit) {
		
			$Check = ($Check - $Int32Unit * (int) ($Check / $Int32Unit));
			
			$Check = ($Check < -2147483648) ? ($Check + $Int32Unit) : $Check;
		
		}
		
		$Check += ord($Str{$i});
		
	}
	
	return $Check;
	
	}
	
	public function HashURL($String) {
	
		$Check1 = $this->StrToNum($String, 0x1505, 0x21);
		
		$Check2 = $this->StrToNum($String, 0, 0x1003F);
		
		$Check1 >>= 2;
		
		$Check1 = (($Check1 >> 4) & 0x3FFFFC0 ) | ($Check1 & 0x3F);
		
		$Check1 = (($Check1 >> 4) & 0x3FFC00 ) | ($Check1 & 0x3FF);
		
		$Check1 = (($Check1 >> 4) & 0x3C000 ) | ($Check1 & 0x3FFF);
		
		$T1 = (((($Check1 & 0x3C0) << 4) | ($Check1 & 0x3C)) <<2 ) | ($Check2 & 0xF0F );
		
		$T2 = (((($Check1 & 0xFFFFC000) << 4) | ($Check1 & 0x3C00)) << 0xA) | ($Check2 & 0xF0F0000 );
		
	return ($T1 | $T2);
		
	}
	
	public function CheckHash($Hashnum) {
	
		$CheckByte = 0;
		
		$Flag = 0;
		
		$HashStr = sprintf('%u', $Hashnum);
		
		$length = strlen($HashStr);
		
		for ($i = $length - 1; $i >= 0; $i --) {
		
			$Re = $HashStr{$i};
			
			if (1 === ($Flag % 2)) {
			
				$Re += $Re;
				
				$Re = (int)($Re / 10) + ($Re % 10);
				
			}
			
			$CheckByte += $Re;
			
			$Flag ++;
			
		}
		
		$CheckByte %= 10;
		
			if (0 !== $CheckByte) {
			
				$CheckByte = 10 - $CheckByte;
				
				if (1 === ($Flag % 2) ) {
				
					if (1 === ($CheckByte % 2)) {
					
						$CheckByte += 9;
						
					}
					
					$CheckByte >>= 1;
					
				}
			
		}
		
		return '7'.$CheckByte.$HashStr;
		
	}
	
	public function getDmozListing() {
	
		$dmoz_result = strtolower($this->getRemoteContents('http://dmoz.org/search/?q=' . urlencode($this->url)));
		
		if(strpos($dmoz_result,"dmoz sites")!==false)
			return 1;
		else
			return 0;
	}
	
	function getAlexaRank() {
	
		$xml = simplexml_load_string($this->getRemoteContents('http://data.alexa.com/data?cli=10&dat=snbamz&url='.$this->url));
		$rank=0;
		
		if($xml->SD[1]) {
		
			$rank=(int)$xml->SD[1]->POPULARITY->attributes()->TEXT;
			return $rank;
			
		}
		
	return 0;
	
	}
	
	public function getSpeedScore() {
	
		$userIP = $this->getClientIP();
		
		$contents = $this->getRemoteContents('https://www.googleapis.com/pagespeedonline/v1/runPagespeed?userIp=$userIP&fields=score&url=http://' .$this->url);
		
		$json = json_decode($contents);
		
		if($json->score)
			return $json->score;
		else
			return 0;
		
	}

	public function getContentBreakDown() {
	
		$userIP = $this->getClientIP();
		
		$contents = $this->getRemoteContents('https://www.googleapis.com/pagespeedonline/v1/runPagespeed?userIp=$userIP&url=http://' .$this->url);
		
		$json = json_decode($contents,true);
		
		return $json;
		
	}
	
	public function getAlexaBacklinks() {
	
		$xml = simplexml_load_string($this->getRemoteContents('http://data.alexa.com/data?cli=10&dat=snbamz&url='.$this->url));
		
	return isset($xml->SD[0]->LINKSIN)?$xml->SD[0]->LINKSIN->attributes()->NUM:0;
	
	}
	
	public function getAlexaBounceRate() {
	
		$html_alexa_results = $this->getRemoteContents('http://www.alexa.com/siteinfo/' . $this->url);
		
		$document_alexa = new DOMDocument();
		
		$document_alexa->loadHTML($html_alexa_results);
		
		$selector_alexa = new DOMXPath($document_alexa);
		
		$content_alexa_bounce = $selector_alexa->query('/html/body//strong[@class="font-big2 valign"]');
		
		foreach($content_alexa_bounce as $bounce_alexa) {
		
			$bounce_rate = $this->innerHTML($bounce_alexa);
			
			break;
			
		}
		
		$bounce_rate = trim(str_replace('%','', $bounce_rate));
		
		if(is_numeric($bounce_rate))
		return $bounce_rate;
		
		return 0;
	
	}
	
	public function getBounceRate($domainAuthority,$googlePageRank) {
		
		return (100-(($domainAuthority/2)+($googlePageRank*2)));

	}
	
	public function dailyUniqueVisitors($alexaRank) {
	
	$alexaRank = ($alexaRank) ? $alexaRank : 1178050236;

	return (int)((1178050236*pow($alexaRank,-0.8))/30);
	
	}
	
	public function dailyPageViews($googlePagerank,$dailyUniqueVisitors) {
	
	$googlePagerank = ($googlePagerank>1) ? $googlePagerank : 0.5*(rand(10,15));
	
	return (int)($dailyUniqueVisitors*$googlePagerank);

	}
	
	public function getTwitterShares() {
	
		$json = json_decode($this->getRemoteContents("http://urls.api.twitter.com/1/urls/count.json?url=$this->url"), true);
		
	return isset($json['count'])?intval($json['count']):0;
	
	}
	
	public function getLinkedInShares() {
	
		$json = json_decode($this->getRemoteContents("https://www.linkedin.com/countserv/count/share?url=$this->url&format=json"), true);
		
	return isset($json['count'])?intval($json['count']):0;
	
	}
	
	public function getFacebookStats() {
	
		return json_decode($this->getRemoteContents("http://api.facebook.com/restserver.php?method=links.getStats&urls=http://$this->url&format=json
"),true);
	
	}
	
	public function getRemoteContentsX() {
		
		$USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
	
		$options  = array('http' => array('user_agent' => $USER_AGENT, 'timeout' => $this->timeout));
				
		$context  = stream_context_create($options);
				
		$result = trim(file_get_contents($url,false, $context));
	
	return $result;
}
	
	public function getGooglePlusOneCount() {
	
		$curl = curl_init();
		
		$USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
		
		curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
		
		curl_setopt($curl, CURLOPT_POST, true);
		
		curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
			
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeout);
		
		curl_setopt($curl, CURLOPT_USERAGENT, $USER_AGENT);
		
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		
		curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"'.rawurldecode("http://www." . $this->url).'","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		
		$curl_results = curl_exec ($curl);
		
		curl_close ($curl);
		
		$json = json_decode($curl_results, true);
		
	return isset($json[0]['result']['metadata']['globalCounts']['count'])?intval( $json[0]['result']['metadata']['globalCounts']['count'] ):0;
	
	}
	
	public function getStumbleUponShares() {
	
		$json = json_decode($this->getRemoteContents("http://www.stumbleupon.com/services/1.01/badge.getinfo?url=$this->url"), true);
		
	return isset($json['result']['views'])?intval($json['result']['views']):0;
		
	}
	
	public function getPinterestShares() {
	
		$return_data = $this->getRemoteContents("http://api.pinterest.com/v1/urls/count.json?url=http://$this->url");
		
		$json = json_decode(preg_replace('/^receiveCount\((.*)\)$/', "\\1", $return_data), true);
		
	return isset($json['count'])?intval($json['count']):0;
	
	}
	
	public function getRemoteContents($url, $retries=5) {
	
		$USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
		
		$result = "";
	
		if (extension_loaded('curl') === true) {
		
			$ch=curl_init();
			
			curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
			
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
			
			curl_setopt($ch, CURLOPT_USERAGENT, $USER_AGENT);
			
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			
			curl_setopt($ch, CURLOPT_URL, $url);
			
			$result = curl_exec($ch);
						
			curl_close($ch);
			
			unset($ch);
			
		} else {
		
			$options  = array('http' => array('user_agent' => $USER_AGENT, 'timeout' => $this->timeout));
			
			$context  = stream_context_create($options);
			
			$result = trim(file_get_contents($url,false, $context));
			
		}
		
		if (trim($result)=="") {
			
			$retries-=1;
			
			if ($retries >= 1) {
			
				return $this->getRemoteContents($url, $retries);
				
			}
			
		}
		
	return $result;
	
	}
	
	public function getVKShares() {
	
	$str = $this->getRemoteContents("http://vk.com/share.php?act=count&index=1&url=http://" . $this->url);
		
		if (!$str) return 0;
		
		preg_match('/^VK.Share.count\((\d+),\s+(\d+)\);$/i', $str, $matches);
		
		$rq = $matches[2];
	
	return $rq;
	
	}
	
	public function getGoogleSafeBrowsingCheck() {
	
		$results = $this->getRemoteContents("http://www.google.com/safebrowsing/diagnostic?site=" . $this->url);
		
		if (preg_match('/This site is not currently listed as suspicious/',$results))
			return true;
		
	return false;
	
	}
	
	
	public function getSpamhausCheck() {
	
	$results = $this->getRemoteContents("http://www.spamhaus.org/query/domain/" . $this->url);
	
	if(trim($results)=="")
	return true;
	
	if (preg_match('/is not listed in the DBL/',$results))
		return true;
	
	return false;
	
	}
	
	public function getGooglePR() {
	
		$data = $this->getRemoteContents("http://toolbarqueries.google.com/tbr?client=navclient-auto&ch=".$this->CheckHash($this->HashURL($this->url)). "&features=Rank&q=info:".$this->url."&num=100&filter=0");
		
		$pos = strpos($data, "Rank_");
		
		if($pos === false)
		return 0;
	
	return trim(substr($data, $pos + 9));
	}
	
	function domainAuthority($accessID,$secretKey) {
		
		$expires = time() + 300;
		
		$stringToSign = $accessID."\n".$expires;
		
		$binarySignature = hash_hmac('sha1', $stringToSign, $secretKey, true);
		
		$urlSafeSignature = urlencode(base64_encode($binarySignature));
		
		$url="www.$url";
		
		$cols = "103079215108";
		
		$requestUrl = "http://lsapi.seomoz.com/linkscape/url-metrics/".urlencode($this->url)."?Cols=".$cols."&AccessID=".$accessID."&Expires=".$expires."&Signature=".$urlSafeSignature;
		
		$content = $this->getRemoteContents($requestUrl);
		
		$domainAuthority = $this->getStringBetween($content,'{"pda":',',"upa"');
		
		if(is_numeric($domainAuthority))
			return $domainAuthority;
		
		return 0;
		
	}
	
	public function getStringBetween($string,$start,$end) {
	
		$string = " " . $string;
		
		$ini = strpos($string, $start);
		
		if ($ini == 0) return "";
		
		$ini+= strlen($start);
		
		$len = strpos($string, $end, $ini) - $ini;
		
	return substr($string, $ini, $len);
		
	}
	
	public function innerHTML(DOMNode $node) {
	
		$doc = new DOMDocument();
		
		foreach ($node->childNodes as $child) {
		
			$doc->appendChild($doc->importNode($child, true));
			
		}
		
	return $doc->saveHTML();
		
	}
}
?>
