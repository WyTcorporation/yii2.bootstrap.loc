Два метода

Один в папке api. 

Второй через модель в backend

Сейчас использую второй, связи с тем что в первом варианте нужно дублировать модели, а старые не подключаются

Пример :
```
GET /admin/api/v1/search-options

    Request
    
    /admin/api/v1/search-options?id=1
    
    Response
    
    {
        "code": 200,
        "message": "OK",
        "data": {
            "78": "OEM",
            "79": "Копия",
            "80": "Копия А",
            "81": "Копия АА",
            "82": "Копия ААА",
            "83": "Оригинал",
            "84": "Оригинал (Китай)",
            "85": "Оригинал (снято с произв.)",
            "86": "Оригинал Б/У",
            "87": "Сборка (оригинал+копия)"
        }
    }

GET /admin/api/v1/statistics

Response

{
    "code": 200,
    "message": "OK",
    "data": [
        {
            "id": 1,
            "parent_id": 0,
            "name": "a:3:{s:2:\"ru\";s:14:\"Дисплеи\";s:2:\"ua\";s:14:\"Дисплеи\";s:2:\"en\";s:14:\"Дисплеи\";}",
            "content": "a:3:{s:2:\"ru\";s:23:\"<p>Дисплеи</p>\r\n\";s:2:\"ua\";s:23:\"<p>Дисплеи</p>\r\n\";s:2:\"en\";s:23:\"<p>Дисплеи</p>\r\n\";}",
            "keywords": "a:3:{s:2:\"ru\";s:14:\"Дисплеи\";s:2:\"ua\";s:14:\"Дисплеи\";s:2:\"en\";s:14:\"Дисплеи\";}",
            "description": "a:3:{s:2:\"ru\";s:14:\"Дисплеи\";s:2:\"ua\";s:14:\"Дисплеи\";s:2:\"en\";s:14:\"Дисплеи\";}",
            "created_at": "2021-08-27 20:46:50",
            "updated_at": "2021-08-27 20:46:50",
            "slug": "displei",
            "img": "/uploads/category/2021_08_27/6129250a4d4fd_194254714.jpg",
            "gallery": null,
            "characteristics": ""
        },
    ]
}
POST http://yii2.shop.loc/admin/api/v1/call-back


Response
{
    "code": 200,
    "message": "OK",
    "data": {
        "telephone": "1111",
        "product": "Акумуляторна батарея 6-EVF-45",
        "id": 2
    }
}
```
