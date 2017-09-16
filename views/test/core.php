<?php
/**
 * Created by PhpStorm.
 * User: Rapoo
 * Date: 16.09.2017
 * Time: 13:41
 */

$TITLE = "Проверка Kernel на скорость отработки";

$_TOTAL = (empty($_GET['total'])) ? 100*100 : intval($_GET['total']);

$BODY .= "Скрипт отрисовывает числа по порядку до $_TOTAL. Изменить через GET[total].<br><textarea style='display:block;width:100%;height: 300px; !important;resize: none;'>";

for($i=0;$i<$_TOTAL;$i++) {
    $_test = new Kernel();
    $_test->_setHtml(_DIR_ . _VIEW_ . '/test_object.tpl.html');

    $_test->_setVar("num", $i);

    $BODY .= $_test->_getHtml();
}

$BODY .= "</textarea>";