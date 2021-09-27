<script type="text/javascript">
    var clients_editor;
    $(document).ready(function () {
        
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
                    label: "First Name:",
                    name: "clients.name"
                }, {
                    label: "Last Name:",
                    name: "clients.surname"
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
                    name: "clients.payment_term_id",
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
        
    });
    
      function tabError(selector, clear) {
        $("ul.nav-tabs > li").has("a[href='" + selector + "']").removeClass('error');
        $("ul.nav-tabs > li > a[href='" + selector + "']").removeClass('alert alert-danger');
        if ($(selector + ' .has-error').length > 0 && clear === false) {
            $("ul.nav-tabs > li").has("a[href='" + selector + "']").addClass('error');
            $("ul.nav-tabs > li > a[href='" + selector + "']").addClass('alert alert-danger');
        }
    }
</script>