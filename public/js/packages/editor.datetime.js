//$.extend( Editor.DateTime.prototype, {
/*
 * This file provides a DateTime GUI picker (calendar and time input). Only the
 * format YYYY-MM-DD is supported without additional software, but the end user
 * experience can be greatly enhanced by including the momentjs library which
 * provides date / time parsing and formatting options.
 *
 * This functionality is required because the HTML5 date and datetime input
 * types are not widely supported in desktop browsers.
 *
 * Constructed by using:
 *
 *     new Editor.DateTime( input, opts )
 *
 * where `input` is the HTML input element to use and `opts` is an object of
 * options based on the `Editor.DateTime.defaults` object.
 */
$.fn.DataTable.Editor.DateTime = function (input, opts) {
    this.c = $.extend(true, {}, $.fn.DataTable.Editor.DateTime.defaults, opts);
    var classPrefix = this.c.classPrefix;
    var i18n = this.c.i18n;

    // Only IS8601 dates are supported without moment
    if (!window.moment && this.c.format !== 'YYYY-MM-DD') {
        throw "Editor datetime: Without momentjs only the format 'YYYY-MM-DD' can be used";
    }

    var timeBlock = function (type) {
        return '<div class="' + classPrefix + '-timeblock">' +
            '<div class="' + classPrefix + '-iconUp">' +
            '<button>' + i18n.previous + '</button>' +
            '</div>' +
            '<div class="' + classPrefix + '-label">' +
            '<span/>' +
            '<select class="' + classPrefix + '-' + type + '"/>' +
            '</div>' +
            '<div class="' + classPrefix + '-iconDown">' +
            '<button>' + i18n.next + '</button>' +
            '</div>' +
            '</div>';
    };

    var gap = function () {
        return '<span>:</span>';
    };

    // DOM structure
    var structure = $(
        '<div class="' + classPrefix + '">' +
        '<div class="' + classPrefix + '-date">' +
        '<div class="' + classPrefix + '-title">' +
        '<div class="' + classPrefix + '-iconLeft">' +
        '<button>' + i18n.previous + '</button>' +
        '</div>' +
        '<div class="' + classPrefix + '-iconRight">' +
        '<button>' + i18n.next + '</button>' +
        '</div>' +
        '<div class="' + classPrefix + '-label">' +
        '<span/>' +
        '<select class="' + classPrefix + '-month"/>' +
        '</div>' +
        '<div class="' + classPrefix + '-label">' +
        '<span/>' +
        '<select class="' + classPrefix + '-year"/>' +
        '</div>' +
        '</div>' +
        '<div class="' + classPrefix + '-calendar"/>' +
        '</div>' +
        '<div class="' + classPrefix + '-time">' +
        timeBlock('hours') +
        gap() +
        timeBlock('minutes') +
        gap() +
        timeBlock('seconds') +
        '<span>.</span>' +
        timeBlock('milliseconds') +
        timeBlock('ampm') +
        '</div>' +
        '<div class="' + classPrefix + '-error"/>' +
        '</div>'
    );

    this.dom = {
        container: structure,
        date: structure.find('.' + classPrefix + '-date'),
        title: structure.find('.' + classPrefix + '-title'),
        calendar: structure.find('.' + classPrefix + '-calendar'),
        time: structure.find('.' + classPrefix + '-time'),
        error: structure.find('.' + classPrefix + '-error'),
        input: $(input)
    };

    this.s = {
        /** @type {Date} Date value that the picker has currently selected */
        d: null,

        /** @type {Date} Date of the calendar - might not match the value */
        display: null,

        /** @type {String} Unique namespace string for this instance */
        namespace: 'editor-dateime-' + ($.fn.DataTable.Editor.DateTime._instance++),

        /** @type {Object} Parts of the picker that should be shown */
        parts: {
            date: this.c.format.match(/[YMD]|L(?!T)|l/) !== null,
            time: this.c.format.match(/[Hhm]|LT|LTS/) !== null,
            hours: this.c.format.match(/[HH]|[hh]/) !== null,
            seconds: this.c.format.indexOf('s') !== -1,
            milliseconds: this.c.format.indexOf('SSS') !== -1,
            hours12: this.c.format.match(/[haA]/) !== null
        }
    };

    this.dom.container
        .append(this.dom.date)
        .append(this.dom.time)
        .append(this.dom.error);

    this.dom.date
        .append(this.dom.title)
        .append(this.dom.calendar);

    this._constructor();
};

