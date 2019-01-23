<?php

namespace tekintian\utils

/**
 * @Author: Tekin
 * @Date:   2019-01-24 00:02:26
 * @Last Modified 2019-01-24
 * @Last Modified time: 2019-01-24 00:04:48
 */
class CurlHttpRequest 
{
	/**
	 * Tekin 专用curl访问请求， 超强自定义
	 * 灵活，强大！！
	 * @author TekinTian <tekintian@gmail.com>
	 * @param  [type] $url    [description]
	 * @param  array $req_data [请求数据，数组]
	 * @param  string $method [请求方式，默认 GET]
	 * @param  array $ext_data [] 额外请求数据，包括 agent, referer 还有头信息数组 headers
	 * $ext_data['agent']="Baidu Spider";
	 * $ext_data['referer']="http://www.baidu.com";
	 * 自定义请求头部信息
	 * $ext_data['headers'][
	 *          "CLIENT-IP: 192.168.1.100",//伪造客户端IP
	            "X-FORWARDED-FOR: 192.168.1.100",//伪造转发IP
	 *          "POST /getinfo.php HTTP/1.0", 
	            "Content-type: text/xml;charset=\"utf-8\"", 
	            "Accept: text/xml", 
	            "Cache-Control: no-cache", 
	            "Pragma: no-cache", 
	            "SOAPAction: \"run\"", 
	            "Content-length: ".strlen($xml_data), 
	            "Authorization: Basic " . base64_encode($credentials)
	            ]

	 * @return [type]         [description]
	 */
	public static function send($url,$req_data=[],$method='GET',$ext_data=[]){ 
	   //构造GET请求URL
	   if (strtoupper($method)=='GET' && count($req_data)>0) {
	       $url = $url.'?'.http_build_query($req_data);
	   }
	    //模拟浏览器agent
	    $browser_agent=isset($ext_data['agent'])?$ext_data['agent']:$_SERVER['HTTP_USER_AGENT'];
	   
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 跳过证书检查
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
	  
	    curl_setopt($curl, CURLOPT_USERAGENT, $browser_agent);
	    if (isset($ext_data['referer'])) {
	       curl_setopt($curl, CURLOPT_REFERER, $ext_data['referer']);
	    }
	    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
	    if(strtoupper($method)=='POST') {
	        curl_setopt($curl, CURLOPT_POST, 1);
	        if (!empty($req_data)) {
	            curl_setopt($curl, CURLOPT_POSTFIELDS, $req_data);
	        }
	    }
	    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10); //timeout on connect
	    curl_setopt($curl, CURLOPT_TIMEOUT, 30);//timeout on response
	    if (isset($ext_data['headers'])) {
	       curl_setopt($curl, CURLOPT_HTTPHEADER, $ext_data['headers']); 
	    }else{
	       curl_setopt($curl, CURLOPT_HEADER, 0); 
	    }
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    $result = curl_exec($curl);
	    //如果有错误，则返回错误信息
	    if($result === FALSE ){
	       return "CURL Error:".curl_error($curl);
	     }
	    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	    $httpInfo =  curl_getinfo($curl);
	    curl_close($curl);
	    return $result;
	}

}