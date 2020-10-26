<!DOCTYPE html>
<html lang="en">
<head>
     <title>Confirm Email</title>
</head>
<body>
    <table>
      <tr><td>Dear {{$name}}</td></tr>
      <tr><td>&nbsp;</td></tr>
      <tr>
        <td>Please click on below link to activate your account:<br/>
       </td>
      </tr>
      <tr><td>&nbsp;</td></tr>
      <tr><td><a href="{{url('confirm/'.$code)}}">Confirm Acount</a></td></tr>
      <tr><td>&nbsp;</td></tr>
      <tr><td>Thanks & Regards, </td></tr>
      <tr><td>E-com Website</td></tr>

    </table>
</body>
</html>
