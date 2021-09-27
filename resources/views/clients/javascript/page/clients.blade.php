<script>
    var clients_table, clients_editor;
    $(document).ready(function () {
        //var editor_create = null;
        $("#editor-save-btn").click(function (e) {
            clients_editor.submit();
        });
        /*
         * Select2
         */
        $("#client-select").select2({
            theme: "bootstrap"
        });
        $("#active-select").select2({
            theme: "bootstrap"
        });
        $("#genders-select").select2({
            theme: "bootstrap"
        });
        /***** INIT CUSTOMERS EDITOR *****/
        clients_editor = new $.fn.dataTable.Editor({
            ajax: {
                create: '/clients/add',
                edit: {
                    type: 'PUT',
                    url: '/clients/edit/_id_'
                },
                remove: {
                    type: 'DELETE',
                    url: '/clients/delete/_id_',
                    deleteBody: false
                }
            },
            table: "#clients-table",
            template: "#clients-editor",
            formOptions: {
                main: {
                    focus: null,
                    onBackground: false,
                    onFieldError: 'none'
                }
            },
            fields: [
                {
                    label: "Client Name:",
                    name: "clients.name"
                }, {
                    label: "Registered Name:",
                    name: "clients.registered_name"
                }, {
                    label: "Client Code:",
                    name: "clients.code"
                }, {
                    label: "VAT Number:",
                    name: "clients.vat_number"
                }, {
                    label: "Reg Number:",
                    name: "clients.registration_number"
                }, {
                    label: "Pastel Code:",
                    name: "clients.pastel_code"
                }, {
                    label: "Active:",
                    name: "clients.active",
                    type: "radio",
                    options: [
                        {label: "Active", value: 1},
                        {label: "Inactive", value: 0}
                    ],
                    def: 1
                }, {
                    label: "Invoice Active:",
                    name: "clients.invoice_active",
                    type: "radio",
                    options: [
                        {label: "Active", value: 1},
                        {label: "Inactive", value: 0}
                    ],
                    def: 1
                }, {
                    label: "Opening Balance:",
                    name: "clients.opening_balance",
                    def: 0,
                    attr: {
                        'data-inputmask': "'digits': 2"
                    }
                }, {
                    label: "Deposit:",
                    name: "clients.deposit",
                    def: 0,
                    attr: {
                        'data-inputmask': "'digits': 2"
                    }
                }, {
                    label: "Balance Start Date:",
                    name: "clients.opening_balance_date",
                    type: "datetime",
                    format: 'DD/MM/YYYY',
                    def: function () {
                        var now = moment();
                        return now.startOf('month').format('DD/MM/YYYY');
                    }
                }, {
                    label: "Payment Terms:",
                    name: "clients.gender_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "Address 1:",
                    name: "clients.billing_address_1"
                }, {
                    label: "Address 2:",
                    name: "clients.billing_address_2"
                }, {
                    label: "Address 3:",
                    name: "clients.billing_address_3"
                }, {
                    label: "Post Code:",
                    name: "clients.billing_post_code"
                }, {
                    label: "Tel No:",
                    name: "clients.tel_no",
                    type: "mask",
                    mask: "(000) 000 0000",
                    maskOptions: {
                        placeholder: "(ext) 555 5555"
                    }
                }, {
                    label: "Cell No:",
                    name: "clients.cell_no",
                    type: "mask",
                    mask: "(000) 000 0000",
                    maskOptions: {
                        placeholder: "(ext) 555 5555"
                    }
                }, {
                    label: "Fax No:",
                    name: "clients.fax_no",
                    type: "mask",
                    mask: "(000) 000 0000",
                    maskOptions: {
                        placeholder: "(ext) 555 5555"
                    }
                }, {
                    label: "Contact:",
                    name: "clients.contact_person"
                }, {
                    label: "Account Contact:",
                    name: "clients.account_contact_person"
                }, {
                    label: "Email:",
                    name: "clients.email",
                    attr: {
                        placeholder: "example@company.co.za"
                    }
                }, {
                    label: "Account Email:",
                    name: "clients.account_email",
                    attr: {
                        placeholder: "example_1@company.co.za; example_2@company.co.za",
                        maxlength: 300
                    }
                }, {
                    label: "Account CC Email:",
                    name: "clients.account_cc_email",
                    attr: {
                        placeholder: "example_1@company.co.za; example_2@company.co.za",
                        maxlength: 300
                    }
                }
            ]
        });
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
                    $("#genders-select").val(0).trigger('change');
                }
            }
        ]);
        clients_table.buttons().container().appendTo($('.col-sm-6:eq(0)', clients_table.table().container()));
        clients_editor.on('postSubmit', function (e, json, data, action) {
            if ((json.hasOwnProperty('data') && !json.hasOwnProperty('fieldErrors')) || (json.hasOwnProperty('data') && !json.hasOwnProperty('error'))) {
                var key = Object.keys(json['data']);
                var info = json['data'][key];
                switch (action) {
                    case 'create':
                        flash_message("Client " + info['clients']['name'] + " has been successfully added", "success");
                        break;
                    case 'edit':
                        flash_message("Client " + info['clients']['name'] + "  has been successfully updated", "success");
                        break;
                    case 'remove':
                        flash_message("Client has been successfully removed", "success");
                        break;
                }
            }
        }).on('submitComplete', function (e, json, data) {
            tabError('#company-tab', false);
            tabError('#payment-tab', false);
            tabError('#contact-tab', false);
            if (json.hasOwnProperty('fieldErrors') && json['fieldErrors'].length > 0) {
                clients_editor.error("One or more error(s) have occured. Please check the alerted tab icons!");
            }
        }).on('open', function (e) {
            firstTab();
        }).on('close', function (e) {
            tabError('#company-tab', true);
            tabError('#payment-tab', true);
            tabError('#contact-tab', true);
            $('.summary_wizard_information > span').empty();
        });
        $('body').popover({
            selector: '[data-toggle="popover"]'
        });
        currency_mask.mask($(clients_editor.field('clients.opening_balance').input()));
        currency_mask.mask($(clients_editor.field('clients.deposit').input()));
        $(clients_editor.displayNode()).addClass('modal-multi-columns');
    }); //End of document

    function tabError(selector, clear) {
        $("ul.nav-tabs > li").has("a[href='" + selector + "']").removeClass('error');
        $("ul.nav-tabs > li > a[href='" + selector + "']").removeClass('alert alert-danger');
        if ($(selector + ' .has-error').length > 0 && clear === false) {
            $("ul.nav-tabs > li").has("a[href='" + selector + "']").addClass('error');
            $("ul.nav-tabs > li > a[href='" + selector + "']").addClass('alert alert-danger');
        }
    }
</script>
