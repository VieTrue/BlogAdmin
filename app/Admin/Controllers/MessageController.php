<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Message;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use App\Models\Message as MessageModel;

class MessageController extends AdminController
{
    // use PreviewCode;

    public function index(Content $content)
    {
        // echo 1;
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
        return Grid::make(new Message(), function (Grid $grid) {
            $grid->responsive();
            // $grid->disableActions();
            $grid->disableBatchDelete();
            $grid->disableCreateButton();

            $grid->id->sortable();
            $grid->name->responsive();
            $grid->tel->responsive();
            $grid->msg->responsive();
            $grid->qd->display(function ($value) {
                return admin_trans('message.qudao.'.$value.'.0');
            })->responsive();
            $grid->ip->responsive();
            $grid->url->responsive();
            $grid->city->responsive();
            $grid->created_at->sortable()->responsive();
            $grid->updated_at->sortable()->responsive();

            $grid->tools();
            $grid->selector(function (Grid\Tools\Selector $selector) {
                foreach (admin_trans('message.qudao') as $key => $val) {
                    $arr[] = $val[0];
                }
                $selector->select('qd', '渠道', $arr);
            });

            // $grid->disableCreateButton();
            $grid->disableQuickEditButton();
            $grid->disableEditButton();
            $grid->disableViewButton();

            $grid->setActionClass(Grid\Displayers\Actions::class);

            // $grid->filter(function (Grid\Filter $filter) {
            //     $filter->equal('id');
            // });
        });
    }

    /**
     * @param mixed $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $ids = explode(',', $id);

        if (MessageModel::destroy(array_filter($ids))) {
            $data = [
                'status'  => true,
                'message' => trans('admin.delete_succeeded'),
            ];
        } else {
            $data = [
                'status'  => false,
                'message' => trans('admin.delete_failed'),
            ];
        }

        return response()->json($data);
    }


}
