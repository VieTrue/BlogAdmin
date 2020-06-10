<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Article;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Widgets\Card;

use App\Admin\Actions\Recycle\Restore;
use App\Admin\Actions\Recycle\BatchRestore;

use Dcat\Admin\Controllers\AdminController;
use App\Models\Category as CategoryModel;
use App\Models\Tag as TagModel;
use App\Models\Article as ArticleModel;

use Illuminate\Support\Facades\DB;

use Dcat\Admin\Admin;

class ArticleController extends AdminController
{
    
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(ArticleModel::with(['category','tags']), function (Grid $grid) {
            $grid->responsive();

            $grid->id->sortable();
            $grid->title->if(function () {
                            return $this->image ? true : false;
                        })
                        ->display(function(){
                            return '<div class="row"><div class="col-2"><img data-action="preview-img" src="'.config('filesystems.disks.admin.url').'/'.$this->image.'" class="img img-thumbnail"></div><div class="col text-wrap"><div><span class="align-middle">'.$this->title.'</span></div></div></div>';
                        })
                        ->else()
                        ->display(function($title){
                            return '<div class="text-wrap">'.$title.'</div>';
                        });
            $grid->catid->display(function ($category) {
                            return $this->category['title'];
                        })->filter(
                            Grid\Column\Filter\Equal::make()->valueFilter()->hide()
                        );

            $grid->tags->display(function($tags){
                            $tagHtml = '';
                            foreach ($tags as $tag) {
                                $tagHtml .= '<div class="label" style="background:#5c6bc6;display: block;line-height: 16px;width: fit-content;">'.$tag['title'].'</div>';
                            }
                            return $tagHtml;
                        });
            $grid->filter(function ($filter) {
                $filter->scope('trashed', '回收站')->onlyTrashed();
            });
            $grid->column('order')->editable();
            $grid->state->switchGroup([
                'is_show',
                'is_comment'
            ]);
            $grid->created_at->width('160px');
            $grid->updated_at->width('160px')->sortable();
            $grid->disableViewButton();
            $grid->setActionClass(Grid\Displayers\Actions::class);

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if (request('_scope_') == 'trashed') {
                    $actions->append(new Restore(ArticleModel::class));
                }
            });

            $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                if (request('_scope_') == 'trashed') {
                    $batch->add(new BatchRestore(ArticleModel::class));
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
        return Show::make($id, new Article(), function (Show $show) {
            $show->id;
            $show->title;
            $show->catid;
            $show->tags;
            $show->desc;
            $show->order;
            $show->is_show;
            $show->is_comment;
            $show->comment;
            $show->likes;
            $show->views;
            $show->image;
            $show->content;
            // dd($show->content);
            $show->attachment;
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
        return Form::make(ArticleModel::with(['category','tags']), function (Form $form) {
            $form->setDefaultBlockWidth(9);
            $form->width(11,1);
            $form->text('title')->rules('required');
            $form->markdown('content');
            $form->textarea('desc');
            $form->select('catid')->rules('required')->options(function (){
                return CategoryModel::selectOptionsFind();
            });

            $form->tags('tags')->pluck('title', 'id')->options(TagModel::all())->saving(function ($value) {
                if ($value) {
                    $array = explode(',', $value);
                    $data = [];
                    foreach ($array as $key => $val) {
                        if (is_numeric($val)) {
                            $data[] = $val;
                        } else {
                            $flight = TagModel::create(['title' => $val]);
                            $data[] = $flight->id;
                        }
                    }
                    return $data;
                }
            });
            $form->display('id');
            $form->image('image');

            $form->file('attachment');

            // 分块显示
            $form->block(3, function (Form\BlockForm $form) {
                $form->title('其他');
                $form->width(9,3);
                $form->number('order')->default('100');
                $form->switch('original');
                $form->url('originalurl');

                $form->divider();

                $form->switch('is_show')->default('1');
                $form->switch('is_comment')->default('0');

                // $form->number('comment')->default('0');
                $form->number('likes')->default('0');
                $form->number('views')->default('0');

                // $form->display('created_at');
                // $form->display('updated_at');
            });
            $form->disableHeader();
            $form->footer(function ($footer) {
                // 去掉`重置`按钮
                $footer->disableReset();
                // 去掉`查看`checkbox
                $footer->disableViewCheck();
                // 去掉`继续编辑`checkbox
                $footer->disableEditingCheck();
                // 去掉`继续创建`checkbox
                $footer->disableCreatingCheck();
            });

            $form->saving(function (Form $form) {
                $descS = $form->desc;
                $content = $form->content;
                // 为空的话截取内容前5行
                if (empty($descS) && !empty($content)) {
                    $desc = '';
                    $contentArr = explode("\r\n",$form->content);
                    $inx = count($contentArr) > 6 ? 6 : count($contentArr);
                    for ($i = 0; $i < $inx; $i++) { 
                        $desc .= $contentArr[$i]."\r\n";
                    }
                    $form->desc = $desc;
                }
            });
        });
    }

}
