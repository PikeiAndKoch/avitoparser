<?php

require_once 'simple_html_dom.php';

class AvitoParser
{

    private $_adsArr;
    private $_url;
    private $_urn;
    private $_uri;

    public function parseAvitoPages2()
    {
        $uri = $this->uriBuilder();
        $html = file_get_html($uri);
        foreach ($html->find('div[class=item item_table clearfix js-catalog-item-enum]') as $div) {
            $itemValue = $div->find('.item_table-header .item-description-title-link');
            $ad_name = html_entity_decode(trim($itemValue[0]->plaintext));
            $itemValue = $div->find('.item_table-header .about text');
            $ad_price = html_entity_decode(preg_replace("/[^0-9]/", '', $itemValue[0]->plaintext));
            $itemValue = $div->find('.address');
            $ad_loc = html_entity_decode(trim($itemValue[0]->plaintext));
            $itemValue = $div->find('.data .c-2');
            $ad_dateTime = $this->dateDecode($itemValue[0]->plaintext);
            $itemValue = $div->find('.item-description-title-link');
            $ad_src = html_entity_decode(trim($itemValue[0]->href));
            global $_url;
            $ad_src = $_url.$ad_src;
            $this->_adsArr[] = array($ad_name, $ad_price, $ad_loc, $ad_dateTime, $ad_src);
        }
        $html->clear();
        unset($html);
        return $this->_adsArr;
    }

    public function uriBuilder()
    {
        $url = "https://www.avito.ru";
        $urn = "/moskva/kvartiry/sdam";
        $param = "?s=104";
        global $_uri, $_url, $_urn;
        list($_url, $_urn, $_uri) = array($url, $urn, $url.$urn.$param);
        return ($url . $urn . $param);
    }

    public function dateDecode($str)
    {
        $dateTime = explode("&nbsp;", trim($str));
        if (!preg_match('\'[0-9]\'', $dateTime[0], $matches)) :
            switch ($dateTime[0]) {
            case "Сегодня":
                $date = date('y-m-d');
                break;
            case "Вчера":
                $date = time()-60*60*24;
                $date = date('y-m-d', $date);
                break;
            }
            else:
                list($dataD, $dataMY) = explode(" ", $dateTime[0]);
                if (!(int)($dataD/10))
                    $dataD = '0'.$dataD;
                switch ($dataMY) {
                case "января":
                    $date = '18-01-'.$dataD; 
                    break;
                case "февраля":
                    $date = '18-02-'.$dataD; 
                    break;
                case "марта": 
                    $date = '18-03-'.$dataD; 
                    break;
                case "апреля": 
                    $date = '18-04-'.$dataD; 
                    break;
                case "мая": 
                    $date = '18-05-'.$dataD; 
                    break;
                case "июня": 
                    $date = '18-06-'.$dataD; 
                    break;
                case "июля": 
                    $date = '18-07-'.$dataD;
                    break;
                case "августа": 
                    $date = '18-08-'.$dataD; 
                    break;
                case "сентября": 
                    $date = '18-09-'.$dataD; 
                    break;
                case "октября": 
                    $date = '18-10-'.$dataD;
                    break;
                case "ноября": 
                    $date = '18-11-'.$dataD; 
                    break;
                case "декабря": 
                    $date = '18-12-'.$dataD; 
                    break;
                default: 
                    $date = '01.01.01';
                }
            endif;
            $time = $dateTime[1].':00';
            return $date.' '.$time;
    }
}