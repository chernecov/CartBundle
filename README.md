CartBundle
==========

Symfony bundle.

Provides basic shopping cart functionality.
Based on FOSRestBundle, HateoasBundle, NelmiApiDocBundle...

Adding item to cart:

POST to ```/cart/item/add```

```json
{
  "title": "Tiffany heart signet ring in sterling silver.",
  "price": 158,
  "quantity": 2,
  "related_id": 74485
}

```


You can get cart by url: /cart/content?_embedded=true

```json
{
    "cart_id": "ea98738c",
    "channel": "default",
    "_links": {
        "self": {
            "href": "/cart/content",
            "method": "GET"
        },
        "clear": {
            "href": "/cart/clear",
            "method": "DELETE"
        }
    },
    "_embedded": {
        "items": [
            {
                "id": "46894fe9",
                "title": "Tiffany heart signet ring in sterling silver.",
                "price": 158,
                "quantity": 2,
                "related_id": 74485,
                "_links": {
                    "delete": {
                        "href": "/cart/item/46894fe9/remove",
                        "method": "DELETE"
                    },
                    "quantity": {
                        "href": "/cart/item/46894fe9/quantity/{quantity}",
                        "templated": true,
                        "method": "PATCH"
                    },
                    "patch": {
                        "href": "/cart/item/46894fe9/modify",
                        "templated": true,
                        "method": "PATCH",
                        "data": {
                            "json": [
                                "title",
                                "price",
                                "count",
                                "relatedId"
                            ]
                        }
                    }
                }
            }
        ]
    }
}
```
