<script type='text/javascript'>
    let carers_table;
    $(document).ready(function () {
        /***** INIT TABLE  *****/
        carers_table = $('#carers-table').DataTable({
            pageLength: 10,
            processing: true,
            ajax: {
                url: '/carers/details/index',
                type: 'GET',
                data: function (d) {
                }
            },
            columns: [
                {data: null, defaultContent: '', orderable: false, sClass: 'selector'},
                {data: 'carers.first_name'},
                {data: 'carers.surname'},
                {data: 'carers.email'},
                {data: 'carers.active'},
                {data: 'carers.image'}
            ],
            columnDefs: [
                {className: 'dt-cell-left', targets: [1, 2, 3]}, //Align table body cells to left
                {className: 'dt-cell-center', targets: [0, 4, 5]}, //Align table body cells to center
                {searchable: false, targets: 0}
            ],
            order: [1, 'asc'],
            bLengthChange: false,
            select: {
                style: 'single',
                selector: 'td:first-child'
            }
        });
        // Display the buttons
        //https://datatables.net/extensions/buttons/custom
        new $.fn.dataTable.Buttons(carers_table, {
            buttons: [{
                extend: 'create', text: 'Add', className: 'dt-btn dt-btn-first', attr: {title: 'Add a new Carer'},
                action: function () {
                    carers_editor.create({
                        title: '<h3>Add: Carer</h3>',
                        buttons: [
                            {
                                label: 'Add',
                                fn: function (e) {
                                    this.submit();
                                }
                            },
                            {
                                label: 'Close',
                                fn: function (e) {
                                    this.close();
                                }
                            }
                        ]
                    });
                }
            }, {
                extend: 'edit', text: 'Edit', className: 'dt-btn', attr: {title: 'Edit the data'},
                action: function () {
                    carers_editor.edit(carers_table.row({selected: true}).indexes(), {
                        title: '<h3>Edit: Carer</h3>',
                        buttons: [
                            {
                                label: 'Update',
                                fn: function (e) {
                                    this.submit();
                                }
                            },
                            {
                                label: 'Cancel',
                                fn: function (e) {
                                    this.close();
                                }
                            }
                        ]
                    });
                }
            }, {
                extend: 'remove',
                text: 'Delete',
                className: 'dt-btn dt-btn-last',
                action: function () {
                    carers_editor.title('<h3>Delete: Carer</h3>').buttons([
                        {
                            label: 'Delete', fn: function () {
                                this.submit();
                            }
                        },
                        {
                            label: 'Cancel', fn: function () {
                                this.close();
                            }
                        }
                    ]).message('Are you sure you want to delete this Carer record?').remove(carers_table.row({selected: true}));
                }
            }]
        });
        carers_table.buttons().container().appendTo($('.col-md-6:eq(0)', carers_table.table().container()));
        carers_editor.on('preSubmit', function (e, d) {
            if (carers_editor.mode() == 'remove') {
                $.each(d.data, function (key, val) {
                    d.data[key] = true;
                });
            }
        });
        carers_editor.on('postSubmit', function (e, json, data, action) {
            if ((json.hasOwnProperty('data') && !json.hasOwnProperty('fieldErrors')) || (json.hasOwnProperty('data') && !json.hasOwnProperty('error'))) {
                var key = Object.keys(json['data']);
                var info = json['data'][key];
                switch (action) {
                    case 'create':
                        flash_message('Carer ' + info['carers']['first_name'] + ' ' + info['carers']['surname'] + ' has been successfully added', 'success');
                        break;
                    case 'edit':
                        flash_message('Carer ' + info['carers']['first_name'] + ' ' + info['carers']['surname'] + ' has been successfully updated', 'success');
                        break;
                    case 'remove':
                        flash_message('Carer record has been successfully removed', 'success');
                        break;
                }
            }
        });

        $(carers_editor.displayNode()).addClass('modal-multi-columns');

    });
</script>
