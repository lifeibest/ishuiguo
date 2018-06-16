<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SystemconfigType;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class SystemconfigTypeController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('配置类型');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('配置类型');
            $content->description('编辑');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('配置类型');
            $content->description('创建');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(SystemconfigType::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            //$grid->name('配置类型名称')->sortable();
            $grid->name('配置类型名称')->editable()->sortable();
            $grid->type_keyword('配置关键字');

            $grid->created_at();
            $grid->updated_at();

            // 禁止批量删除
            $grid->tools(function (Grid\Tools $tools) {
                $tools->batch(function (Grid\Tools\BatchActions $actions) {
                    $actions->disableDelete();
                });
            });
            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });

            $grid->filter(function ($filter) {
                //$filter->disableIdFilter();
                $filter->like('name', '配置类型名称');
                $filter->like('type_keyword');
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(SystemconfigType::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('name', '配置类型名称')->rules('required');

            // // 复杂的验证规则可以在回调里面实现
            // rules('unique:systemconfig_type')
            $form->text('type_keyword', '配置关键字')->rules(
                function ($form) {
                    //https://moell.cn/article/24
                    //指定字段唯一性
                    return 'unique:systemconfig_type,type_keyword,' . $form->model()->id . '|required|regex:/^\w+$/|min:2';
                }, [
                    'regex' => '必须全部为字符',
                    'min' => '不能少于2个字符',
                ]
            );

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
