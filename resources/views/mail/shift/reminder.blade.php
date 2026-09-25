<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Schichterinnerung {{ $shift->name }}</title>
</head>
<body style="background-color: #e5e7eb">
  <table style="width: 100%; border-radius: 4px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1)" cellpadding="0" cellspacing="0" role="none">
    <tr>
      <td style="background-color: #9ca3af; padding: 8px; text-align: center; color: #1f2937">
        <h2 style="font-size: 24px; font-weight: 700">Schichterinnerung</h2>
      </td>
    </tr>
    <tr>
      <td style="background-color: #fffffe; padding: 8px">
        <p>
          Hallo {{ $user->firstName }} {{ $user->lastName }},
        </p>
        <p>
          du bist am {{ $dateLabel }} für die Schicht {{ $shift->name }} eingeteilt.
        </p>
        <p>
          Du kannst diese Erinnerung in den <a href="{{ $settingsUrl }}">Einstellungen</a> deaktivieren.
        </p>
      </td>
    </tr>
  </table>
</body>
</html>
