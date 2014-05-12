<?php namespace qufo\Baidu;

class Baidu {
    const version = '0.1';
    
    /**
    * 百度ping
    * 
    * @param mixed $sitename  站点名称    eg. 我的站点
    * @param mixed $siteindex 站点首页    eg. http://www.fjhw.com
    * @param mixed $newdocurl 新文章地址  eg. http://www.fjhw.com/2014.html
    * @param mixed $rssurl    rss地址     eg. http://www.fjhw.com/rss
    * @return boolean         执行成功与否
    */
    public function ping($sitename='',$siteindex='',$newdocurl='',$rssurl=''){
        $xml = <<<EOT
<?xml version="1.0" encoding="UTF-8"?>
<methodCall>
    <methodName>weblogUpdates.extendedPing</methodName>
    <params>
        <param>
            <value><string>__SITENAME__</string></value>
        </param>
        <param>
            <value><string>__SITEINDEX__</string></value>
        </param>
        <param>
            <value><string>__NEWDOCURL__</string></value>
        </param>
        <param>
            <value><string>__RSSURL__</string></value>
        </param>
    </params>
</methodCall>
EOT;
        $xml = str_replace(array('__SITENAME__','__SITEINDEX__','__NEWDOCURL__','__RSSURL__'),array($sitename,$siteindex,$newdocurl,$rssurl),$xml);
        $response = $this->postUrl('http://ping.baidu.com/ping/RPC2',$xml);
        return strpos($response,'<int>0</int>')?true:false;
    }
    
    
    /**
    * Post Data to Url
    * 
    * @param mixed $url
    * @param mixed $data
    */
    private function postUrl($url,$data) {
        $info = parse_url($url);
        $ch = curl_init();
        $headers = array(
            "POST ".$info['path']." HTTP/1.0",
            "User-Agent: request",
            "Host: ".$info['host'],
            "Content-Type: text/xml",
            "Content-Length: ".strlen($data)
        );
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
        curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
        $return = curl_exec ($ch); 
        curl_close ($ch); 
        return $return; 
    }
    
    public function version(){
        return self::version;
    }
}