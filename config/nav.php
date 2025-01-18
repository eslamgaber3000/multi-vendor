
<?php

return [

[
    'title'=>'Category',
    'route'=>'dashboard.category.index',
    'icon'=>'far fa-circle nav-icon',
    'active'=>'dashboard.category.*'
],
[
    'title'=>'Product',
    'route'=>'dashboard.product.index',
    'icon'=>'far fa-circle nav-icon',
    'badge'=>'New',
    'active'=>'dashboard.product.*'

],
[
    'title'=>'Order',
    'route'=>'dashboard.dashboard',
    'icon'=>'nav-icon fas fa-th',
    'badge'=>'New',
    'active'=>'dashboard.dashboard'
],


];

?>