<?php

namespace console\controllers;

use yii\console\Controller;

class CronController extends Controller
{

    //http://www.chictr.org.cn/L3Nob3dwcm9qLmFzcHg/cHJvaj0zMzg0OA==
    public function Rand_IP()
    {

        $ip2id = round(rand(600000, 2550000) / 10000); //第一种方法，直接生成
        $ip3id = round(rand(600000, 2550000) / 10000);
        $ip4id = round(rand(600000, 2550000) / 10000);
        //下面是第二种方法，在以下数据中随机抽取
        $arr_1 = array("218", "218", "66", "66", "218", "218", "60", "60", "202", "204", "66", "66", "66", "59", "61", "60", "222", "221", "66", "59", "60", "60", "66", "218", "218", "62", "63", "64", "66", "66", "122", "211");
        $randarr = mt_rand(0, count($arr_1) - 1);
        $ip1id = $arr_1[$randarr];
        return $ip1id . "." . $ip2id . "." . $ip3id . "." . $ip4id;
    }


    public function actionPa()
    {
        $time = 1545914743;
        while (true) {
            for ($i = 32743 - 1; $i > 0; $i--) {
                $result = \Yii::$app->db->createCommand("select * from customer_pa where page_id = {$i}")->queryAll();
                if ($result) {
                    continue;
                }
                echo 'page_id:' . $i . "\n";
                if (time() - $time > 200) {
                    $time = time();
                }
                $header = [
                    "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8",
                    "Accept-Encoding: gzip, deflate",
                    "Accept-Language: zh-CN,zh;q=0.9",
                    "Cache-Control:no-cache",
                    "Connection:keep-alive",
                    "Cookie: ccpassport=1f85e2d5e83eff2d013defaa9f2afb65; wzwsconfirm=485df71b42c119fc6f0d7a954360d580; wzwstemplate=NQ==; wzwschallenge=-1; wzwsvtime={$time}; onlineusercount=1",
                    "Host:www.chictr.org.cn",
                    "Pragma:no-cache",
                    "Referer: http://www.chictr.org.cn/searchproj.aspx",
                    "Upgrade-Insecure-Requests: 1",
                    "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.162 Safari/537.36",
//                    "User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:64.0) Gecko/20100101 Firefox/64.0",
//                    "X-FORWARDED-FOR:" . $this->Rand_IP() . ", CLIENT-IP:" . $this->Rand_IP()
                ];

                $url = "http://www.chictr.org.cn/showproj.aspx?proj={$i}";

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); //加入gzip解析
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); //加入重定向处理,加了重定向直接空白
                $output = curl_exec($ch);
                curl_close($ch);
//                file_put_contents('a.' . $i . '.html', $output);
                echo 'length:' . strlen($output) . "\n";
//                if (strlen($output) <= 14680) {
//                    exit;
//                }
                if (strlen($output) <= 20000) {
//                    sleep(rand(5, 30));
                    continue;
                }
                preg_match_all('/<div class="ProjetInfo_ms">(.*?)<\/div>/is', $output, $match);
                if (empty($match[0])) {
//                    sleep(rand(5, 30));
                    continue;
                }
                preg_match_all('/<tr(?:.*?)>(.*?)<\/tr>/is', $match[1][1], $match2);
                preg_match_all('/<td(?:.*?)>(.*?)<\/td>/is', $match2[1][0], $match3);
                preg_match_all('/<td(?:.*?)>(.*?)<\/td>/is', $match2[1][2], $match6);
                preg_match_all('/<td(?:.*?)>(.*?)<\/td>/is', $match2[1][4], $match9);
                preg_match_all('/<td(?:.*?)>(.*?)<\/td>/is', $match2[1][9], $match7);
                preg_match_all('/<p(?:.*?)>(.*?)<\/p>/is', $match3[1][1], $match4);
                preg_match_all('/<p(?:.*?)>(.*?)<\/p>/is', $match3[1][3], $match5);
                preg_match_all('/<p(?:.*?)>(.*?)<\/p>/is', $match7[1][1], $match8);
                $application = trim(str_replace('&nbsp;', '', $match4[1][0]));
                $study_leadey = trim(str_replace('&nbsp;', '', $match5[1][0]));
                $telephone = trim(str_replace(['&nbsp;', '+86', ' '], '', $match6[1][1]));
                $leadey_telephone = trim(str_replace(['&nbsp;', '+86', ' '], '', $match6[1][3]));
                $position = trim(str_replace('&nbsp;', '', $match8[1][0]));
                $application_email = trim(str_replace('&nbsp;', '', $match9[1][1]));
                $leadey__email = trim(str_replace('&nbsp;', '', $match9[1][3]));
                $date = date('Y-m-d H:i:s');
                $sql = "insert into customer_pa values(null,'{$application}','{$study_leadey}','{$telephone}','{$leadey_telephone}','{$application_email}','{$leadey__email}','{$position}',{$i},'{$date}')";
//            echo $sql;exit;
                \Yii::$app->db->createCommand($sql)->execute();
//                sleep(rand(5, 30));
            }
        }
    }


    public function actionPa1()
    {
        while (true) {
            for ($i = 33949; $i > 0; $i--) {
                $result = \Yii::$app->db->createCommand("select * from customer_pa where page_id = {$i}")->queryAll();
                if ($result) {
                    continue;
                }
                echo $i . "\n";
                $url = "http://www.chictr.org.cn/showproj.aspx?proj={$i}";
                $output = file_get_contents($url);
                file_put_contents('a.' . $i . '.html', $output);
                echo strlen($output) . "\n";
                if (strlen($output) <= 20000) {
                    sleep(rand(10, 50));
                    continue;
                }
                preg_match_all('/<div class="ProjetInfo_ms">(.*?)<\/div>/is', $output, $match);
                if (empty($match[0])) {
                    sleep(rand(10, 50));
                    continue;
                }
                preg_match_all('/<tr(?:.*?)>(.*?)<\/tr>/is', $match[1][1], $match2);
                preg_match_all('/<td(?:.*?)>(.*?)<\/td>/is', $match2[1][0], $match3);
                preg_match_all('/<td(?:.*?)>(.*?)<\/td>/is', $match2[1][2], $match6);
                preg_match_all('/<td(?:.*?)>(.*?)<\/td>/is', $match2[1][4], $match9);
                preg_match_all('/<td(?:.*?)>(.*?)<\/td>/is', $match2[1][9], $match7);
                preg_match_all('/<p(?:.*?)>(.*?)<\/p>/is', $match3[1][1], $match4);
                preg_match_all('/<p(?:.*?)>(.*?)<\/p>/is', $match3[1][3], $match5);
                preg_match_all('/<p(?:.*?)>(.*?)<\/p>/is', $match7[1][1], $match8);
                $application = trim(str_replace('&nbsp;', '', $match4[1][0]));
                $study_leadey = trim(str_replace('&nbsp;', '', $match5[1][0]));
                $telephone = trim(str_replace('&nbsp;', '', $match6[1][1]));
                $leadey_telephone = trim(str_replace('&nbsp;', '', $match6[1][3]));
                $position = trim(str_replace('&nbsp;', '', $match8[1][0]));
                $application_email = trim(str_replace('&nbsp;', '', $match9[1][1]));
                $leadey__email = trim(str_replace('&nbsp;', '', $match9[1][3]));
                $date = date('Y-m-d H:i:s');
                $sql = "insert into customer_pa values(null,'{$application}','{$study_leadey}','{$telephone}','{$leadey_telephone}','{$application_email}','{$leadey__email}','{$position}',{$i},'{$date}')";
//            echo $sql;exit;
                \Yii::$app->db->createCommand($sql)->execute();
                sleep(rand(10, 50));
            }
        }
    }
}
