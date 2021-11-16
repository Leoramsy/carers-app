<script type="text/javascript">
    let clients_editor;
    $(document).ready(function () {
        /***** INIT EDITOR *****/
        clients_editor = new $.fn.dataTable.Editor({
            ajax: {
                create: '/clients/create',
                edit: {
                    type: 'PUT',
                    url: '/clients/_id_/update'
                },
                remove: {
                    type: 'DELETE',
                    url: '/clients/_id_/remove'
                }
            },
            table: "#clients-table",
            template: "#clients-editor",
            formOptions: {
                main: {
                    focus: null
                }
            },
            fields: [
                // Details
                {
                    label: "Name:",
                    name: "clients.name"
                },
                {
                    label: "Surname:",
                    name: "clients.surname"
                },
                {
                    label: "Healthcare No.:",
                    name: "clients.health_care_number"
                }, {
                    label: "Employee No.:",
                    name: "clients.employee_number"
                }, {
                    label: "Gender:",
                    name: "clients.gender_id",
                    type: "select2",
                    def: 0
                },
                {
                    label: "Active:",
                    name: "clients.active",
                    type: "radio",
                    options: [
                        {label: "Active", value: 1},
                        {label: "Inactive", value: 0}
                    ],
                    def: 1
                }, {
                    label: "Image:",
                    name: "clients.image",
                    type: "upload",
                    display: function (file_id) {
                        return '<span style="font-size: 11px">' + clients_editor.file('clients', file_id).upload_name + '</span>';
                    },
                    ajax: {
                        url: '/clients/details/upload'
                    },
                    attr: {
                        accept: 'image/jpeg,image/png'
                    },
                    clearText: "Clear",
                    noImageText: 'No data uploaded'
                }, {
                    label: "DOB:",
                    name: "clients.date_of_birth",
                    type: "datetime",
                    format: 'DD/MM/YYYY'
                }, {
                    label: "Start Date:",
                    name: "clients.start_date",
                    type: "datetime",
                    format: 'DD/MM/YYYY'
                }, {
                    label: "End Date:",
                    name: "clients.end_date",
                    type: "datetime",
                    format: 'DD/MM/YYYY'
                },
                // Contact Details
                {
                    label: "Address 1:",
                    name: "clients.address_1"
                }, {
                    label: "Address 2:",
                    name: "clients.address_2"
                }, {
                    label: "Address 3:",
                    name: "clients.address_3"
                }, {
                    label: "County:",
                    name: "clients.county"
                }, {
                    label: "Postcode:",
                    name: "clients.post_code"
                },
                {
                    label: "Next of Kin:",
                    name: "clients.next_of_kin"
                },
                {
                    label: "Relationship:",
                    name: "clients.next_of_kin_relationship"
                },
                {
                    label: "Phone No:",
                    name: "clients.next_of_kin_phone"
                },
                    {
                    label: "E-mail:",
                    name: "clients.email",
                    attr: {
                        placeholder: "user@company.com"
                    }
                },                
                {
                    label: "Phone No:",
                    name: "clients.phone_number"
                }]
        });
    });
</script>
