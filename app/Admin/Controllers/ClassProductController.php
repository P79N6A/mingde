<?php

namespace App\Admin\Controllers;

use App\ClassProduct;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\ClassChannel;
use App\ClassClothing;

class ClassProductController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('产品列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('修改产品')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('创建产品')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ClassProduct);

        $grid->id('Id');
        $grid->number('商品编号');
        $grid->title('标题');
        $grid->channel('渠道');
        $grid->city('城市');
        $grid->day('行程天数');
        $grid->created_at('创建时间');
        $grid->start_time_to('预计开始时间');
        $grid->is_show('是否展示');
        $grid->status('行程状态');
        $grid->is_onoff('是否可报名');

        $grid->disableRowSelector();
        $grid->disableActions();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(ClassProduct::findOrFail($id));

        $show->id('Id');
        $show->title('Title');
        $show->title_fit('Title fit');
        $show->price('Price');
        $show->sale('Sale');
        $show->sort('Sort');
        $show->is_recommend('Is recommend');
        $show->is_show('Is show');
        $show->is_onoff('Is onoff');
        $show->image1('Image1');
        $show->image2('Image2');
        $show->image3('Image3');
        $show->text_item('Text item');
        $show->text_introduce('Text introduce');
        $show->text_arrange('Text arrange');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->is_del('Is del');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ClassProduct);

        $form->text('title', '标题');
        $form->text('title_fit', '副标题');
        $channels = ClassChannel::where('is_del', 0)->get()->toArray();
        foreach ($channels as $k=>$v) {
            $selectchannel[$v['id']] = $v['name'];
        }
        $form->select('channel','渠道')->options($selectchannel);
        $clothing= ClassClothing::where('is_del', 0)->get()->toArray();
        foreach($clothing as $k=>$v){
            $selectclot[$v['id']] = $v['name'];
        }
        $form->select('clothing','服装')->options($selectclot);
        $form->text('city', '城市');
        $form->text('fit', '适应人群');
        $form->number('day', '行程天数');
        $form->date('start_time_to', '预计开始时间');
        $form->date('start_time', '开始时间');
        $form->date('end_time', '结束时间');
        $form->currency('price', '产品价格')->symbol('￥');
        $form->text('sale', '销售');
        $form->number('sort', '排序');
        $form->switch('is_recommend', '是否推荐');
        $form->switch('is_show', '是否显示');
        $form->switch('is_onoff', '是否可报名');
        $form->text('image1', 'Image1');
        $form->image('image1')->move('public/upload/classimage/')->uniqueName();
        $form->image('image2')->move('public/upload/classimage/')->uniqueName();
        $form->image('image3')->move('public/upload/classimage/')->uniqueName();
        $form->editor('text_item','特色');
        $form->editor('text_introduce','课程介绍');
        $form->editor('text_arrange','课程安排');
        $form->tools(function (Form\Tools $tools) {
            // 去掉`列表`按钮
            $tools->disableList();
        });
        $form->footer(function ($footer) {
            // 去掉`提交`按钮
            $footer->disableSubmit();

        });
        return $form;
    }
}