
<?php

return [

[
    'title'=>'Category',
    'route'=>'dashboard.category.index',
    'icon'=>'far fa-circle nav-icon',
    'active'=>'dashboard.category.*',
    'abilities'=>'categories.view',
],
[
    'title'=>'Product',
    'route'=>'dashboard.product.index',
    'icon'=>'far fa-circle nav-icon',
    'badge'=>'New',
    'active'=>'dashboard.product.*',
    'abilities'=>'products.view',


],
[
    'title'=>'Order',
    'route'=>'dashboard.dashboard',
    'icon'=>'nav-icon fas fa-th',
    'badge'=>'New',
    'active'=>'dashboard.dashboard',
    'abilities'=>'orders.view',
],
[
    'title'=>'Role',
    'route'=>'dashboard.role.index',
    'icon'=>'nav-icon fas fa-th',
    'badge'=>'New',
    'active'=>'dashboard.role.*',
    'abilities'=>'roles.view',
],
[
    'title'=>'Admin',
    'route'=>'dashboard.admins.index',
    'icon'=>'nav-icon fas fa-th',
    'badge'=>'',
    'active'=>'dashboard.admins.*',
    'abilities'=>'admins.view',
],


];

?>