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
                    label: "Student Number:",
                    name: "carers.student_number"
                }, {
                    label: "Institution:",
                    name: "carers.institution_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "Student Type:",
                    name: "carers.student_type_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "Title:",
                    name: "carers.title_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "Gender:",
                    name: "carers.gender_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "Enthnicty:",
                    name: "carers.equity_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "Nationality:",
                    name: "carers.nationality_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "Residency:",
                    name: "carers.resident_status_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "Language:",
                    name: "carers.language_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "SocioEco Status:",
                    name: "carers.socio_status_id",
                    type: "select2",
                    def: 0
                },
                {
                    label: "Initials:",
                    name: "carers.initials"
                },
                {
                    label: "Middle Name:",
                    name: "carers.middle_name"
                },
                {
                    label: "Surname:",
                    name: "carers.surname"
                },
                {
                    label: "ID No:",
                    name: "carers.id_number"
                },
                {
                    label: "Alternative ID No:",
                    name: "carers.alternative_id_number"
                }, {
                    label: "ID Type:",
                    name: "carers.identification_type_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "Active:",
                    name: "carers.active",
                    type: "radio",
                    options: [
                        {label: "Active", value: 1},
                        {label: "Inactive", value: 0}
                    ],
                    def: 1
                }, {
                    label: "Identification Type:",
                    name: "carers.id_type",
                    type: "radio",
                    options: [
                        {label: "ID No.", value: 1},
                        {label: "Other", value: 0}
                    ],
                    def: 1
                }, {
                    label: "DOB:",
                    name: "carers.date_of_birth",
                    type: "datetime",
                    format: 'DD/MM/YYYY',
                    def: function () {
                        return new Date();
                    }
                }, {
                    label: "Date Registered:",
                    name: "carers.date_registered",
                    type: "datetime",
                    format: 'DD/MM/YYYY',
                    def: function () {
                        return new Date();
                    }
                },
                // Contant Details
                {
                    label: "Municipality:",
                    name: "carers.home_municipality_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "Province:",
                    name: "carers.home_province_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "Municipality:",
                    name: "carers.postal_municipality_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "Province:",
                    name: "carers.postal_province_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "Address 1:",
                    name: "carers.home_address_1"
                }, {
                    label: "Address 2:",
                    name: "carers.home_address_2"
                }, {
                    label: "Address 3:",
                    name: "carers.home_address_3"
                }, {
                    label: "Postcode:",
                    name: "carers.home_post_code"
                }, {
                    label: "Address 1:",
                    name: "carers.postal_address_1"
                }, {
                    label: "Address 2:",
                    name: "carers.postal_address_2"
                }, {
                    label: "Address 3:",
                    name: "carers.postal_address_3"
                }, {
                    label: "Postcode:",
                    name: "carers.postal_post_code"
                },
                {
                    label: "Fax No:",
                    name: "carers.fax"
                },
                {
                    label: "Email:",
                    name: "carers.email",
                    attr: {
                        placeholder: "example_1@company.co.za; example_2@company.co.za",
                        maxlength: 300
                    }
                },
                {
                    label: "Cell No:",
                    name: "carers.cell_number"
                },
                {
                    label: "Telephone No:",
                    name: "carers.telephone_number"
                },
                {
                    label: "Fax No:",
                    name: "carers.fax_number"
                },

                // Health Detais
                {
                    label: "Seeing:",
                    name: "carers.seeing_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "Hearing:",
                    name: "carers.hearing_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "Selfcare:",
                    name: "carers.selfcare_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "Communicating:",
                    name: "carers.communicating_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "Walking:",
                    name: "carers.walking_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "Remembering:",
                    name: "carers.remembering_id",
                    type: "select2",
                    def: 0
                }, {
                    label: "Upload:",
                    name: "carers.upload",
                    type: "upload",
                    display: function (file_id) {
                        return '<span style="font-size: 11px">' + carers_editor.file('carers', file_id).upload_name + '</span>';
                    },
                    ajax: {
                        url: '/carers/upload'
                    },
                    attr: {
                        accept: '.csv'
                    },
                    clearText: "Clear",
                    noImageText: 'No data uploaded'
                }, {
                    label: "Institution:",
                    name: "carers.additional_institution_id",
                    type: "select2",
                    def: 0
                }]
        });
    });
</script>
