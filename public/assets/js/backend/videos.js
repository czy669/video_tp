define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'videos/index',
                    add_url: 'videos/add',
                    edit_url: 'videos/edit',
                    del_url: 'videos/del',
                    multi_url: 'videos/multi',
                    table: 'videos',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'title', title: __('Title')},
                        {field: 'cover', title: __('Cover'), operate: false, formatter: Table.api.formatter.image},
                        {field: 'tag', title: __('Tag')},
                        {field: 'play_time', title: __('Play_time')},
                        {field: 'status', title: __('Status'), visible:false, searchList: {"1":"显示","0":"隐藏"}},
                        {field: 'status_text', title: __('Status'), operate:false},
                        {field: 'hits', title: __('Hits')},
                        {field: 'type', title: __('Type')},
                        {field: 'area.title', title: __('Area.title')},
                        {field: 'cate.title', title: __('Cate.title')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});