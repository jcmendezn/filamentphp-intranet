<?php

return [

/*     'nav' => [
        'group' => 'Seguridad',
        'role' => [
            'label' => 'Roles',
            'icon'  => 'heroicon-o-user-group',
        ],
        'permission' => [
            'label' => 'Permisos',
            'icon'  => 'heroicon-o-key',
        ],
    ], */

/*     'nav.group' => 'Filament Shield',
'nav.role.label' => 'Roles',
'nav.role.icon' => 'heroicon-o-shield-check',
'resource.label.role' => 'Role',
'resource.label.roles' => 'Roles', */


  
    'nav' => [
        'group' => 'Seguridad',
        'role' => [
            'label' => 'Roles',
            'icon'  => 'heroicon-o-user-group',
        ],
        'permission' => [
            'label' => 'Permisos',
            'icon'  => 'heroicon-o-key',
        ],
    ],


    'column' => [
        'name' => 'Nombre',
        'guard_name' => 'Guard',
        'roles' => 'Roles',
        'permissions' => 'Permisos',
        'updated_at' => 'Actualizado el',
    ],

    'field' => [
        'name' => 'Nombre',
        'guard_name' => 'Guard',
        'permissions' => 'Permisos',
        'select_all' => [
            'name' => 'Seleccionar todos',
            'message' => 'Habilitar todos los permisos actualmente <span class="text-primary font-medium">habilitados</span> para este rol',
        ],
    ],

    'resource' => [
        'label' => [
            'role' => 'Rol',
            'roles' => 'Roles',
        ],
    ],

    'section' => 'Entidades',
    'resources' => 'Recursos',
    'widgets' => 'Widgets',
    'pages' => 'Páginas',
    'custom' => 'Permisos personalizados',

    'forbidden' => 'Usted no tiene permiso de acceso',

    'resource_permission_prefixes_labels' => [
        'view' => 'Ver un registro en particular',
        'view_any' => 'Ver el listado de registros',
        'create' => 'Crear',
        'update' => 'Actualizar',
        'delete' => 'Eliminar un registro en particular',
        'delete_any' => 'Eliminar varios registros a la vez',
        'force_delete' => 'Forzar elminación de un registro en particular',
        'force_delete_any' => 'Forzar eliminación de varios registros',
        'restore' => 'Restaurar un registro en particular',
        'restore_any' => 'Restaurar varios registros',
        'reorder' => 'Reordenar',
        'replicate' => 'Replicar',
    ],
];
