<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>
    @if ($type == "Account Ledger Report?" || $type == "Aging Sheet - Creditors" || $type == "Aging Sheet - Debitors")
        <div>
            <p style='margin-bottom: 2px'>
                <span style='font-weight: bold;display: inline-block;width: 80px;'>A/C Title</span>
                <span style='font-family: tahoma;'>{{$accTitle}}"</span>
            </p>

            <p style='margin-bottom: 2px'>
                <span style='font-weight: bold;display: inline-block;width: 80px;'>A/C Code</span>
                <span style='font-family: tahoma;'>{{$accCode}}"</span>
            </p>

            <p style='margin-bottom: 2px'>
                <span style='font-weight: bold;display: inline-block;width: 80px;'>Address</span>
                <span style='font-family: tahoma;'>{{$contactNo}}</span>
            </p>

            <p style='margin-bottom: 2px'>
                <span style='font-weight: bold;display: inline-block;width: 80px;'>Contact #</span>
                <span style='font-family: tahoma;'>{{$contactNo}}</span>
            </p>
        </div>";
    @elseif ($type == "Cash Flow Statement" || $type == "Invoice Aging Report - Payables" || $type == "Invoice Aging Report - Receiveables" )
        <div>
            <p style='margin-bottom: 2px'>
                <span style='font-weight: bold;display: inline-block;width: 80px;'>A/C Title</span>
                <span style='font-family: tahoma;'>{{$accTitle}}</span>
            </p>
        </div>
    @else

    @endif

    <div style='text-align:center;'>
        <h3 style='text-align:center;border-bottom: 1px solid black;font-size: 24.5px;line-height: 40px;margin: 10px 0;font-family: inherit;font-weight: bold;padding-bottom: 5px;color: inherit;text-rendering: optimizelegibility;'>{{$type}}</h3>

        <p style='text-align:center;'>
            <span>
                <strong>From:-</strong>
                <span>{{$fromDate}}</span>
            </span> To
            <span>
                <strong>To:-</strong>
                <span>{{$toDate}}</span>
            </span>
        </p>
    </div>
    <div>
        {{$table}}
    </div>
</div>
<style>
    table, th, td {
        border: 1px solid black;
    }
</style>
</body>
</html>
