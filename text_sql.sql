SELECT order_requests.id, kitchens.name, order_requests.`status`,quantity, menus.name,menus.price FROM order_items
LEFT JOIN  order_requests  on order_items.order_request_id = order_requests.id
LEFT JOIN menus on menus.id = order_items.menu_id
LEFT JOIN kitchens on order_requests.kitchen_id = kitchens.id;


SELECT SUM(order_items.quantity *price) FROM order_items
LEFT JOIN  order_requests  on order_items.order_request_id = order_requests.id
LEFT JOIN menus on menus.id = order_items.menu_id;
