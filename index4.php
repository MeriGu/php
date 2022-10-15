<?php


const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_EDIT = 4;
const OPERATION_PRINT = 3;

$operations = [
    OPERATION_EXIT => OPERATION_EXIT . '. Завершить программу.',
    OPERATION_ADD => OPERATION_ADD . '. Добавить товар в список покупок.',
    OPERATION_DELETE => OPERATION_DELETE . '. Удалить товар из списка покупок.',
    OPERATION_PRINT => OPERATION_PRINT . '. Отобразить список покупок.',
    OPERATION_EDIT => OPERATION_EDIT . '. Отредактировать название товара.',
];

$items = [];

function printGoodsList(array $goodsList): void
{
    if (count($goodsList)) {
        echo 'Ваш список покупок: ' . PHP_EOL;
        echo implode(PHP_EOL, $goodsList) . PHP_EOL;
        echo "Всего " . count($goodsList) . " позиций.\n";
    } else {
        echo 'Ваш список покупок пуст.' . PHP_EOL;
    }
}

function getGoodsName(): string
{
    echo "Введение название товара: \n> ";
    return trim(fgets(STDIN));
}

function deleteGoodsFromList(array $goodsList): array
{
    $itemName = getGoodsName();

    if (in_array($itemName, $goodsList, true) !== false) {
        while (($key = array_search($itemName, $goodsList, true)) !== false) {
            unset($goodsList[$key]);
        }
    }
    return $goodsList;
}

function getOperationNumber(array $goodsList, array $operationList): int
{
//    system('clear');
   system('cls'); // windows

    do {

        printGoodsList($goodsList);

        echo 'Выберите операцию для выполнения: ' . PHP_EOL;
        // Проверить, есть ли товары в списке? Если нет, то не отображать пункт про удаление товаров
        echo implode(PHP_EOL, $operationList) . PHP_EOL . '> ';
        $operationNumber = trim(fgets(STDIN));

        if (!array_key_exists($operationNumber, $operationList)) {
            system('clear');

            echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL;
        }

    } while (!array_key_exists($operationNumber, $operationList));

    echo 'Выбрана операция: ' . $operationList[$operationNumber] . PHP_EOL;

    return $operationNumber;
}


function changeGoodsName(array $goodsList): array
{
    $goodsName = getGoodsName();
    if (in_array($goodsName, $goodsList, true) !== false) {

        echo "Введение новое название товара: \n> ";
        $newGoodsName = trim(fgets(STDIN));

        if (!empty($newGoodsName)) {
            while (($key = array_search($goodsName, $goodsList, true)) !== false) {
                $goodsList[$key] = $newGoodsName;
            }
        }
    }

    return $goodsList;
}

do {

    $operationNumber = getOperationNumber($items, $operations);

    printGoodsList($items);

    switch ($operationNumber) {
        case OPERATION_ADD:
            $items[] = getGoodsName();
            break;

        case OPERATION_DELETE:
            // Проверить, есть ли товары в списке? Если нет, то сказать об этом и попросить ввести другую операцию
            $items = deleteGoodsFromList($items);
            break;

        case OPERATION_PRINT:
            echo 'Нажмите enter для продолжения';
            fgets(STDIN);
            break;

        case OPERATION_EDIT:
            $items = changeGoodsName($items);
            break;
    }

    echo "\n ----- \n";
} while ($operationNumber > 0);

echo 'Программа завершена' . PHP_EOL;