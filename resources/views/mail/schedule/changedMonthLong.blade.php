<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Schedule Changed</title>
</head>
<body style="background-color: #e5e7eb">
  <table style="width: 100%; border-radius: 4px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1)" cellpadding="0" cellspacing="0" role="none">
    <tr>
      <td style="background-color: #9ca3af; padding: 8px; text-align: center; color: #1f2937">
        <h2 style="font-size: 24px; font-weight: 700">Schedule changed</h2>
      </td>
    </tr>
    <tr>
      <td style="background-color: #fffffe; padding: 8px">
        <p>
          Hallo {{$user->firstName}} {{$user->lastName}},
        </p>
        <p>
          Dein Dienstplan für {{$date->format('F')}} {{$date->format('Y')}} wurde angepasst. Dein neuer Dienstplan sieht wie folgt aus:
        </p>
        <table style="width: 100%; table-layout: fixed; border-collapse: collapse" cellpadding="0" cellspacing="0" role="none">
          <tr>
            <td style="border: 1px solid #000001; text-align: center">1</td>
            <td style="border: 1px solid #000001; text-align: center">2</td>
            <td style="border: 1px solid #000001; text-align: center">3</td>
            <td style="border: 1px solid #000001; text-align: center">4</td>
            <td style="border: 1px solid #000001; text-align: center">5</td>
            <td style="border: 1px solid #000001; text-align: center">6</td>
            <td style="border: 1px solid #000001; text-align: center">7</td>
            <td style="border: 1px solid #000001; text-align: center">8</td>
            <td style="border: 1px solid #000001; text-align: center">9</td>
            <td style="border: 1px solid #000001; text-align: center">10</td>
            <td style="border: 1px solid #000001; text-align: center">11</td>
            <td style="border: 1px solid #000001; text-align: center">12</td>
            <td style="border: 1px solid #000001; text-align: center">13</td>
            <td style="border: 1px solid #000001; text-align: center">14</td>
            <td style="border: 1px solid #000001; text-align: center">15</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000001; text-align: center">{{ $schedule[1]['display'] }}</td>
            <td style="border: 1px solid #000001; text-align: center">{{ $schedule[2]['display'] }}</td>
            <td style="border: 1px solid #000001; text-align: center">{{ $schedule[3]['display'] }}</td>
            <td style="border: 1px solid #000001; text-align: center">{{ $schedule[4]['display'] }}</td>
            <td style="border: 1px solid #000001; text-align: center">{{ $schedule[5]['display'] }}</td>
            <td style="border: 1px solid #000001; text-align: center">{{ $schedule[6]['display'] }}</td>
            <td style="border: 1px solid #000001; text-align: center">{{ $schedule[7]['display'] }}</td>
            <td style="border: 1px solid #000001; text-align: center">{{ $schedule[8]['display'] }}</td>
            <td style="border: 1px solid #000001; text-align: center">{{ $schedule[9]['display'] }}</td>
            <td style="border: 1px solid #000001; text-align: center">{{ $schedule[10]['display'] }}</td>
            <td style="border: 1px solid #000001; text-align: center">{{ $schedule[11]['display'] }}</td>
            <td style="border: 1px solid #000001; text-align: center">{{ $schedule[12]['display'] }}</td>
            <td style="border: 1px solid #000001; text-align: center">{{ $schedule[13]['display'] }}</td>
            <td style="border: 1px solid #000001; text-align: center">{{ $schedule[14]['display'] }}</td>
            <td style="border: 1px solid #000001; text-align: center">{{ $schedule[15]['display'] }}</td>
          </tr>
          <tr>
            <td style="border: 1px solid #000001; text-align: center">16</td>
            <td style="border: 1px solid #000001; text-align: center">17</td>
            <td style="border: 1px solid #000001; text-align: center">18</td>
            <td style="border: 1px solid #000001; text-align: center">19</td>
            <td style="border: 1px solid #000001; text-align: center">20</td>
            <td style="border: 1px solid #000001; text-align: center">21</td>
            <td style="border: 1px solid #000001; text-align: center">22</td>
            <td style="border: 1px solid #000001; text-align: center">23</td>
            <td style="border: 1px solid #000001; text-align: center">24</td>
            <td style="border: 1px solid #000001; text-align: center">25</td>
            <td style="border: 1px solid #000001; text-align: center">26</td>
            <td style="border: 1px solid #000001; text-align: center">27</td>
            <td style="border: 1px solid #000001; text-align: center">28</td>
            <td style="border: 1px solid #000001; text-align: center">29</td>
            <td style="border: 1px solid #000001; text-align: center">30</td>
            <td style="border: 1px solid #000001; text-align: center">31</td>
          </tr>
          <td style="border: 1px solid #000001; text-align: center">{{ $schedule[16]['display'] }}</td>
          <td style="border: 1px solid #000001; text-align: center">{{ $schedule[17]['display'] }}</td>
          <td style="border: 1px solid #000001; text-align: center">{{ $schedule[18]['display'] }}</td>
          <td style="border: 1px solid #000001; text-align: center">{{ $schedule[19]['display'] }}</td>
          <td style="border: 1px solid #000001; text-align: center">{{ $schedule[20]['display'] }}</td>
          <td style="border: 1px solid #000001; text-align: center">{{ $schedule[21]['display'] }}</td>
          <td style="border: 1px solid #000001; text-align: center">{{ $schedule[22]['display'] }}</td>
          <td style="border: 1px solid #000001; text-align: center">{{ $schedule[23]['display'] }}</td>
          <td style="border: 1px solid #000001; text-align: center">{{ $schedule[24]['display'] }}</td>
          <td style="border: 1px solid #000001; text-align: center">{{ $schedule[25]['display'] }}</td>
          <td style="border: 1px solid #000001; text-align: center">{{ $schedule[26]['display'] }}</td>
          <td style="border: 1px solid #000001; text-align: center">{{ $schedule[27]['display'] }}</td>
          <td style="border: 1px solid #000001; text-align: center">{{ $schedule[28]['display'] }}</td>
          <td style="border: 1px solid #000001; text-align: center">{{ $schedule[29]['display'] }}</td>
          <td style="border: 1px solid #000001; text-align: center">{{ $schedule[30]['display'] }}</td>
          <td style="border: 1px solid #000001; text-align: center">{{ $schedule[31]['display'] }}</td>
          <tr>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="background-color: #fffffe; padding: 8px">
        Gehe zu Dienstplan für <a href="{{$_ENV['APP_URL']}}/schedule/{{$date->format('Y')}}/{{$date->format('m')}}">{{$date->format('F')}} {{$date->format('Y')}}</a>
      </td>
    </tr>
  </table>
</body>
</html>