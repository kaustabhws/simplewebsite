<html>
    <head>
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
       <h2> Random Dad Joke </h2>
       <?php

       function getstr($string, $start, $end){
           $string = ' ' . $string;
           $ini = strpos($string, $start);
           if ($ini == 0) return '';
           $ini += strlen($start);
           $len = strpos($string, $end, $ini) - $ini;
           return substr($string, $ini, $len);
       }

       function multiexplode($delimiters, $string)
       {
         $one = str_replace($delimiters, $delimiters[0], $string);
         $two = explode($delimiters[0], $one);
         return $two;
       }


       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, 'https://api.dadjokes.io/api/random/joke');
       curl_setopt($ch, CURLOPT_HEADER, 0);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array(
       'authority: api.dadjokes.io',
       'method: GET',
       'path: /api/random/joke',
       'scheme: https',
       'accept: application/json, text/plain, */*=',
       'accept-language: en-US,en;q=0.9',
       'origin: https://dadjokes.io',
       'referer: https://dadjokes.io/',
       'sec-ch-ua: "Not_A Brand";v="99", "Google Chrome";v="109", "Chromium";v="109"',
       'sec-ch-ua-mobile: ?0',
       'sec-ch-ua-platform: "Windows"',
       'sec-fetch-dest: empty',
       'sec-fetch-mode: cors',
       'sec-fetch-site: same-site',
       'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36',
          ));
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

       $getinfo = curl_exec($ch);


       $status = trim(strip_tags(getstr($getinfo, '"success":',',"')));

       $setup = trim(strip_tags(getstr($getinfo, '"setup":',',"')));

       $punchline = trim(strip_tags(getstr($getinfo, '"punchline":',',"')));

       $share = trim(strip_tags(getstr($getinfo, '"shareableLink":"','"')));


       # ---------------- [Responses] ----------------- #

       if($status == 'true')
       {
          echo "$setup<br><br>";
          echo "$punchline";
       }

       curl_close($ch);

       ?>
       <script>
            function copy(){
                var copyText = "<?php echo"$share"?>";
                navigator.clipboard.writeText(copyText);
                alert("Copied successfully");
            }
       </script>
       <br><br><br>
       <form action="chk.php" method="post">
               <input type="submit" class="button" value="Generate">
               <input type="button" class="button" value="Copy sharable link" onclick="copy()">
           </form>
       </div>
    </body>
</html>
