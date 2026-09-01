<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Schichtbericht {{ $shift->name }}</title>
</head>
<body style="background-color: #e5e7eb">
  <table style="width: 100%; border-radius: 4px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1)" cellpadding="0" cellspacing="0" role="none">
    <tr>
      <td style="background-color: #9ca3af; padding: 8px; text-align: center; color: #1f2937">
        <h2 style="font-size: 24px; font-weight: 700">Schichtbericht {{ $shift->name }}</h2>
      </td>
    </tr>
    <tr>
      <td style="background-color: #fffffe; padding: 8px">
        <p>
          Schichtbericht für {{ $shift->name }} im {{ $monthLabel }}.
        </p>
        @if (count($rows) === 0)
          <p>
            Für diese Schicht sind in diesem Monat keine Einträge vorhanden.
          </p>
        @else
          <table style="width: 100%; border-collapse: collapse" cellpadding="0" cellspacing="0" role="none">
            <tr>
              <td style="border: 1px solid #000001; padding: 8px; font-weight: 700">Datum</td>
              <td style="border: 1px solid #000001; padding: 8px; font-weight: 700">Mitarbeiter</td>
            </tr>
            @foreach ($rows as $row)
              <tr>
                <td style="border: 1px solid #000001; padding: 8px; line-height: 2">
                  @foreach ($row['dates'] as $date)
                    <span style="display: inline-block; background-color: #e5e7eb; color: #1f2937; border: 1px solid #d1d5db; border-radius: 999px; padding: 4px 10px; margin: 2px 4px 2px 0; font-size: 13px; font-weight: 600; line-height: 1.4; white-space: nowrap;">{{ $date }}</span>
                  @endforeach
                </td>
                <td style="border: 1px solid #000001; padding: 8px">{{ $row['user'] }}</td>
              </tr>
            @endforeach
          </table>
        @endif
      </td>
    </tr>
  </table>
</body>
</html>
