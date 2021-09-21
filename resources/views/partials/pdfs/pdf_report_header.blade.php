<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
        <div style="border-radius: 10px; border: 1px solid black; width:100%; padding-left: 10px; margin-left: -2mm;">
            <table class="table-grid" cellspacing="0" width="100%" style="font-size: 13px; padding-top: 5px; padding-bottom: 5px;">
                <tr>
                    <td style="width: 300px;">
                        <div style=" float: left">
                            <img id="header-logo" class="py-1" src="{{URL::asset('images/carers_logo_high_res.jpg')}}" alt="" style="max-height:100px; max-width:290px"/>
                        </div>
                    </td>
                    <td>
                        <div style="font-size: 24px; font-family: inherit; font-weight: 500; line-height: 1.5; color: inherit; text-align: center; padding-top: 15px;">
                            <div style="margin-bottom: 0.75rem;">
                                <b>{{ $title }}</b>
                            </div>
                        </div>
                    </td>
                    <td style="width: 300px;">
                        <div style="float: right; padding: 1rem;">
                            <span style="float: right">{{ $now->format('l, d F Y') }}</span>
                            <br>
                            <span style="float: right">{{ $now->format('h:i A') }}</span>
                        </div>
                    </td>
                </tr>
                <tr>

                </tr>
            </table>
        </div>
    </body>
</html>