$.fn.DataTable.Editor.DateTime.prototype = $.extend(true, {}, $.fn.DataTable.Editor.DateTime.prototype, {
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Public
     */

    /**
     * Destroy the control
     */
    destroy: function () {
        this._hide();
        this.dom.container.off().empty();
        this.dom.input.off('.editor-datetime');
    },

    errorMsg: function (msg) {
        var error = this.dom.error;

        if (msg) {
            error.html(msg);
        } else {
            error.empty();
        }
    },

    hide: function () {
        this._hide();
    },

    max: function (date) {
        this.c.maxDate = date;

        this._optionsTitle();
        this._setCalander();
    },

    min: function (date) {
        this.c.minDate = date;

        this._optionsTitle();
        this._setCalander();
    },

    /**
     * Check if an element belongs to this control
     *
     * @param  {node} node Element to check
     * @return {boolean}   true if owned by this control, false otherwise
     */
    owns: function (node) {
        return $(node).parents().filter(this.dom.container).length > 0;
    },

    /**
     * Get / set the value
     *
     * @param  {string|Date} set   Value to set
     * @param  {boolean} [write=true] Flag to indicate if the formatted value
     *   should be written into the input element
     */
    val: function (set, write) {
        if (set === undefined) {
            return this.s.d;
        }

        if (set instanceof Date) {
            this.s.d = this._dateToUtc(set);
        } else if (set === null || set === '') {
            this.s.d = null;
        } else if (typeof set === 'string') {
            if (window.moment) {
                // Use moment if possible (even for ISO8601 strings, since it
                // will correctly handle 0000-00-00 and the like)
                var m = window.moment.utc(set, this.c.format, this.c.momentLocale, this.c.momentStrict);
                this.s.d = m.isValid() ? m.toDate() : null;
            } else {
                // Else must be using ISO8601 without moment (constructor would
                // have thrown an error otherwise)
                var match = set.match(/(\d{4})\-(\d{2})\-(\d{2})/);
                this.s.d = match ?
                    new Date(Date.UTC(match[1], match[2] - 1, match[3])) :
                    null;
            }
        }

        if (write || write === undefined) {
            if (this.s.d) {
                this._writeOutput();
            } else {
                // The input value was not valid...
                this.dom.input.val(set);
            }
        }

        // We need a date to be able to display the calendar at all
        if (!this.s.d) {
            this.s.d = this._dateToUtc(new Date());
        }

        this.s.display = new Date(this.s.d.toString());

        // Set the day of the month to be 1 so changing between months doesn't
        // run into issues when going from day 31 to 28 (for example)
        this.s.display.setUTCDate(1);

        // Update the display elements for the new value
        this._setTitle();
        this._setCalander();
        this._setTime();
    },


    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Constructor
     */

    /**
     * Build the control and assign initial event handlers
     *
     * @private
     */
    _constructor: function () {
        var that = this;
        var classPrefix = this.c.classPrefix;
        var container = this.dom.container;
        var i18n = this.c.i18n;
        var onChange = this.c.onChange;
        if (!this.s.parts.date) {
            this.dom.date.css('display', 'none');
        }

        if (!this.s.parts.time) {
            this.dom.time.css('display', 'none');
        }

        /*
         * Adding in these new sections might cause issues,
         * as removing an element could cause the order to became an issue.
         * For example removing element 2, is element 3 still 3 or position 2 now?
         */
        //NEW
        if (!this.s.parts.milliseconds) {
            this.dom.time.children('div.editor-datetime-timeblock').eq(3).remove();
            this.dom.time.children('span').eq(2).remove();
        }

        if (!this.s.parts.seconds) {
            this.dom.time.children('div.editor-datetime-timeblock').eq(2).remove();
            this.dom.time.children('span').eq(1).remove();
        }

        if (!this.s.parts.hours12) {
            this.dom.time.children('div.editor-datetime-timeblock').last().remove();
        }

        //NEW
        if (!this.s.parts.hours) {
            this.dom.time.children('div.editor-datetime-timeblock').first().remove();
            this.dom.time.children('span').first().remove();
        }

        // Render the options
        this._optionsTitle();
        this._optionsTime('hours', this.s.parts.hours12 ? 12 : 24, 1);
        this._optionsTime('minutes', 60, this.c.minutesIncrement);
        this._optionsTime('seconds', 60, this.c.secondsIncrement);
        this._optionsTime('milliseconds', 999, 50);
        this._options('ampm', ['am', 'pm'], i18n.amPm);

        // Trigger the display of the widget when clicking or focusing on the
        // input element
        this.dom.input
            .on('focus.editor-datetime click.editor-datetime', function () {
                // If already visible - don't do anything
                if (that.dom.container.is(':visible') || that.dom.input.is(':disabled')) {
                    return;
                }

                // In case the value has changed by text
                that.val(that.dom.input.val(), false);

                that._show();
            })
            .on('keyup.editor-datetime', function () {
                // Update the calendar's displayed value as the user types
                if (that.dom.container.is(':visible')) {
                    that.val(that.dom.input.val(), false);
                }
            });

        // Main event handlers for input in the widget
        this.dom.container
            .on('change', 'select', function () {
                var select = $(this);
                var val = select.val();

                if (select.hasClass(classPrefix + '-month')) {
                    // Month select
                    that._correctMonth(that.s.display, val);
                    that._setTitle();
                    that._setCalander();
                } else if (select.hasClass(classPrefix + '-year')) {
                    // Year select
                    that.s.display.setUTCFullYear(val);
                    that._setTitle();
                    that._setCalander();
                } else if (select.hasClass(classPrefix + '-hours') || select.hasClass(classPrefix + '-ampm')) {
                    // Hours - need to take account of AM/PM input if present
                    if (that.s.parts.hours12) {
                        var hours = $(that.dom.container).find('.' + classPrefix + '-hours').val() * 1;
                        var pm = $(that.dom.container).find('.' + classPrefix + '-ampm').val() === 'pm';

                        that.s.d.setUTCHours(hours === 12 && !pm ?
                            0 :
                            pm && hours !== 12 ?
                                hours + 12 :
                                hours
                        );
                    } else {
                        that.s.d.setUTCHours(val);
                    }

                    that._setTime();
                    that._writeOutput(true);

                    onChange();
                } else if (select.hasClass(classPrefix + '-minutes')) {
                    // Minutes select
                    that.s.d.setUTCMinutes(val);
                    that._setTime();
                    that._writeOutput(true);

                    onChange();
                } else if (select.hasClass(classPrefix + '-seconds')) {
                    // Seconds select
                    that.s.d.setSeconds(val);
                    that._setTime();
                    that._writeOutput(true);

                    onChange();
                } else if (select.hasClass(classPrefix + '-milliseconds')) {
                    // Milliseconds select
                    that.s.d.setMilliseconds(val);
                    that._setTime();
                    that._writeOutput(true);

                    onChange();
                }

                that.dom.input.focus();
                that._position();
            })
            .on('click', function (e) {
                var nodeName = e.target.nodeName.toLowerCase();

                if (nodeName === 'select') {
                    return;
                }

                e.stopPropagation();

                if (nodeName === 'button') {
                    var button = $(e.target);
                    var parent = button.parent();
                    var select;

                    if (parent.hasClass('disabled')) {
                        return;
                    }

                    if (parent.hasClass(classPrefix + '-iconLeft')) {
                        // Previous month
                        that.s.display.setUTCMonth(that.s.display.getUTCMonth() - 1);
                        that._setTitle();
                        that._setCalander();

                        that.dom.input.focus();
                    } else if (parent.hasClass(classPrefix + '-iconRight')) {
                        // Next month
                        that._correctMonth(that.s.display, that.s.display.getUTCMonth() + 1);
                        that._setTitle();
                        that._setCalander();

                        that.dom.input.focus();
                    } else if (parent.hasClass(classPrefix + '-iconUp')) {
                        // Value increase - common to all time selects
                        select = parent.parent().find('select')[0];
                        select.selectedIndex = select.selectedIndex !== select.options.length - 1 ?
                            select.selectedIndex + 1 :
                            0;
                        $(select).change();
                    } else if (parent.hasClass(classPrefix + '-iconDown')) {
                        // Value decrease - common to all time selects
                        select = parent.parent().find('select')[0];
                        select.selectedIndex = select.selectedIndex === 0 ?
                            select.options.length - 1 :
                            select.selectedIndex - 1;
                        $(select).change();
                    } else {
                        // Calendar click
                        if (!that.s.d) {
                            that.s.d = that._dateToUtc(new Date());
                        }

                        // Can't be certain that the current day will exist in
                        // the new month, and likewise don't know that the
                        // new day will exist in the old month, But 1 always
                        // does, so we can change the month without worry of a
                        // recalculation being done automatically by `Date`
                        that.s.d.setUTCDate(1);
                        that.s.d.setUTCFullYear(button.data('year'));
                        that.s.d.setUTCMonth(button.data('month'));
                        that.s.d.setUTCDate(button.data('day'));

                        that._writeOutput(true);

                        // Don't hide if there is a time picker, since we want to
                        // be able to select a time as well.
                        if (!that.s.parts.time) {
                            // This is annoying but IE has some kind of async
                            // behaviour with focus and the focus from the above
                            // write would occur after this hide - resulting in the
                            // calendar opening immediately
                            setTimeout(function () {
                                that._hide();
                            }, 10);
                        } else {
                            that._setCalander();
                        }

                        onChange();
                    }
                } else {
                    // Click anywhere else in the widget - return focus to the
                    // input element
                    that.dom.input.focus();
                }
            });
    },


    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Private
     */

    /**
     * Compare the date part only of two dates - this is made super easy by the
     * toDateString method!
     *
     * @param  {Date} a Date 1
     * @param  {Date} b Date 2
     * @private
     */
    _compareDates: function (a, b) {
        // Can't use toDateString as that converts to local time
        return this._dateToUtcString(a) === this._dateToUtcString(b);
    },

    /**
     * When changing month, take account of the fact that some months don't have
     * the same number of days. For example going from January to February you
     * can have the 31st of Jan selected and just add a month since the date
     * would still be 31, and thus drop you into March.
     *
     * @param  {Date} date  Date - will be modified
     * @param  {integer} month Month to set
     * @private
     */
    _correctMonth: function (date, month) {
        var days = this._daysInMonth(date.getUTCFullYear(), month);
        var correctDays = date.getUTCDate() > days;

        date.setUTCMonth(month);

        if (correctDays) {
            date.setUTCDate(days);
            date.setUTCMonth(month);
        }
    },

    /**
     * Get the number of days in a method. Based on
     * http://stackoverflow.com/a/4881951 by Matti Virkkunen
     *
     * @param  {integer} year  Year
     * @param  {integer} month Month (starting at 0)
     * @private
     */
    _daysInMonth: function (year, month) {
        //
        var isLeap = ((year % 4) === 0 && ((year % 100) !== 0 || (year % 400) === 0));
        var months = [31, (isLeap ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        return months[month];
    },

    /**
     * Create a new date object which has the UTC values set to the local time.
     * This allows the local time to be used directly for the library which
     * always bases its calculations and display on UTC.
     *
     * @param  {Date} s Date to "convert"
     * @return {Date}   Shifted date
     */
    _dateToUtc: function (s) {
        return new Date(Date.UTC(
            s.getFullYear(), s.getMonth(), s.getDate(),
            s.getHours(), s.getMinutes(), s.getSeconds()
        ));
    },

    /**
     * Create a UTC ISO8601 date part from a date object
     *
     * @param  {Date} d Date to "convert"
     * @return {string} ISO formatted date
     */
    _dateToUtcString: function (d) {
        return d.getUTCFullYear() + '-' +
            this._pad(d.getUTCMonth() + 1) + '-' +
            this._pad(d.getUTCDate());
    },

    /**
     * Hide the control and remove events related to its display
     *
     * @private
     */
    _hide: function () {
        var namespace = this.s.namespace;

        this.dom.container.detach();

        $(window).off('.' + namespace);
        $(document).off('keydown.' + namespace);
        $('div.DTE_Body_Content').off('scroll.' + namespace);
        $('body').off('click.' + namespace);
    },

    /**
     * Convert a 24 hour value to a 12 hour value
     *
     * @param  {integer} val 24 hour value
     * @return {integer}     12 hour value
     * @private
     */
    _hours24To12: function (val) {
        return val === 0 ?
            12 :
            val > 12 ?
                val - 12 :
                val;
    },

    /**
     * Generate the HTML for a single day in the calendar - this is basically
     * and HTML cell with a button that has data attributes so we know what was
     * clicked on (if it is clicked on) and a bunch of classes for styling.
     *
     * @param  {object} day Day object from the `_htmlMonth` method
     * @return {string}     HTML cell
     */
    _htmlDay: function (day) {
        if (day.empty) {
            return '<td class="empty"></td>';
        }

        var classes = ['day'];
        var classPrefix = this.c.classPrefix;

        if (day.disabled) {
            classes.push('disabled');
        }

        if (day.today) {
            classes.push('today');
        }

        if (day.selected) {
            classes.push('selected');
        }

        return '<td data-day="' + day.day + '" class="' + classes.join(' ') + '">' +
            '<button class="' + classPrefix + '-button ' + classPrefix + '-day" type="button" ' + 'data-year="' + day.year + '" data-month="' + day.month + '" data-day="' + day.day + '">' +
            day.day +
            '</button>' +
            '</td>';
    },


    /**
     * Create the HTML for a month to be displayed in the calendar table.
     *
     * Based upon the logic used in Pikaday - MIT licensed
     * Copyright (c) 2014 David Bushell
     * https://github.com/dbushell/Pikaday
     *
     * @param  {integer} year  Year
     * @param  {integer} month Month (starting at 0)
     * @return {string} Calendar month HTML
     * @private
     */
    _htmlMonth: function (year, month) {
        var now = this._dateToUtc(new Date()),
            days = this._daysInMonth(year, month),
            before = new Date(Date.UTC(year, month, 1)).getUTCDay(),
            data = [],
            row = [];

        if (this.c.firstDay > 0) {
            before -= this.c.firstDay;

            if (before < 0) {
                before += 7;
            }
        }

        var cells = days + before,
            after = cells;

        while (after > 7) {
            after -= 7;
        }

        cells += 7 - after;

        var minDate = this.c.minDate;
        var maxDate = this.c.maxDate;

        if (minDate) {
            minDate.setUTCHours(0);
            minDate.setUTCMinutes(0);
            minDate.setSeconds(0);
        }

        if (maxDate) {
            maxDate.setUTCHours(23);
            maxDate.setUTCMinutes(59);
            maxDate.setSeconds(59);
        }

        for (var i = 0, r = 0; i < cells; i++) {
            var day = new Date(Date.UTC(year, month, 1 + (i - before))),
                selected = this.s.d ? this._compareDates(day, this.s.d) : false,
                today = this._compareDates(day, now),
                empty = i < before || i >= (days + before),
                disabled = (minDate && day < minDate) ||
                    (maxDate && day > maxDate);

            var disableDays = this.c.disableDays;
            if ($.isArray(disableDays) && $.inArray(day.getUTCDay(), disableDays) !== -1) {
                disabled = true;
            } else if (typeof disableDays === 'function' && disableDays(day) === true) {
                disabled = true;
            }

            var dayConfig = {
                day: 1 + (i - before),
                month: month,
                year: year,
                selected: selected,
                today: today,
                disabled: disabled,
                empty: empty
            };

            row.push(this._htmlDay(dayConfig));

            if (++r === 7) {
                if (this.c.showWeekNumber) {
                    row.unshift(this._htmlWeekOfYear(i - before, month, year));
                }

                data.push('<tr>' + row.join('') + '</tr>');
                row = [];
                r = 0;
            }
        }

        var classPrefix = this.c.classPrefix;
        var className = classPrefix + '-table';
        if (this.c.showWeekNumber) {
            className += ' weekNumber';
        }

        // Show / hide month icons based on min/max
        if (minDate) {
            var underMin = minDate > new Date(Date.UTC(year, month - 1, 1, 0, 0, 0));

            this.dom.title.find('div.' + classPrefix + '-iconLeft')
                .css('display', underMin ? 'none' : 'block');
        }

        if (maxDate) {
            var overMax = maxDate < new Date(Date.UTC(year, month + 1, 1, 0, 0, 0));

            this.dom.title.find('div.' + classPrefix + '-iconRight')
                .css('display', overMax ? 'none' : 'block');
        }

        return '<table class="' + className + '">' +
            '<thead>' +
            this._htmlMonthHead() +
            '</thead>' +
            '<tbody>' +
            data.join('') +
            '</tbody>' +
            '</table>';
    },

    /**
     * Create the calendar table's header (week days)
     *
     * @return {string} HTML cells for the row
     * @private
     */
    _htmlMonthHead: function () {
        var a = [];
        var firstDay = this.c.firstDay;
        var i18n = this.c.i18n;

        // Take account of the first day shift
        var dayName = function (day) {
            day += firstDay;

            while (day >= 7) {
                day -= 7;
            }

            return i18n.weekdays[day];
        };

        // Empty cell in the header
        if (this.c.showWeekNumber) {
            a.push('<th></th>');
        }

        for (var i = 0; i < 7; i++) {
            a.push('<th>' + dayName(i) + '</th>');
        }

        return a.join('');
    },

    /**
     * Create a cell that contains week of the year - ISO8601
     *
     * Based on https://stackoverflow.com/questions/6117814/ and
     * http://techblog.procurios.nl/k/n618/news/view/33796/14863/
     *
     * @param  {integer} d Day of month
     * @param  {integer} m Month of year (zero index)
     * @param  {integer} y Year
     * @return {string}
     * @private
     */
    _htmlWeekOfYear: function (d, m, y) {
        var date = new Date(y, m, d, 0, 0, 0, 0);

        // First week of the year always has 4th January in it
        date.setDate(date.getDate() + 4 - (date.getDay() || 7));

        var oneJan = new Date(y, 0, 1);
        var weekNum = Math.ceil((((date - oneJan) / 86400000) + 1) / 7);

        return '<td class="' + this.c.classPrefix + '-week">' + weekNum + '</td>';
    },

    /**
     * Create option elements from a range in an array
     *
     * @param  {string} selector Class name unique to the select element to use
     * @param  {array} values   Array of values
     * @param  {array} [labels] Array of labels. If given must be the same
     *   length as the values parameter.
     * @private
     */
    _options: function (selector, values, labels) {
        if (!labels) {
            labels = values;
        }

        var select = this.dom.container.find('select.' + this.c.classPrefix + '-' + selector);
        select.empty();

        for (var i = 0, ien = values.length; i < ien; i++) {
            select.append('<option value="' + values[i] + '">' + labels[i] + '</option>');
        }
    },

    /**
     * Set an option and update the option's span pair (since the select element
     * has opacity 0 for styling)
     *
     * @param  {string} selector Class name unique to the select element to use
     * @param  {*}      val      Value to set
     * @private
     */
    _optionSet: function (selector, val) {
        var select = this.dom.container.find('select.' + this.c.classPrefix + '-' + selector);
        var span = select.parent().children('span');

        select.val(val);

        var selected = select.find('option:selected');
        span.html(selected.length !== 0 ?
            selected.text() :
            this.c.i18n.unknown
        );
    },

    /**
     * Create time option list. Can't just use `_options` for the time as the
     * hours can be a little complex and we want to be able to control the
     * increment option for the minutes and seconds.
     *
     * @param  {jQuery} select Select element to operate on
     * @param  {integer} count  Value to loop to
     * @param  {integer} inc    Increment value
     * @private
     */
    _optionsTime: function (select, count, inc) {
        var classPrefix = this.c.classPrefix;
        var sel = this.dom.container.find('select.' + classPrefix + '-' + select);
        var start = 0, end = count;
        var allowed = this.c.hoursAvailable;
        var render = count === 12 ?
            function (i) {
                return i;
            } : this._pad;

        if (count === 12) {
            start = 1;
            end = 13;
        }

        for (var i = start; i < end; i += inc) {
            if (!allowed || $.inArray(i, allowed) !== -1) {
                sel.append('<option value="' + i + '">' + render(i, count) + '</option>');
            }
        }
    },

    /**
     * Create the options for the month and year
     *
     * @param  {integer} year  Year
     * @param  {integer} month Month (starting at 0)
     * @private
     */
    _optionsTitle: function (year, month) {
        var classPrefix = this.c.classPrefix;
        var i18n = this.c.i18n;
        var min = this.c.minDate;
        var max = this.c.maxDate;
        var minYear = min ? min.getFullYear() : null;
        var maxYear = max ? max.getFullYear() : null;

        var i = minYear !== null ? minYear : new Date().getFullYear() - this.c.yearRange;
        var j = maxYear !== null ? maxYear : new Date().getFullYear() + this.c.yearRange;

        this._options('month', this._range(0, 11), i18n.months);
        this._options('year', this._range(i, j));
    },

    /**
     * Simple two digit pad
     *
     * @param  {integer} i      Value that might need padding
     * @param  {integer} total  Max integer allowed
     * @return {string|integer} Padded value
     * @private
     */
    _pad: function (i, total = 10) {
        /*
        if ((i.toString().length < total.toString().length)) {
            for (let j = 1; j < total.toString().length; j++) {
                i = '0' + i;
            }
        }
        */
        while (i.toString().length < total.toString().length) {
            i = '0' + i;
        }
        return i;
        //return i < 10 ? '0' + i : i;
    },

    /**
     * Position the calendar to look attached to the input element
     * @private
     */
    _position: function () {
        var offset = this.dom.input.offset();
        var container = this.dom.container;
        var inputHeight = this.dom.input.outerHeight();

        container
            .css({
                top: offset.top + inputHeight,
                left: offset.left
            })
            .appendTo('body');

        var calHeight = container.outerHeight();
        var calWidth = container.outerWidth();
        var scrollTop = $(window).scrollTop();

        // Correct to the bottom
        if (offset.top + inputHeight + calHeight - scrollTop > $(window).height()) {
            var newTop = offset.top - calHeight;

            container.css('top', newTop < 0 ? 0 : newTop);
        }

        // Correct to the right
        if (calWidth + offset.left > $(window).width()) {
            var newLeft = $(window).width() - calWidth;

            container.css('left', newLeft < 0 ? 0 : newLeft);
        }
    },

    /**
     * Create a simple array with a range of values
     *
     * @param  {integer} start Start value (inclusive)
     * @param  {integer} end   End value (inclusive)
     * @return {array}         Created array
     * @private
     */
    _range: function (start, end) {
        var a = [];

        for (var i = start; i <= end; i++) {
            a.push(i);
        }

        return a;
    },

    /**
     * Redraw the calendar based on the display date - this is a destructive
     * operation
     *
     * @private
     */
    _setCalander: function () {
        if (this.s.display) {
            this.dom.calendar
                .empty()
                .append(this._htmlMonth(
                    this.s.display.getUTCFullYear(),
                    this.s.display.getUTCMonth()
                ));
        }
    },

    /**
     * Set the month and year for the calendar based on the current display date
     *
     * @private
     */
    _setTitle: function () {
        this._optionSet('month', this.s.display.getUTCMonth());
        this._optionSet('year', this.s.display.getUTCFullYear());
    },

    /**
     * Set the time based on the current value of the widget
     *
     * @private
     */
    _setTime: function () {
        var d = this.s.d;
        var hours = d ? d.getUTCHours() : 0;

        if (this.s.parts.hours12) {
            this._optionSet('hours', this._hours24To12(hours));
            this._optionSet('ampm', hours < 12 ? 'am' : 'pm');
        } else {
            this._optionSet('hours', hours);
        }

        this._optionSet('minutes', d ? d.getUTCMinutes() : 0);
        this._optionSet('seconds', d ? d.getSeconds() : 0);
        this._optionSet('milliseconds', d ? d.getMilliseconds() : 0);
    },

    /**
     * Show the widget and add events to the document required only while it
     * is displayed
     *
     * @private
     */
    _show: function () {
        var that = this;
        var namespace = this.s.namespace;

        this._position();

        // Need to reposition on scroll
        $(window).on('scroll.' + namespace + ' resize.' + namespace, function () {
            that._position();
        });

        $('div.DTE_Body_Content').on('scroll.' + namespace, function () {
            that._position();
        });

        // On tab focus will move to a different field (no keyboard navigation
        // in the date picker - this might need to be changed).
        // On esc the Editor might close. Even if it doesn't the date picker
        // should
        $(document).on('keydown.' + namespace, function (e) {
            if (
                e.keyCode === 9 || // tab
                e.keyCode === 27 || // esc
                e.keyCode === 13    // return
            ) {
                that._hide();
            }
        });

        // Hide if clicking outside of the widget - but in a different click
        // event from the one that was used to trigger the show (bubble and
        // inline)
        setTimeout(function () {
            $('body').on('click.' + namespace, function (e) {
                var parents = $(e.target).parents();

                if (!parents.filter(that.dom.container).length && e.target !== that.dom.input[0]) {
                    that._hide();
                }
            });
        }, 10);
    },

    /**
     * Write the formatted string to the input element this control is attached
     * to
     *
     * @private
     */
    _writeOutput: function (focus) {
        var date = this.s.d;

        // Use moment if possible - otherwise it must be ISO8601 (or the
        // constructor would have thrown an error)
        var out = window.moment ?
            window.moment.utc(date, undefined, this.c.momentLocale, this.c.momentStrict).format(this.c.format) :
            date.getUTCFullYear() + '-' +
            this._pad(date.getUTCMonth() + 1) + '-' +
            this._pad(date.getUTCDate());
        this.dom.input.val(out);

        if (focus) {
            this.dom.input.focus();
        }
    }
});

/**
 * Defaults for the date time picker
 *
 * @type {Object}
 */
$.fn.DataTable.Editor.DateTime.defaults = {
    // Not documented - could be an internal property
    classPrefix: 'editor-datetime',

    // function or array of ints
    disableDays: null,

    // first day of the week (0: Sunday, 1: Monday, etc)
    firstDay: 1,

    format: 'YYYY-MM-DD',

    hoursAvailable: null,

    // Not documented as i18n is done by the Editor.defaults.i18n obj
    i18n: $.fn.DataTable.Editor.defaults.i18n.datetime,

    maxDate: null,

    minDate: null,

    minutesIncrement: 1,

    momentStrict: true,

    momentLocale: 'en',

    onChange: function () {
    },

    secondsIncrement: 1,

    // show the ISO week number at the head of the row
    showWeekNumber: false,

    // overruled by max / min date
    yearRange: 10
};