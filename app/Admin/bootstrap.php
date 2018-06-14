<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

Encore\Admin\Form::forget(['map', 'editor']);

/**
 * 自定义后台模板，参考：http://laravel-admin.org/docs/#/zh/qa?id=%e9%87%8d%e5%86%99%e5%86%85%e7%bd%ae%e8%a7%86%e5%9b%be
 * by lifei 2018.2.8
 */
app('view')->prependNamespace('admin', resource_path('views/admin'));
