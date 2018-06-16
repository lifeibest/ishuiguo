<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Systemconfig;
use App\Models\SystemconfigType;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class SystemconfigController extends Controller
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

            $content->header('配置');
            $content->description('列表');

            // 面包屑导航
            $content->breadcrumb(
                ['text' => '配置列表', 'url' => '/systemconfig'],
                ['text' => '配置']
            );

            $content->row($this->systemconfigType());

            $content->body($this->grid());
        });
    }

    public function systemconfigType()
    {
        $list = systemconfigType::all();
        //print_r($list);exit;
        $str = '';
        foreach ($list as $k => $v) {
            $str .= ' <a href="/admin/systemconfig?&systemconfig_type_id=' . $v->id . '"> ' . $v->name . ' </a> ';
        }
        return $str;
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
            // 面包屑导航
            $content->breadcrumb(
                ['text' => '配置列表', 'url' => '/systemconfig'],
                ['text' => '编辑配置']
            );
            $content->header('配置');
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
            // 面包屑导航
            $content->breadcrumb(
                ['text' => '配置列表', 'url' => '/systemconfig'],
                ['text' => '创建配置']
            );

            $content->header('配置');
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
        return Admin::grid(Systemconfig::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            //$grid->model()->with('systemconfigType')->orderBy('id', 'DESC');

            // $grid->column('systemconfig_type_id', '配置类型')->display(function ($systemconfig_type_id) {
            //     return systemconfigType::find($systemconfig_type_id)->name;
            // });

            $grid->column('systemconfigType.name', '配置类型'); //同上功能

            $grid->name('配置名称');
            $grid->keyword('标识符');
            $grid->value1('值');
            $grid->is_open('开关');

            $grid->created_at('创建时间')->sortable();
            $grid->updated_at('更新时间')->sortable();

            // $grid->actions(function (Grid\Displayers\Actions $actions) {
            //     if ($actions->getKey() == 1) {
            //         $actions->disableDelete();
            //     }
            // });
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
                $filter->disableIdFilter();
                $filter->equal('systemconfig_type_id', '配置类型')->select(systemconfigType::all()->pluck('name', 'id'));
                $filter->like('name', '配置名称');
                $filter->like('keyword', '关键字');
                $filter->like('value1', '值1');
                $filter->like('value2', '值2');
                $filter->like('value3', '值3');

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
        return Admin::form(Systemconfig::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->select('systemconfig_type_id', '配置类型')->options(SystemconfigType::all()->pluck('name', 'id'));

            $form->text('name', '配置名称')->rules('required');
            $form->text('keyword', '标识符')->rules('required|regex:/^\w+$/|min:2', [
                'regex' => '必须全部为字符',
                'min' => '不能少于2个字符',
            ]);
            $form->textarea('value1', '值1')->rules('required');
            $form->textarea('value2', '值2');
            $form->textarea('value3', '值3', '');

            $states = [
                'on' => ['value' => 1, 'text' => '启用'],
                'off' => ['value' => 2, 'text' => '关闭'],
            ];
            $form->switch('is_open', '状态')->states($states);

            $form->number('sort_number', '排序');

            $form->textarea('remark', '备注');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
