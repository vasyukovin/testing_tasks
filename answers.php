<?php
$array = [
    ['id' => 1, 'date' => "12.01.2020", 'name' => "test1"],
    ['id' => 2, 'date' => "02.05.2020", 'name' => "test2"],
    ['id' => 4, 'date' => "08.03.2020", 'name' => "test4"],
    ['id' => 1, 'date' => "22.01.2020", 'name' => "test1"],
    ['id' => 2, 'date' => "11.11.2020", 'name' => "test4"],
    ['id' => 3, 'date' => "06.06.2020", 'name' => "test3"],
];

// 1. выделить уникальные записи (убрать дубли) в отдельный массив. в конечном
// массиве не должно быть элементов с одинаковым id.
$arrayWithExtraIds = [];
$arrayWithUniqueIds = array_reduce($array, function ($carry, $item) use (&$arrayWithExtraIds) {
    $id = $item['id'];

    if (! array_key_exists($id, $carry)) {
        $carry[$id] = $item;
    } else {
        $arrayWithExtraIds[] = $item;
    }

    return $carry;
}, []);

// 2. отсортировать многомерный массив по ключу (любому)
$arraySortedById = $array;
array_multisort(array_column($arraySortedById, 'id'), SORT_ASC, $arraySortedById);

// 3. вернуть из массива только элементы, удовлетворяющие внешним условиям (например элементы с определенным id)
$arrayWithIdIsEqual2 = array_filter($array, fn ($item) => $item['id'] === 2);

// 4. изменить в массиве значения и ключи (использовать name => id в качестве пары ключ => значение)
$arraySwapped = array_map(fn ($item) => [$item['name'] => $item['id']], $array);

/*
    5. В базе данных имеется таблица с товарами goods (id INTEGER, name TEXT),
    таблица с тегами tags (id INTEGER, name TEXT) и таблица связи товаров и
    тегов goods_tags (tag_id INTEGER, goods_id INTEGER, UNIQUE(tag_id,
    goods_id)). Выведите id и названия всех товаров, которые имеют все возможные
    теги в этой базе.
*/
SELECT goods.*
FROM goods
WHERE NOT EXISTS (
    SELECT tags.id
    FROM tags
    WHERE tags.id NOT IN (
    SELECT goods_tags.tag_id
        FROM goods_tags
        WHERE goods_tags.goods_id = goods.id
    )
);

// 6. Выбрать без join-ов и подзапросов все департаменты, в которых есть мужчины,
// и все они (каждый) поставили высокую оценку (строго выше 5).
SELECT department_id
FROM evaluations
WHERE gender = true
GROUP BY department_id
HAVING MIN(value) >= 5;