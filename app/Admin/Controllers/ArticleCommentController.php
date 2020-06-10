<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\ArticleComment;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

use App\Admin\Actions\Recycle\Restore;
use App\Admin\Actions\Recycle\BatchRestore;
use App\Models\ArticleComment as CommentModel;

class ArticleCommentController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ArticleComment(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->article_id;
            $grid->ip->display(function($ip){
                return long2ip($ip);
            });
            $grid->likes;
            // $grid->reply_id;
            $grid->content;
            $grid->created_at;
            $grid->updated_at->sortable();

            $grid->disableViewButton();
            $grid->setActionClass(Grid\Displayers\Actions::class);
            $grid->disableCreateButton();
            $grid->filter(function ($filter) {
                $filter->scope('trashed', '回收站')->onlyTrashed();
            });
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if (request('_scope_') == 'trashed') {
                    $actions->append(new Restore(CommentModel::class));
                }
            });
            $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                if (request('_scope_') == 'trashed') {
                    $batch->add(new BatchRestore(CommentModel::class));
                }
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
        return Show::make($id, new ArticleComment(), function (Show $show) {
            $show->id;
            $show->article_id;
            $show->ip;
            $show->likes;
            $show->reply;
            $show->content;
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
        return Form::make(new ArticleComment(), function (Form $form) {
            $form->display('id');
            $form->text('article_id');
            $form->text('ip');
            $form->text('likes');
            $form->text('reply');
            $form->textarea('content');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
