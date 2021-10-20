<script type="text/javascript">
    let carers_editor;
    $(document).ready(function () {
        /***** INIT EDITOR *****/
        carers_editor = new $.fn.dataTable.Editor({
            ajax: {
                create: '/carers/details/create',
                edit: {
                    type: 'PUT',
                    url: '/carers/details/_id_/update'
                },
                remove: {
                    type: 'DELETE',
                    url: '/carers/details/_id_/remove'
                }
            },
            table: "#carers-table",
            template: "#carers-editor",
            formOptions: {
                main: {
                    focus: null
                }
            },
            fields: [
                // Student Details
                {
                    label: "Name:",
                    name: "carers.name"
                },
                {
                    label: "Surname:",
                    name: "carers.surname"
                },
                {
                    label: "Healthcare No.:",
                    name: "carer_details.health_care_number"
                }, {
                    label: "Employee No.:",
                    name: "carer_details.employee_number"
                }, {
                    label: "Gender:",
                    name: "carer_details.gender_id",
                    type: "select2",
                    def: 0
                },
                {
                    label: "Active:",
                    name: "carers.active",
                    type: "radio",
                    options: [
                        {label: "Active", value: 1},
                        {label: "Inactive", value: 0}
                    ],
                    def: 1
                }, {
                    label: "Image:",
                    name: "carers.image",
                    type: "upload",
                    display: function (file_id) {
                        return '<span style="font-size: 11px">' + carers_editor.file('carers', file_id).upload_name + '</span>';
                    },
                    ajax: {
                        url: '/carers/details/upload'
                    },
                    attr: {
                        accept: 'image/jpeg,image/png'
                    },
                    clearText: "Clear",
                    noImageText: 'No data uploaded'
                }, {
                    label: "DOB:",
                    name: "carer_details.date_of_birth",
                    type: "datetime",
                    format: 'DD/MM/YYYY'
                }, {
                    label: "Start Date:",
                    name: "carer_details.start_date",
                    type: "datetime",
                    format: 'DD/MM/YYYY'
                }, {
                    label: "End Date:",
                    name: "carer_details.end_date",
                    type: "datetime",
                    format: 'DD/MM/YYYY'
                },
                // Contact Details
                {
                    label: "Address 1:",
                    name: "carer_details.address_1"
                }, {
                    label: "Address 2:",
                    name: "carer_details.address_2"
                }, {
                    label: "Address 3:",
                    name: "carer_details.address_3"
                }, {
                    label: "County:",
                    name: "carer_details.county"
                }, {
                    label: "Postcode:",
                    name: "carer_details.post_code"
                },
                {
                    label: "Next of Kin:",
                    name: "carer_details.next_of_kin"
                },
                {
                    label: "Relationship:",
                    name: "carer_details.next_of_kin_relationship"
                },
                {
                    label: "Phone No:",
                    name: "carer_details.next_of_kin_phone"
                },
                // Login Details
                {
                    label: "E-mail:",
                    name: "carers.email",
                    attr: {
                        placeholder: "user@company.com"
                    }
                }, {
                    label: "Username:",
                    name: "carers.username"
                }, {
                    label: "Phone No:",
                    name: "carer_details.phone_number"
                }, {
                    label: "Password:",
                    name: "carers.password",
                    type: "password"
                }, {
                    label: "Confirm:",
                    name: "carers.password_confirmation",
                    type: "password"
                }, {
                    label: "Roles:",
                    name: "carer_roles[].role_id",
                    type: "select2",
                    opts: {
                        multiple: true,
                        allowClear: true,
                        minimumResultsForSearch: 1
                    }
                }]
        });
    });
</script>
