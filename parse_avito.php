<?php

require_once 'simple_html_dom.php'; // simple html dom library file
require_once 'Item.php';
$URI = Build_URI(); // здесь нужно писать ф-цию формирующую URL адрес
$ads = Parse_Avito_pages2($URI);
echo '<pre>';
print_r($ads);
echo '</pre><br>';
Mail_notification();

/**
 * Поиск объявлений по указанному Url и параметрам
 * че то еще  "$start_url"
 * че то еще2 "$param"
 */
function Parse_Avito_pages2($uri)
{
    $arr;
    $html = file_get_html($uri);
    foreach ($html->find('div[class=item item_table clearfix js-catalog-item-enum]') as $div) {
        $item = new Item;
        $itemValue = $div->find('.item_table-header .item-description-title-link');
        $item->ad_name = trim($itemValue[0]->plaintext);
        $itemValue = $div->find('.item_table-header .about');
        $item->ad_price = trim($itemValue[0]->plaintext);
        $itemValue = $div->find('.address');
        $item->ad_loc = trim($itemValue[0]->plaintext);
        $itemValue = $div->find('.data .c-2');
        $item->ad_time = trim($itemValue[0]->plaintext);
        $itemValue = $div->find('.item-description-title-link');
        $item->ad_src = trim($itemValue[0]->href);
        $arr[] = $item;
    }
    unset($html);
    return $arr;
}

function Build_URI()
{
    $url = "https://www.avito.ru";
    $urn = "/moskva/kvartiry/sdam";
    $param = "?s=104";
    return ($url . $urn . $param);
}

function Mail_notification()
{
    $email = 'diablo3games@mail.ru'; // Получаем список пользователей для рассылки
    $flag = mail($email, "Zagolovok", "text pisma");
    if ($flag) {
        echo "Mail was sended";
    } else {
        echo "Mail not sended";
    }

    return;
}
