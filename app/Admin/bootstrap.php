<?php

use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Show;

use Dcat\Admin\Form\Field\Markdown;

/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqh <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */
admin_inject_section(\AdminSection::HEAD, function () {
    return '<link rel="shortcut icon" href="/favicon.ico">';
});
admin_inject_section(\AdminSection::HEAD, function () {
    return '<style>
    .row img.img{max-width:150px;max-height:150px;cursor:pointer;margin-right: 10px;width: 100%;}
    .row div.col div{display: table;height: 100%;}
    .row div.col span{display: table-cell;}
    .input-group .form-control.initialized{width: 100px !important;}
    .CodeMirror-gutter-elt{white-space: nowrap;}
    </style>';
});
Markdown::resolving(function (Markdown $markdown) {
    // 设置默认配置
    $markdown->options([
        'htmlDecode' => true,
        'emoji' => true,
        // 'taskList' => true,
        'tex' => true, // 默认不解析
        // 'flowChart' => true,  // 默认不解析
        // 'sequenceDiagram' => true // 默认不解析
    ]);
});
