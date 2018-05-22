define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'wifi/clock/record/index',
                    add_url: 'wifi/clock/record/add',
                    edit_url: 'wifi/clock/record/edit',
                    del_url: 'wifi/clock/record/del',
                    multi_url: 'wifi/clock/record/multi',
                    table: 'wifi_clock_record',
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
                        {field: 'admin_id', title: __('Admin_id')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'clock_place', title: __('Clock_place')},
                        {field: 'lat', title: __('Lat'), operate:'BETWEEN'},
                        {field: 'lon', title: __('Lon'), operate:'BETWEEN'},
                        {field: 'wifiname', title: __('Wifiname')},
                        {field: 'wifi_distance', title: __('Wifi_distance')},
                        {field: 'gps_distance', title: __('Gps_distance')},
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