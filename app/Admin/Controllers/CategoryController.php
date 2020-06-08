<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Category;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use App\Models\Category as CategoryModel;

class CategoryController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Category(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->title->tree();
            $grid->slug;
            // $grid->parent_id->display(function($parent_id){
            //     return CategoryModel::getTitleValue($parent_id);
            // });
            $grid->order->orderable();
            $grid->status->switch()->sortable();
            // $grid->image;
            $grid->desc;
            $grid->created_at;
            $grid->updated_at->sortable();
            $grid->disableViewButton();
            $grid->setActionClass(Grid\Displayers\Actions::class);

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
        return Show::make($id, new Category(), function (Show $show) {
            $show->id;
            $show->title;
            $show->slug;
            $show->parent_id;
            $show->order;
            $show->desc;
            $show->status;
            // $show->image;
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
        return Form::make(new Category(), function (Form $form) {
            $form->display('id');
            $form->text('title')->rules('required|unique:category');
            $form->text('slug')->rules('required|alpha_num_new|unique:category');
            $form->select('parent_id')->options(function () {
                return CategoryModel::selectOptions();
            });

            $form->number('order')->default('1');
            $form->textarea('desc');

            $form->hidden('status')->default('1');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }

}
