<script type="text/javascript">
    var clients_table, download_table;
    $(document).ready(function () {
        /***** INIT CUSTOMERS TABLE *****/
        clients_table = $('#clients-table').DataTable({
            processing: true,
            tabIndex: 1,
            pageLength: 10,
            ajax: {
                url: '/clients',
                type: "GET",
                data: function (d) {
                    d.client_id = $('#client-select').val();
                    d.gender_id = $('#genders-select').val();
                    d.active_id = $('#active-select').val();
                }
            },
            columns: [
                {data: null, defaultContent: '', orderable: false, sClass: "selector"},
                {data: "clients.code"},
                {data: "clients.name"},
                {data: "clients.registered_name"},
                {data: null, render: function (data, type, row) {
                        if (row['clients']['contact_person'] != null) {
                            return row['clients']['contact_person'];
                        } else {
                            return "N/A";
                        }
                    }},
                {data: null, render: function (data, type, row) {
                        if (row['clients']['email'] != null) {
                            return row['clients']['email'];
                        } else {
                            return "N/A";
                        }
                    }},
                {data: null, render: function (data, type, row) {
                        if (row['clients']['tel_no'] != null) {
                            return row['clients']['tel_no'];
                        } else {
                            return "N/A";
                        }
                    }},
                {data: null, render: function (data, type, row) {
                        if (row['clients']['cell_no'] != null) {
                            return row['clients']['cell_no'];
                        } else {
                            return "N/A";
                        }
                    }},
                {data: "genders.description", editField: "clients.gender_id"},
                {data: null, render: function (data, type, row) {
                        if (row['clients']['vattable'] == "0") {
                            return "No";
                        } else {
                            return "Yes";
                        }
                    }},
                {data: null, render: function (data, type, row) {
                        if (row['clients']['active'] == "0") {
                            return "No";
                        } else {
                            return "Yes";
                        }
                    }}
            ],
            columnDefs: [
                {className: "dt-cell-right", targets: []}, //Align table body cells to right
                {className: "dt-cell-left", targets: [1, 2, 3, 4, 5, 6, 7, 8]}, //Align table body cells to left
                {className: "dt-cell-center", targets: [0, 9, 10]}, //Align table body cells to center
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
        new $.fn.dataTable.Buttons(clients_table, [
            {extend: 'create', text: 'Add', className: "add-client",
                action: function () {
                    clients_editor.create({
                        title: '<h3>Add: Client</h3>',
                        buttons: [{
                                label: 'Close',
                                fn: function (e) {
                                    this.close();
                                }
                            }
                        ]
                    });
                }
            },
            {extend: 'edit', text: 'Edit', className: "edit-client",
                action: function () {
                    clients_editor.edit(clients_table.rows({selected: true}).indexes(), {
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
            },
            {
                extend: 'remove',
                text: 'Delete',
                action: function () {
                    clients_editor.title('<h3>Delete: Client</h3>').buttons([
                        {label: 'Delete', fn: function () {
                                this.submit();
                            }},
                        {label: 'Cancel', fn: function () {
                                this.close();
                            }}
                    ]).message('Are you sure you want to delete this client?').remove(clients_table.row({selected: true}));
                }
            }, {
                text: '<i class="fas fa-sync" aria-hidden="true" rel="tooltip" title="Refresh table results"></i>', className: "special-button", titleAttr: 'Refresh table result',
                action: function () {
                    clients_table.ajax.reload();
                }
            }, {
                text: '<i class="fas fa-filter" aria-hidden="true" rel="tooltip" title="Reset filters to default values"></i>', className: "special-button", titleAttr: 'Reset filters to default values',
                action: function () {
                    $("#client-select").val(0).trigger('change');
                    $("#contact-select").val(0).trigger('change');
                    $("#payment-terms-select").val(0).trigger('change');
                }
            }
        ]);
        clients_table.buttons().container().appendTo($('.col-sm-6:eq(0)', clients_table.table().container()));
    });
</script>