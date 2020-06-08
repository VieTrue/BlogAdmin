<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Tag;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class TagController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Tag(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->title;
            // $grid->slug;
            $grid->created_at;
            $grid->updated_at->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
            });
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
        return Show::make($id, new Tag(), function (Show $show) {
            $show->id;
            $show->title;
            // $show->slug;
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
        return Form::make(new Tag(), function (Form $form) {
            $form->display('id');
            $form->text('title')->rules('unique:tags');
            // $form->text('slug')->rules('unique:tags');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
