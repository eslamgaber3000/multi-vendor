
<?php

return [

[
    'title'=>'Category',
    'route'=>'dashboard.category.index',
    'icon'=>'far fa-circle nav-icon',
    'active'=>'dashboard.category.*',
    'abilities'=>'category.view',
],
[
    'title'=>'Product',
    'route'=>'dashboard.product.index',
    'icon'=>'far fa-circle nav-icon',
    'badge'=>'New',
    'active'=>'dashboard.product.*',
    'abilities'=>'product.view',


],
[
    'title'=>'Order',
    'route'=>'dashboard.dashboard',
    'icon'=>'nav-icon fas fa-th',
    'badge'=>'New',
    'active'=>'dashboard.dashboard',
    'abilities'=>'order.view',
],
[
    'title'=>'Role',
    'route'=>'dashboard.role.index',
    'icon'=>'nav-icon fas fa-th',
    'badge'=>'New',
    'active'=>'dashboard.role.*',
    'abilities'=>'role.view',
],


];

?>