<script type='text/javascript'>
    let clients_table;
    $(document).ready(function () {
        /***** INIT TABLE  *****/
        clients_table = $('#clients-table').DataTable({
            pageLength: 10,
            processing: true,
            ajax: {
                url: '/clients/index',
                type: 'GET',
                data: function (d) {
                }
            },
            columns: [
                {data: null, defaultContent: '', orderable: false, sClass: 'selector'},
                {data: 'clients.name'},
                {data: 'clients.surname'},
                {data: 'clients.email'},
                {data: null, render: function (data, type, row) {
                        if (row['clients']['active'] == "0") {
                            return "Inactive";
                        } else {
                            return "Active";
                        }
                    }},
                {data: 'clients.image'}
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
        new $.fn.dataTable.Buttons(clients_table, {
            buttons: [{
                extend: 'create', text: 'Add', className: 'dt-btn dt-btn-first', attr: {title: 'Add a new Client'},
                action: function () {
                    clients_editor.create({
                        title: '<h3>Add: Client</h3>',
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
                    clients_editor.edit(clients_table.row({selected: true}).indexes(), {
                        title: '<h3>Edit: Client</h3>',
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
                    clients_editor.title('<h3>Delete: Client</h3>').buttons([
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
                    ]).message('Are you sure you want to delete this Client record?').remove(clients_table.row({selected: true}));
                }
            }]
        });
        clients_table.buttons().container().appendTo($('.col-md-6:eq(0)', clients_table.table().container()));
        clients_editor.on('preSubmit', function (e, d) {
            if (clients_editor.mode() == 'remove') {
                $.each(d.data, function (key, val) {
                    d.data[key] = true;
                });
            }
        });
        clients_editor.on('postSubmit', function (e, json, data, action) {
            if ((json.hasOwnProperty('data') && !json.hasOwnProperty('fieldErrors')) || (json.hasOwnProperty('data') && !json.hasOwnProperty('error'))) {
                var key = Object.keys(json['data']);
                var info = json['data'][key];
                switch (action) {
                    case 'create':
                        flash_message('Client ' + info['clients']['first_name'] + ' ' + info['clients']['surname'] + ' has been successfully added', 'success');
                        break;
                    case 'edit':
                        flash_message('Client ' + info['clients']['first_name'] + ' ' + info['clients']['surname'] + ' has been successfully updated', 'success');
                        break;
                    case 'remove':
                        flash_message('Client record has been successfully removed', 'success');
                        break;
                }
            }
        }).on('submitComplete', function (e, json, data) {
            tabError('#details-tab', false);
            tabError('#access-tab', false);
            tabError('#address-tab', false);
            if (json.hasOwnProperty('fieldErrors') && json['fieldErrors'].length > 0) {
                clients_editor.error("One or more error(s) have occured. Please check the alerted tab icons!");
            }
        }).on('open', function (e) {
            firstTab();
        }).on('close', function (e) {
            tabError('#details-tab', true);
            tabError('#access-tab', true);
            tabError('#address-tab', true);
            $('.summary_wizard_information > span').empty();
        });
        $(clients_editor.displayNode()).addClass('modal-multi-columns');

    });
</script>
