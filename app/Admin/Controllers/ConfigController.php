<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Config;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

use Dcat\Admin\Layout\Content;

class ConfigController extends AdminController
{
    public $type = [
        'text' => '文本',
        'textarea' => '长文本',
        'radio' => '单选',
        'checkbox' => '多选',
        'array' => '数组',
        'image' => '图片上传',
        'images' => '多图上传',
        'file' => '文件上传',
        'files' => '多文件上传'
    ];
    /**
     * Index interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content)
    {
        // dump(config());
        return $content
            ->header('表格')
            ->description('表格功能展示')
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Config(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->title;
            // $grid->model()->where('state', '>', 0); 
            $grid->name->if(function () {
                // dump($this->name);
                // return $this->config ? true : false;
            });
            $grid->value;
            $grid->group->display(function ($group) {

                return $group;
            })->filter(
                Grid\Column\Filter\Equal::make()->valueFilter()->hide()
            );
            $type = $this->type;
            $grid->type->display(function ($types) use ($type) {
                return $type[$types];
            })->filter(
                Grid\Column\Filter\Equal::make()->valueFilter()->hide()
            );

            $grid->value()->display(function ($value) {
                return "<pre class='dump'>$value</pre>";
            });

            $grid->state->switch();
            $grid->default;
            $grid->created_at;
            $grid->updated_at->sortable();
            $grid->enableDialogCreate(); // 弹窗创建表单
            // $grid->filter(function (Grid\Filter $filter) {
            //     $filter->equal('id',0);
            // });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Config(), function (Show $show) {
            $show->id;
            $show->title;
            $show->name;
            $show->value;
            $show->group;
            $show->type;
            $show->state;
            $show->default;
            $show->created_at;
            $show->updated_at;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Config(), function (Form $form) {
            $form->display('id');
            $form->text('title')->required(false);
            $form->text('name')->required(false);
            // $form->textarea('value')->rows(10)->required(false);
            $form->radio('group')->options(['system' => 'system', 'base'=> 'base', 'email'=> 'email', 'upload'=> 'upload'])->default('base')->required(false);
            $form->select('type')->options($this->type)->default('text')->required(false);
            $form->switch('state');
            $form->textarea('default');
            $form->saving(function (Form $form) {
                // if ($form->type == 'array') {
                //     $form_values = explode("\r\n",$form->value);
                //     foreach ($form_values as $key => $val) {
                //         $arr = explode(":",$val);
                //         $form_value[$arr[0]] = $arr[1];
                //     }
                //     $form->value = json_encode($form_value);
                // }
                // $type = $form->type;
                // $form->type = 66;
                // dump($form);
                // 等同于
                // $username = $form->input('username');
            });
            // $form->display('created_at');
            // $form->display('updated_at');
        });
    }

    // static function isconfig() {
    //     dump(config());
    // }
}
