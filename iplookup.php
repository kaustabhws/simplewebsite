<html>
    <head>
        <title> IP Lookup </title>
        <style>
            .bg {position:fixed;width:100vw;height:100vh;top:0;left:0;background:rgba(112,70,143,1);
            animation:10s Skew infinite;
            box-shadow:0 -50vh 0 rgba(177,25,29,1) inset
            }
            .bg:before {position:absolute;top:50vh;left:0;
                height:25vh;width:100%;content:'';background:rgba(25,162,243,1);box-shadow:0 0 16px rgba(0,0,0,0.15);z-index:1
            }
            .bg:after {background:rgba(22,179,118,1);
                content:'';display:block;width:100%;height:25vh;
                position:absolute;top:25vh;left:0;box-shadow:0 0 16px rgba(0,0,0,0.15);}
            .bg:before, .bg:after {  animation:10s Skew infinite;
            }
            .bg:before {animation-delay:2s}
            .bg:after {animation-delay:6s}
            @keyframes Skew {
                20% {transform:skewY(-45deg) scale(1,3)}
                40% {transform:skewY(45deg) scasle(1.3);}
                60% {transform:skewY(-45deg) scale(1,3);}
                80% {transform:skewY(45deg) scale(1,3)}
            }
            .content {position:relative;margin:20vh auto;
            background:rgba(255,255,255,0.15);font-size:2vw;
            padding:5vh;text-align:center;color:rgba(255,255,255,0.95);
            box-sizing:border-box;text-shadow:0 0 1vw rgba(0,0,0,0.25);
            max-width:80vw;color: black; font-weight: bold;

            }
            .input {
                font-family: -apple-system,BlinkMacSystemFont,"Segoe UI","Roboto","Oxygen","Ubuntu","Cantarell","Fira Sans","Droid Sans","Helvetica Neue",sans-serif;
                font-weight: 500;
                font-size: .8vw;
                color: #fff;
                background-color: rgb(28,28,30);
                box-shadow: 0 0 .4vw rgba(0,0,0,0.5), 0 0 0 .15vw transparent;
                border-radius: 0.4vw;
                border: none;
                outline: none;
                padding: 0.4vw;
                max-width: 190px;
                transition: .4s;
                }

                .input:hover {
                box-shadow: 0 0 0 .15vw rgba(135, 207, 235, 0.186);
                }

                .input:focus {
                box-shadow: 0 0 0 .15vw skyblue;
                }
                .button {
                padding: 12.5px 30px;
                border: 0;
                border-radius: 100px;
                background-color: #000;
                color: #ffffff;
                font-weight: Bold;
                transition: all 0.5s;
                -webkit-transition: all 0.5s;
                }

                .button:hover {
                background-color: #6fc5ff;
                box-shadow: 0 0 20px #6fc5ff50;
                }

                .button:active {
                background-color: #3d94cf;
                transition: all 0.25s;
                -webkit-transition: all 0.25s;
                box-shadow: none;
                }
        </style>
    </head>
    <body>
    <div class='bg'></div>
        <div class='content'>
            <form action="iplookup.php" method="post">
            <input type="text" name="ip" class="input" placeholder="Enter IP Address"> <br> <br>
            <input type="submit" class="button" value="Check">
        </form>
        <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $ipa = $_POST['ip'];
                }
                error_reporting(0);
                date_default_timezone_set('Asia/Jakarta');
                
                function GetStr($string, $start, $end){
                    $str = explode($start, $string);
                    $str = explode($end, $str[1]);  
                    return $str[0];
                };

        if ($ipa != null) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://ipgeolocation.io/ip-location/' . $ipa . '');
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'authority: ipgeolocation.io',
                'method: GET',
                'path: /ip-location/' . $ipa . '',
                'scheme: https',
                'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                'accept-language: en-US,en;q=0.9',
                'cookie: __cfduid=d8c2c917bade62b9facbb0c814b7ad31d1616071633; _gcl_au=1.1.968854398.1616071635; _ga=GA1.2.2067243747.1616071636; _gid=GA1.2.807613435.1616071636; _gat_UA-116456024-1=1; _gat_gtag_UA_116456024_1=1',
                'referer: https://ipgeolocation.io/ip-location/' . $ipa . '',
                'sec-ch-ua: "Google Chrome";v="89", "Chromium";v="89", ";Not A Brand";v="99"',
                'sec-ch-ua-mobile: ?0',
                'sec-fetch-dest: document',
                'sec-fetch-mode: navigate',
                'sec-fetch-site: same-origin',
                'sec-fetch-user: ?1',
                'upgrade-insecure-requests: 1',
                'user-agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36',
            )
            );
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . '/cookie.txt');
            curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . '/cookie.txt');

            # ----------------- [1req Postfields] ---------------------#
        

            $result1 = curl_exec($ch);
            $ip = trim(strip_tags(getStr($result1, '"ip": </span><span class="ip-info-right">&quot;', '&quot;,</span><br><span class="ip-info-left"> "hostname"')));
            $hs = trim(strip_tags(getStr($result1, '"hostname": </span><span class="ip-info-right">', '</span><br><span class="ip-info-left"> "continent_code"')));
            $conc = trim(strip_tags(getStr($result1, '"continent_code": </span><span class="ip-info-right">&quot;', '&quot;,</span><br><span class="ip-info-left"> "continent_name"')));
            $conn = trim(strip_tags(getStr($result1, '"continent_name": </span><span class="ip-info-right">&quot;', '&quot;,</span><br><span class="ip-info-left"> "country_code2"')));
            $couc = trim(strip_tags(getStr($result1, '"country_code2": </span><span class="ip-info-right">&quot;', '&quot;,</span><br><span class="ip-info-left"> "country_code3"')));
            $coun1 = trim(strip_tags(getStr($result1, '"country_code3": </span><span class="ip-info-right">&quot;', '&quot;,</span><br><span class="ip-info-left"> "country_name"')));
            $coun = trim(strip_tags(getStr($result1, '"country_name": </span><span class="ip-info-right">&quot;', '&quot;,</span><br><span class="ip-info-left"> "country_capital"')));
            $capn = trim(strip_tags(getStr($result1, '"country_capital": </span><span class="ip-info-right">&quot;', '&quot;,</span><br><span class="ip-info-left"> "state_prov"')));
            $stn = trim(strip_tags(getStr($result1, '"state_prov": </span><span class="ip-info-right">&quot;', '&quot;,</span><br><span class="ip-info-left"> "district"')));
            $disn = trim(strip_tags(getStr($result1, '"district": </span><span class="ip-info-right">&quot;', '&quot;,</span><br><span class="ip-info-left"> "city"')));
            $citn = trim(strip_tags(getStr($result1, '"city": </span><span class="ip-info-right">&quot;', '&quot;,</span><br><span class="ip-info-left"> "zipcode"')));
            $zipc = trim(strip_tags(getStr($result1, '"zipcode": </span><span class="ip-info-right">&quot;', '&quot;,</span><br><span class="ip-info-left"> "latitude"')));
            $latd = trim(strip_tags(getStr($result1, '"latitude": </span><span class="ip-info-right">', '</span><br><span class="ip-info-left"> "longitude"')));
            $longt = trim(strip_tags(getStr($result1, '"longitude": </span><span class="ip-info-right">', '</span><br><span class="ip-info-left"> "is_eu"')));
            $calld = trim(strip_tags(getStr($result1, '"calling_code": </span><span class="ip-info-right">&quot;', '&quot;,</span><br><span class="ip-info-left"> "country_tld"')));
            $isp = trim(strip_tags(getStr($result1, '"isp": </span><span class="ip-info-right">&quot;', '&quot;,</span><br><span class="ip-info-left"> "connection_type"')));
            $orgn = trim(strip_tags(getStr($result1, '"organization": </span><span class="ip-info-right">&quot;', '&quot;,</span><br><span class="ip-info-left"> "asn"')));
            $timz = trim(strip_tags(getStr($result1, '"name":</span><span class="ip-info-right">&quot;', '&quot;,</span><br><span class="ip-info-left"> "offset"')));
            $curt = trim(strip_tags(getStr($result1, '"current_time": </span><span class="ip-info-right">&quot;', '&quot;,</span><br><span class="ip-info-left"> "current_time_unix"')));
            $info = curl_getinfo($ch);
            curl_close($ch);

            if ($ipa == $ip) {
                echo "<b>STATUS: </b><b>VALID IP✅</b> <br>
            <b>IP:</b> <b>$ip</b><br>
            <b>HOSTNAME:</b> <b>$hs</b><br>
            <b>CONTINENT CODE:</b> <b>$conc</b><br>
            <b>CONTINENT:</b> <b>$conn</b><br>
            <b>COUNTRY CODE:</b> <b>$couc/$coun1</b><br>
            <b>COUNTRY:</b> <b>$coun</b><br>
            <b>CAPITAL:</b> <b>$capn</b><br>
            <b>STATE:</b> <b>$stn</b><br>
            <b>DISTRICT:</b> <b>$disn</b><br>
            <b>CITY:</b> <b>$citn</b><br>
            <b>ZIPCODE:</b> <b>$zipc</b><br>
            <b>LATITUDE:</b> <b>$latd</b><br>
            <b>LONGITUDE:</b> <b>$longt</b><br>
            <b>CALLING CODE:</b> <b>$calld</b><br>
            <b>ISP:</b> <b>$isp</b><br>
            <b>ORGANIZATION:</b> <b>$orgn</b><br>
            <b>TIME ZONE:</b> <b>$timz</b><br>
            <b>CURRENT TIME:</b> <b>$curt</b><br>";
            }else{
                echo "<b>STATUS: </b><b>INVALID IP❌</b> <br>
                Enter a valid IP address";
            }
        }
                
        ?>
        </div>
    </body>
</html>
