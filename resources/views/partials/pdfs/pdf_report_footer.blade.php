<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta charset="UTF-8">
            <script>
                function subst() {
                    var vars = {};
                    var query_strings_from_url = document.location.search.substring(1).split('&');
                    for (var query_string in query_strings_from_url) {
                        if (query_strings_from_url.hasOwnProperty(query_string)) {
                            var temp_var = query_strings_from_url[query_string].split('=', 2);
                            vars[temp_var[0]] = decodeURI(temp_var[1]);
                        }
                    }
                    var css_selector_classes = ['page', 'frompage', 'topage', 'webpage', 'section', 'subsection', 'date', 'isodate', 'time', 'title', 'doctitle', 'sitepage', 'sitepages'];
                    for (var css_class in css_selector_classes) {
                        if (css_selector_classes.hasOwnProperty(css_class)) {
                            var element = document.getElementsByClassName(css_selector_classes[css_class]);
                            for (var j = 0; j < element.length; ++j) {
                                element[j].textContent = vars[css_selector_classes[css_class]];
                            }
                        }
                    }
                }
            </script>
    </head>
    <body onload="subst()">
        <div style="width:100%; margin-left: -2mm; padding-left: 10px;"> <!-- border-radius: 10px; border: 1px solid black; -->
            <table cellspacing="0" width="100%" style="font-size: 13px;">
                <tr>
                    <td style="width: 25%">
                        <div style="margin-left: -10px;">
                            &copy; Merchant Factors {{$now->year}}
                        </div>
                    </td>
                    <td style="width: 50%;">

                    </td>
                    <td style="width: 25%;">
                        <div style="float: right;">
                            <span style="width: 100%; text-align: left;">
                                Page <span class="page"></span> of <span class="topage"></span>
                            </span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>