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
            <th style="background-color: #c29a45; color:white; text-align: center;">رقم الفرع</th>
            <th width="25" style="background-color: #c29a45; color:white; text-align: center;">اسم الفرع</th>
            <th width="15" style="background-color: #c29a45; color:white; text-align: center;">القيمة الإجمالية</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($sales[0] as $sale)
          <tr style="background-color: #f2f2f2;">
                <td style="border: 1px solid #ddd; text-align: center;">{{ $sale['number'] }}</td>
                <td width="25" style="border: 1px solid #ddd; text-align: center;">{{ $sale['branch'] }}</td>
                <td width="15" style="border: 1px solid #ddd; text-align: center;">{{ $sale['total_Sales'] }}</td>
          </tr>
          @endforeach
          <tr style="background-color: #f2f2f2;">
            <td style="background-color: #c29a45; color:white; text-align: center;">الإجمالي</td>
            <td colspan="2" style="border: 1px solid #ddd; text-align: center;">{{ $sales[1][0]['total'] }}</td>
          </tr>
        </tbody>
      </table>
      

</body>
</html>