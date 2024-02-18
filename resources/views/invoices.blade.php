<!DOCTYPE html>
<html>
  <style>
    table {
  border-collapse: collapse;
  width: 100%;
}

table th,
table td {
  border: 1px solid #ddd;
  padding: 8px;
}

table th {
  background-color: #337ab7;
  color: white;
}

table tr:nth-child(even) {
  background-color: #f2f2f2;
}
    </style>
</head>
<body>

    <table>
        <thead>
          <tr>
            <th style="background-color: #c29a45; color:white; text-align: center;">رقم الفاتورة</th>
            <th width="25" style="background-color: #c29a45; color:white; text-align: center;">التاريخ</th>
            <th width="15" style="background-color: #c29a45; color:white; text-align: center;">القيمة الإجمالية</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($invoices as $invoice)
              <tr style="background-color: #f2f2f2;">
                <td style="border: 1px solid #ddd; text-align: center;">{{ $invoice->Number }}</td>
                <td width="25" style="border: 1px solid #ddd; text-align: center;">{{ $invoice->Date }}</td>
                <td width="15" style="border: 1px solid #ddd; text-align: center;">{{ $invoice->Total }}</td>
              </tr>
          @endforeach
        </tbody>
      </table>
      

</body>
</html>