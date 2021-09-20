(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'datatables', 'datatables-editor'], factory);
    } else if (typeof exports === 'object') {
        // Node / CommonJS
        module.exports = function ($, dt) {
            if (!$) {
                $ = require('jquery');
            }
            factory($, dt || $.fn.dataTable || require('datatables'));
        };
    } else if (jQuery) {
        // Browser standard
        factory(jQuery, jQuery.fn.dataTable);
    }
}

(function ($, DataTable) {
    'use strict';

    if (!DataTable.ext.editorFields) {
        DataTable.ext.editorFields = {};
    }

    function _triggerChange(input) {
        setTimeout(function () {
            input.trigger('change', {editor: true, editorSet: true}); // editorSet legacy
        }, 0);
    }

    var baseFieldType = $.extend(true, {}, DataTable.Editor.models.fieldType, {
        get: function (conf) {
            return conf._input.val();
        },

        set: function (conf, val) {
            conf._input.val(val);
            _triggerChange(conf._input);
        },

        enable: function (conf) {
            conf._input.prop('disabled', false);
        },

        disable: function (conf) {
            conf._input.prop('disabled', true);
        },

        canReturnSubmit: function (conf, node) {
            return true;
        }
    });

    var _fieldTypes = DataTable.Editor ?
            DataTable.Editor.fieldTypes :
            DataTable.ext.editorFields;
    /*
     Virtual Realms
     Added in ability to see data-* attributes
     */
    //_fieldTypes.select2 = null;
    //fieldTypes
    _fieldTypes.checkbox = $.extend(true, {}, baseFieldType, {
        // Locally "private" function that can be reused for the create and update methods
        _addOptions: function (conf, opts, append) {
            var val, label;
            var jqInput = conf._input;
            var offset = 0;

            if (!append) {
                jqInput.empty();
            } else {
                offset = $('input', jqInput).length;
            }

            if (opts) {
                DataTable.Editor.pairs(opts, conf.optionsPair, function (val, label, i, attr) {
                    let name = ('attr' in conf && 'name' in conf.attr ? conf.attr.name : DataTable.Editor.safeId(conf.id));
                    jqInput.append(
                            '<div>' +
                            '<input id="' + DataTable.Editor.safeId(conf.id) + '_' + val + '" name="' + name + '" type="checkbox" />' +
                            '<label for="' + DataTable.Editor.safeId(conf.id) + '_' + val + '">' + label + '</label>' +
                            '</div>'
                            );
                    $('input:last', jqInput).attr('value', val)[0]._editor_val = val;

                    if (attr) {
                        $('input:last', jqInput).attr(attr);
                    }
                });
            }
        },

        create: function (conf) {
            conf._input = $('<div></div>');
            _fieldTypes.checkbox._addOptions(conf, conf.options || conf.ipOpts);

            return conf._input[0];
        },

        get: function (conf) {
            var out = [];
            var selected = conf._input.find('input:checked');

            if (selected.length) {
                selected.each(function () {
                    out.push(this._editor_val);
                });
            } else if (conf.unselectedValue !== undefined) {
                out.push(conf.unselectedValue);
            }

            return conf.separator === undefined || conf.separator === null ?
                    out :
                    out.join(conf.separator);
        },

        set: function (conf, val) {
            var jqInputs = conf._input.find('input');
            if (!$.isArray(val) && typeof val === 'string') {
                val = val.split(conf.separator || '|');
            } else if (!$.isArray(val)) {
                val = [val];
            }

            var i, len = val.length, found;

            jqInputs.each(function () {
                found = false;

                for (i = 0; i < len; i++) {
                    if (this._editor_val == val[i]) {
                        found = true;
                        break;
                    }
                }

                this.checked = found;
            });

            _triggerChange(jqInputs);
        },

        enable: function (conf) {
            conf._input.find('input').prop('disabled', false);
        },

        disable: function (conf) {
            conf._input.find('input').prop('disabled', true);
        },

        update: function (conf, options, append) {
            // Get the current value
            var checkbox = _fieldTypes.checkbox;
            var currVal = checkbox.get(conf);

            checkbox._addOptions(conf, options, append);
            checkbox.set(conf, currVal);
        }
    });
}));