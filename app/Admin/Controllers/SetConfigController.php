<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Config;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
// use Dcat\Admin\Controllers\AdminController;

use Dcat\Admin\Layout\Content;

class SetConfigController extends ConfigController
{
    
    /**
     * Index interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('表格')
            ->description('表格功能展示2')
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
            $grid->model()->where('state', '>', 0); 
            $grid->name->if(function () {
                // dump($this->name);
                // return $this->config ? true : false;
            });
            $grid->value;
            $grid->group->filter(
                Grid\Column\Filter\Equal::make()->valueFilter()->hide()
            );
            $grid->type->filter(
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

}
